<?php

namespace App\Controller;

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
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER =>
            function ($membertypes) {
                return $membertypes->getId();
            },
            AbstractNormalizer::IGNORED_ATTRIBUTES => [
                '__initializer__', '__isInitialized__',
                '__cloner__', 'members'
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
        $jsonObject = $serializer->serialize($membertypes, 'json');
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/api/add-member-type", name="app_add_member_type", methods={"POST"})
     */
    public function addMemberType(Request $request)
    {

        $membertypeRequest = json_decode($request->getContent());
        $membertype = new MemberType();
        $membertype->setMemberTypeCode($membertypeRequest->MemberTypeCode)
            ->setMemberTypeLabel($membertypeRequest->MemberTypeLabel);


        $this->em->persist($membertype);
        $this->em->flush();

        return new JsonResponse("Member Type created", 200);
    }

    /**
     * @Route("/api/edit-member-type/{id}", name="app_edit_member_type", methods={"PUT"})
     */
    public function editMemberType(Request $request)
    {

        $membertypeRequest = json_decode($request->getContent());

        $membertype = $this->em->getRepository(MemberType::class)->find($request->get('id'));
        $membertype->setMemberTypeCode($membertypeRequest->MemberTypeCode)
            ->setMemberTypeLabel($membertypeRequest->MemberTypeLabel)
            ->setUpdateDate(new DateTime());
        $this->em->persist($membertype);
        $this->em->flush();

        return new JsonResponse("Member Type updated", 200);
    }

    /**
     * @Route("/api/delete-member-type/{id}", name="app_delete_member_type", methods={"DELETE"})
     */
    public function deleteMemberType(Request $request)
    {
        $membertype = $this->em->getRepository(MemberType::class)->find($request->get('id'));
        $this->em->remove($membertype);
        $this->em->flush();
        return new JsonResponse("Member Type deleted", 200);
    }
}
