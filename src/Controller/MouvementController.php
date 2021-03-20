<?php

namespace App\Controller;

use App\Entity\Mouvement;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MouvementController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/api/mouvements", name="app_mouvements_all", methods={"GET"})
     */
    public function getAllMouvements(): Response
    {
        $mouvements = $this->em->getRepository(Mouvement::class)->findAll();

        return $this->json($mouvements);
    }
    /**
     * @Route("/api/mouvements-fill", name="app_mouvements_fill", methods={"POST"})
     */
    public function fillAllMouvements(Request $request): Response
    {
        $file = $request->files->get('movments');
        $line = file($file);
        /*$fileCSV = fopen("csv/" . $file->getFilename() . ".txt", "w");
        fwrite($fileCSV, $line);
        fclose($fileCSV);
        chmod("csv/" . $file->getFilename() . ".txt", 0644);*/

        for ($i = 1; $i < sizeof($line) - 1; $i++) {

            //dump(strlen($line[$i]));
            $mouvement = new Mouvement();
            $mouvement->setOperationCode(substr($line[$i], 0, 2));
            $mouvement->setIsin(substr($line[$i], 2, 12));
            $StockExchangeDate = new DateTime();
            $AccountingDate = new DateTime();
            $mouvement->setStockExchangeDate($StockExchangeDate->setDate(substr($line[$i], 18, 4), substr($line[$i], 16, 2), substr($line[$i], 14, 2)));
            $mouvement->setAccountingDate($AccountingDate->setDate(substr($line[$i], 26, 4), substr($line[$i], 24, 2), substr($line[$i], 22, 2)));
            $mouvement->setDeliveryMemberCode(substr($line[$i], 30, 3));
            $mouvement->setDeliveryAccountType(substr($line[$i], 33, 2));
            $mouvement->setDeliveryCategoryCredit(substr($line[$i], 35, 3));
            $mouvement->setDeliveredMemberCode(substr($line[$i], 38, 3));
            $mouvement->setDeliveredAccountType(substr($line[$i], 41, 2));
            $mouvement->setDeliveredCategoryCredit(substr($line[$i], 43, 3));
            $mouvement->setTitlesNumber(substr($line[$i], 46, 10));
            $mouvement->setAmount(substr($line[$i], 56, 15));
            $this->em->persist($mouvement);
        }
        $this->em->flush();
        return $this->json('movement file uploded in database');
    }
}
