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
        $operation = $this->em->getRepository(Operation::class)->findByAll();

        return $this->json($operation);
    }

    /**
     * @Route("/api/delete-operation/{OperationCode}", name="app_delete_operation", methods={"DELETE"})
     */
    public function deleteOperation(Request $request)
    {
        $oc = $this->getDoctrine()->getRepository(Operation::class)->find($request->get('OperationCode'));
        $this->em->remove($oc);
        $this->em->flush();
        return $this->json('Operation Code deleted successfully');
    }
}
