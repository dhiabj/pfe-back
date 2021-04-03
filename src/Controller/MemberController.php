<?php

namespace App\Controller;

use App\Entity\Member;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MemberController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/api/members", name="app_members_all", methods={"GET"})
     */
    public function getAllMembers(): Response
    {
        $members = $this->em->getRepository(Member::class)->findByAll();

        return $this->json($members);
    }

    /**
     * @Route("/api/delete-member/{MembershipCode}", name="app_delete_member", methods={"DELETE"})
     */
    public function deleteMember(Request $request)
    {
        $member = $this->em->getRepository(Member::class)->find($request->get('MembershipCode'));
        if ($member) {
            $this->em->remove($member);
            $this->em->flush();
            return $this->json('Member deleted successfully');
        } else {
            return $this->json('Member not found');
        }
    }
}
