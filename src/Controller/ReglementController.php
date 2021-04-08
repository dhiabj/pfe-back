<?php

namespace App\Controller;

use App\Entity\Reglement;
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

class ReglementController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/api/reglements", name="app_reglements_all", methods={"GET"})
     */
    public function getReglements(): Response
    {
        $reglements = $this->em->getRepository(Reglement::class)->findAll();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER =>
            function ($reglements) {
                return $reglements->getId();
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
        $jsonObject = $serializer->serialize($reglements, 'json');
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/api/add-reglement", name="app_add_reglement", methods={"POST"})
     */
    public function addReglement(Request $request)
    {
        $reglementRequest = json_decode($request->getContent());
        $reglement = new Reglement();
        $reglement->setReglementCode($reglementRequest->ReglementCode)
            ->setReglementLabel($reglementRequest->ReglementLabel);
        $this->em->persist($reglement);
        $this->em->flush();
        return new JsonResponse("Reglement created", 200);
    }

    /**
     * @Route("/api/edit-reglement/{id}", name="app_edit_reglement", methods={"PUT"})
     */
    public function editReglement(Request $request)
    {
        $reglementRequest = json_decode($request->getContent());
        $reglement = $this->em->getRepository(Reglement::class)->find($request->get('id'));
        $reglement->setReglementCode($reglementRequest->ReglementCode)
            ->setReglementLabel($reglementRequest->ReglementLabel)
            ->setUpdateDate(new DateTime());
        $this->em->persist($reglement);
        $this->em->flush();
        return new JsonResponse("Reglement updated", 200);
    }

    /**
     * @Route("/api/delete-reglement/{id}", name="app_delete_reglement", methods={"DELETE"})
     */
    public function deleteReglement(Request $request)
    {
        $reglement = $this->em->getRepository(Reglement::class)->find($request->get('id'));
        $this->em->remove($reglement);
        $this->em->flush();
        return new JsonResponse("Reglement deleted", 200);
    }
}
