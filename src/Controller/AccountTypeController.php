<?php

namespace App\Controller;

use App\Entity\AccountType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $accounttypes = $this->em->getRepository(AccountType::class)->findByAll();

        return $this->json($accounttypes);
    }

    /**
     * @Route("/api/delete-account-type/{NatureCode}", name="app_delete_account_type", methods={"DELETE"})
     */
    public function deleteAccountType(Request $request)
    {
        $nc = $this->getDoctrine()->getRepository(AccountType::class)->find($request->get('NatureCode'));
        $this->em->remove($nc);
        $this->em->flush();
        return $this->json('Nature Code deleted successfully');
    }
}
