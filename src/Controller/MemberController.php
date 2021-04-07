<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\MemberType;
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
        $members = $this->em->getRepository(Member::class)->findAll();

        $defaultContext = [

            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER =>
            function ($members) {
                return $members->getId();
            },
            AbstractNormalizer::IGNORED_ATTRIBUTES => [
                '__initializer__', '__isInitialized__',
                '__cloner__', 'members', 'mouvements', 'mouvementl', 'stocks'
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
        $jsonObject = $serializer->serialize($members, 'json');
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/api/add-member", name="app_add_member", methods={"POST"})
     */
    public function addMember(Request $request)
    {

        $memberRequest = json_decode($request->getContent());
        $membertype = $this->em->getRepository(MemberType::class)->find($memberRequest->MemberTypeId);
        $member = new Member();
        $member->setMemberType($membertype)
            ->setMembershipCode($memberRequest->MembershipCode)
            ->setMemberName($memberRequest->MemberName);


        $this->em->persist($member);
        $this->em->flush();

        return new JsonResponse("Member created", 200);
    }

    /**
     * @Route("/api/edit-member/{id}", name="app_edit_member", methods={"PUT"})
     */
    public function editMember(Request $request)
    {

        $memberRequest = json_decode($request->getContent());

        $member = $this->em->getRepository(Member::class)->find($request->get('id'));
        $membertype = $this->em->getRepository(MemberType::class)->find($memberRequest->MemberTypeId);
        $member->setMembershipCode($memberRequest->MembershipCode)
            ->setMemberName($memberRequest->MemberName)
            ->setMemberType($membertype)
            ->setUpdateDate(new DateTime());
        $this->em->persist($member);
        $this->em->flush();

        return new JsonResponse("Member updated", 200);
    }

    /**
     * @Route("/api/delete-member/{id}", name="app_delete_member", methods={"DELETE"})
     */
    public function deleteMember(Request $request)
    {
        $member = $this->em->getRepository(Member::class)->find($request->get('id'));
        $this->em->remove($member);
        $this->em->flush();
        return new JsonResponse("Member deleted", 200);
    }
}
