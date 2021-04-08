<?php

namespace App\Controller;

use App\Entity\Operation;
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

class OperationController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/api/operations", name="app_operations_all", methods={"GET"})
     */
    public function getAllOperations(): Response
    {
        $operations = $this->em->getRepository(Operation::class)->findAll();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER =>
            function ($operations) {
                return $operations->getId();
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
        $jsonObject = $serializer->serialize($operations, 'json');
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/api/add-operation", name="app_add_operation", methods={"POST"})
     */
    public function addOperation(Request $request)
    {
        $operationRequest = json_decode($request->getContent());
        $operation = new Operation();
        $operation->setOperationCode($operationRequest->OperationCode)
            ->setOperationLabel($operationRequest->OperationLabel);
        $this->em->persist($operation);
        $this->em->flush();
        return new JsonResponse("Operation created", 200);
    }

    /**
     * @Route("/api/edit-operation/{id}", name="app_edit_operation", methods={"PUT"})
     */
    public function editOperation(Request $request)
    {
        $operationRequest = json_decode($request->getContent());
        $operation = $this->em->getRepository(Operation::class)->find($request->get('id'));
        $operation->setOperationCode($operationRequest->OperationCode)
            ->setOperationLabel($operationRequest->OperationLabel)
            ->setUpdateDate(new DateTime());
        $this->em->persist($operation);
        $this->em->flush();
        return new JsonResponse("Operation updated", 200);
    }

    /**
     * @Route("/api/delete-operation/{id}", name="app_delete_operation", methods={"DELETE"})
     */
    public function deleteOperation(Request $request)
    {
        $operation = $this->em->getRepository(Operation::class)->find($request->get('id'));
        $this->em->remove($operation);
        $this->em->flush();
        return new JsonResponse("Operation deleted successfully", 200);
    }
}
