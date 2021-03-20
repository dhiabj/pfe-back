<?php

namespace App\Controller;

use App\Entity\Stock;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StockController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/api/stocks", name="app_stock_all", methods={"GET"})
     */
    public function getAllStocks(): Response
    {

        $stocks = $this->em->getRepository(Stock::class)->findAll();

        return $this->json($stocks);
    }
    /**
     * @Route("/api/stocks-fill", name="app_stocks_fill", methods={"POST"})
     */
    public function fillAllStocks(Request $request): Response
    {
        $file = $request->files->get('stocks');
        $line = file($file);
        /*$fileCSV = fopen("csv/" . $file->getFilename() . ".txt", "w");
        fwrite($fileCSV, $line);
        fclose($fileCSV);
        chmod("csv/" . $file->getFilename() . ".txt", 0644);*/

        for ($i = 1; $i < sizeof($line) - 1; $i++) {

            //dump(strlen($line[$i]));
            $stock = new Stock();
            $stock->setMembershipCode(substr($line[$i], 0, 3));
            $stock->setIsin(substr($line[$i], 3, 12));
            $stock->setNatureCode(substr($line[$i], 15, 2));
            $stock->setCategoryCode(substr($line[$i], 17, 3));
            $stock->setQuantity(substr($line[$i], 20, 10));
            $stock->setDirection(substr($line[$i], 30, 1));
            $StockExchangeDate = new DateTime();
            $AccountingDate = new DateTime();
            $stock->setStockExchangeDate($StockExchangeDate->setDate(substr($line[$i], 35, 4), substr($line[$i], 33, 2), substr($line[$i], 31, 2)));
            $stock->setAccountingDate($AccountingDate->setDate(substr($line[$i], 43, 4), substr($line[$i], 41, 2), substr($line[$i], 39, 2)));
            $this->em->persist($stock);
        }
        $this->em->flush();
        return $this->json('stock file uploded in database');
    }
}
