<?php

namespace App\Controller;

use App\Entity\Stock;
use App\Entity\StockUploadTable;
use App\service\StockService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StockController extends AbstractController
{
    private $em;
    private $stockService;
    public function __construct(EntityManagerInterface $em, StockService $stockService)
    {
        $this->em = $em;
        $this->stockService = $stockService;
    }
    /**
     * @Route("/api/stocks", name="app_stock_all", methods={"GET"})
     */
    public function getAllStocks(Request $request): Response
    {
        $search = json_decode($request->get('search'));
        $stocks = $this->em->getRepository(Stock::class)->findByAll(
            $search->code_valeur,
            $search->code_adherent,
            $search->nature_compte,
            $search->accounting_date,
            $search->stock_exchange_date
        );

        return $this->json($stocks);
    }

    /**
     * @Route("/api/stock-upload-table", name="app_stock_upload_all", methods={"GET"})
     */
    public function getStockUploads(): Response
    {
        $stcktable = $this->em->getRepository(StockUploadTable::class)->findAll();

        return $this->json($stcktable);
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
            $this->stockService->AddStock($line, $i);
        }
        $this->em->flush();
        $filename = $file->getClientOriginalName();
        $nblines = count($line);
        $stcktable = new StockUploadTable();
        $stcktable->setFileName($filename);
        $stcktable->setStateFile('Fichier Traite');
        $stcktable->setNbLines($nblines);
        $stcktable->setUploadDate(new DateTime());
        $StockExchangeDate = new DateTime();
        $stcktable->setStockExchangeDate($StockExchangeDate->setDate(substr($line[1], 35, 4), substr($line[1], 33, 2), substr($line[1], 31, 2)));
        $this->em->persist($stcktable);
        $this->em->flush();
        return new JsonResponse("file uploded in database", 200);
    }

    /**
     * @Route("/api/delete-stock/{id}", name="app_delete_stock", methods={"DELETE"})
     */
    public function deleteMouvement(Request $request)
    {
        $stcktable = $this->em->getRepository(StockUploadTable::class)->find($request->get('id'));
        $this->em->remove($stcktable);
        $this->em->flush();
        return new JsonResponse("file deleted successfully", 200);
    }
}
