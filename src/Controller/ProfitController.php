<?php

namespace App\Controller;

use App\Entity\Profit;
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

class ProfitController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/api/profits", name="app_profits_all", methods={"GET"})
     */
    public function getProfits(): Response
    {
        $profits = $this->em->getRepository(Profit::class)->findAll();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER =>
            function ($profits) {
                return $profits->getId();
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
        $jsonObject = $serializer->serialize($profits, 'json');
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/api/add-profit", name="app_add_profit", methods={"POST"})
     */
    public function addMarket(Request $request)
    {
        $profitRequest = json_decode($request->getContent());
        $profit = new Profit();
        $profit->setProfitCode($profitRequest->ProfitCode)
            ->setProfitLabel($profitRequest->ProfitLabel);
        $this->em->persist($profit);
        $this->em->flush();
        return new JsonResponse("Profit created", 200);
    }

    /**
     * @Route("/api/edit-profit/{id}", name="app_edit_profit", methods={"PUT"})
     */
    public function editProfit(Request $request)
    {
        $profitRequest = json_decode($request->getContent());
        $profit = $this->em->getRepository(Profit::class)->find($request->get('id'));
        $profit->setProfitCode($profitRequest->ProfitCode)
            ->setProfitLabel($profitRequest->ProfitLabel)
            ->setUpdateDate(new DateTime());
        $this->em->persist($profit);
        $this->em->flush();
        return new JsonResponse("Profit updated", 200);
    }

    /**
     * @Route("/api/delete-profit/{id}", name="app_delete_profit", methods={"DELETE"})
     */
    public function deleteProfit(Request $request)
    {
        $profit = $this->em->getRepository(Profit::class)->find($request->get('id'));
        $this->em->remove($profit);
        $this->em->flush();
        return new JsonResponse("Profit deleted", 200);
    }
}
