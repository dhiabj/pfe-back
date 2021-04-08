<?php

namespace App\Controller;

use App\Entity\IntermAccount;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class IntermAccountController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/api/interm-accounts", name="app_interm_accounts_all", methods={"GET"})
     */
    public function getIntermAccounts(): Response
    {
        $intermAccounts = $this->em->getRepository(IntermAccount::class)->findAll();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER =>
            function ($intermAccounts) {
                return $intermAccounts->getId();
            },
            AbstractNormalizer::IGNORED_ATTRIBUTES => [
                '__initializer__', '__isInitialized__',
                '__cloner__', 'intermediaires'
            ]
        ];
        $encoders = [new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer(
            null,
            null,
            null,
            null,
            null,
            null,
            $defaultContext
        )];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonObject = $serializer->serialize($intermAccounts, 'json');
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/api/add-interm-account", name="app_add_interm_account", methods={"POST"})
     */
    public function addIntermAccount(Request $request)
    {
        $intermAccountRequest = json_decode($request->getContent());
        $intermAccount = new IntermAccount();
        $intermAccount->setAccountCode($intermAccountRequest->IntermAccountCode)
            ->setAccountLabel($intermAccountRequest->IntermAccountLabel);
        $this->em->persist($intermAccount);
        $this->em->flush();
        return new JsonResponse("Intermediaire Account created", 200);
    }

    /**
     * @Route("/api/edit-interm-account/{id}", name="app_edit_interm_account", methods={"PUT"})
     */
    public function editIntermAccount(Request $request)
    {
        $intermAccountRequest = json_decode($request->getContent());
        $intermAccount = $this->em->getRepository(IntermAccount::class)->find($request->get('id'));
        $intermAccount->setAccountCode($intermAccountRequest->IntermAccountCode)
            ->setAccountLabel($intermAccountRequest->IntermAccountLabel)
            ->setUpdateDate(new DateTime());
        $this->em->persist($intermAccount);
        $this->em->flush();
        return new JsonResponse("Intermediaire Account updated", 200);
    }

    /**
     * @Route("/api/delete-interm-account/{id}", name="app_delete_interm_account", methods={"DELETE"})
     */
    public function deleteIntermAccount(Request $request)
    {
        $intermAccount = $this->em->getRepository(IntermAccount::class)->find($request->get('id'));
        $this->em->remove($intermAccount);
        $this->em->flush();
        return new JsonResponse("Intermediaire Account deleted", 200);
    }
}
