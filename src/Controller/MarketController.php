<?php

namespace App\Controller;

use App\Entity\Market;
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

class MarketController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/api/markets", name="app_markets_all", methods={"GET"})
     */
    public function getMarkets(): Response
    {
        $markets = $this->em->getRepository(Market::class)->findAll();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER =>
            function ($markets) {
                return $markets->getId();
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
        $jsonObject = $serializer->serialize($markets, 'json');
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/api/add-market", name="app_add_market", methods={"POST"})
     */
    public function addMarket(Request $request)
    {
        $marketRequest = json_decode($request->getContent());
        $market = new Market();
        $market->setMarketCode($marketRequest->MarketCode)
            ->setMarketLabel($marketRequest->MarketLabel);
        $this->em->persist($market);
        $this->em->flush();
        return new JsonResponse("Market created", 200);
    }

    /**
     * @Route("/api/edit-market/{id}", name="app_edit_market", methods={"PUT"})
     */
    public function editMarket(Request $request)
    {
        $marketRequest = json_decode($request->getContent());
        $market = $this->em->getRepository(Market::class)->find($request->get('id'));
        $market->setMarketCode($marketRequest->MarketCode)
            ->setMarketLabel($marketRequest->MarketLabel)
            ->setUpdateDate(new DateTime());
        $this->em->persist($market);
        $this->em->flush();
        return new JsonResponse("Market updated", 200);
    }

    /**
     * @Route("/api/delete-market/{id}", name="app_delete_market", methods={"DELETE"})
     */
    public function deleteMarket(Request $request)
    {
        $market = $this->em->getRepository(Market::class)->find($request->get('id'));
        $this->em->remove($market);
        $this->em->flush();
        return new JsonResponse("Market deleted", 200);
    }
}
