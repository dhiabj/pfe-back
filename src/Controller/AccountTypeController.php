<?php

namespace App\Controller;

use App\Entity\AccountType;
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

class AccountTypeController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/api/account-types", name="app_account_types_all", methods={"GET"})
     */
    public function getAllAccountTypes(): Response
    {
        $accounttypes = $this->em->getRepository(AccountType::class)->findAll();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER =>
            function ($accounttypes) {
                return $accounttypes->getId();
            },
            AbstractNormalizer::IGNORED_ATTRIBUTES => [
                '__initializer__', '__isInitialized__',
                '__cloner__', 'mouvements', 'mouvementl', 'stocks'
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
        $jsonObject = $serializer->serialize($accounttypes, 'json');
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/api/add-account-type", name="app_add_account_type", methods={"POST"})
     */
    public function addAccountType(Request $request)
    {

        $accounttypeRequest = json_decode($request->getContent());
        $accounttype = new AccountType();
        $accounttype->setNatureCode($accounttypeRequest->AccountTypeCode)
            ->setNatureAccountLabel($accounttypeRequest->AccountTypeLabel);


        $this->em->persist($accounttype);
        $this->em->flush();

        return new JsonResponse("Account Type created", 200);
    }

    /**
     * @Route("/api/edit-account-type/{id}", name="app_edit_account_type", methods={"PUT"})
     */
    public function editAccountType(Request $request)
    {

        $accounttypeRequest = json_decode($request->getContent());
        $accounttype = $this->em->getRepository(AccountType::class)->find($request->get('id'));
        $accounttype->setNatureCode($accounttypeRequest->AccountTypeCode)
            ->setNatureAccountLabel($accounttypeRequest->AccountTypeLabel);
        $this->em->persist($accounttype);
        $this->em->flush();

        return new JsonResponse("Account Type updated", 200);
    }

    /**
     * @Route("/api/delete-account-type/{id}", name="app_delete_account_type", methods={"DELETE"})
     */
    public function deleteAccountType(Request $request)
    {
        $accounttype = $this->em->getRepository(AccountType::class)->find($request->get('id'));
        $this->em->remove($accounttype);
        $this->em->flush();
        return new JsonResponse("Account Type deleted", 200);
    }
}
