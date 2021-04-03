<?php

namespace App\Controller;

use App\Entity\Operation;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $operations = $this->em->getRepository(Operation::class)->findByAll();

        return $this->json($operations);
    }

    /**
     * @Route("/api/delete-operation/{OperationCode}", name="app_delete_operation", methods={"DELETE"})
     */
    public function deleteOperation(Request $request)
    {
        $operation = $this->em->getRepository(Operation::class)->find($request->get('OperationCode'));
        if ($operation) {
            $this->em->remove($operation);
            $this->em->flush();
            return $this->json('Operation deleted successfully');
        } else {
            return $this->json('Operation not found');
        }
    }
}
