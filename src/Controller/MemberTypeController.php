<?php

namespace App\Controller;

use App\Entity\MemberType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MemberTypeController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/api/member-types", name="app_member_types_all", methods={"GET"})
     */
    public function getAllMemberTypes(): Response
    {
        $membertypes = $this->em->getRepository(MemberType::class)->findAll();

        return $this->json($membertypes);
    }

    /**
     * @Route("/api/delete-member-type/{MemberTypeCode}", name="app_delete_member-type", methods={"DELETE"})
     */
    public function deleteMemberType(Request $request)
    {
        $membertype = $this->em->getRepository(MemberType::class)->find($request->get('MemberTypeCode'));
        if ($membertype) {
            $this->em->remove($membertype);
            $this->em->flush();
            return $this->json('Member Type deleted successfully');
        } else {
            return $this->json('Member Type not found');
        }
    }
}
