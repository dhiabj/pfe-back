<?php

namespace App\Controller;

use App\Entity\Mouvement;
use App\Entity\MvtUploadTable;
use App\service\MouvementService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MouvementController extends AbstractController
{
    private $em;
    private $mouvementService;
    public function __construct(EntityManagerInterface $em, MouvementService $mouvementService)
    {
        $this->em = $em;
        $this->mouvementService = $mouvementService;
    }
    /**
     * @Route("/api/mouvements", name="app_mouvements_all", methods={"GET"})
     */
    public function getAllMouvements(Request $request): Response
    {
        $search = json_decode($request->get('search'));
        $mouvements = $this->em->getRepository(Mouvement::class)->findByAll(
            $search->code_valeur,
            $search->code_adherent,
            $search->nature_compte,
            $search->accounting_date,
            $search->stock_exchange_date
        );
        return $this->json($mouvements);
    }

    /**
     * @Route("/api/mouvement-upload-table", name="app_mouvement_upload_all", methods={"GET"})
     */
    public function getMvtUploads(): Response
    {
        $mvtable = $this->em->getRepository(MvtUploadTable::class)->findAll();

        return $this->json($mvtable);
    }
    /**
     * @Route("/api/mouvements-fill", name="app_mouvements_fill", methods={"POST"})
     */
    public function fillAllMouvements(Request $request): Response
    {
        $file = $request->files->get('mouvements');
        $line = file($file);

        //dd($file);
        /*$fileCSV = fopen("csv/" . $file->getFilename() . ".txt", "w");
        fwrite($fileCSV, $line);
        fclose($fileCSV);
        chmod("csv/" . $file->getFilename() . ".txt", 0644);*/

        for ($i = 1; $i < sizeof($line) - 1; $i++) {
            $this->mouvementService->AddMouvement($line, $i);
        }
        $this->em->flush();
        $filename = $file->getClientOriginalName();
        $nblines = count($line);
        $mvtable = new MvtUploadTable();
        $mvtable->setFileName($filename);
        $mvtable->setStateFile('Fichier Traite');
        $mvtable->setNbLines($nblines);
        $mvtable->setUploadDate(new DateTime());
        $StockExchangeDate = new DateTime();
        $mvtable->setStockExchangeDate($StockExchangeDate->setDate(substr($line[1], 18, 4), substr($line[1], 16, 2), substr($line[1], 14, 2)));
        $this->em->persist($mvtable);
        $this->em->flush();
        return $this->json('file uploded in database');
    }

    /**
     * @Route("/api/delete-mouvement/{id}", name="app_delete_mouvement", methods={"DELETE"})
     */
    public function deleteMouvement(Request $request)
    {
        $mvtable = $this->em->getRepository(MvtUploadTable::class)->find($request->get('id'));
        if ($mvtable) {
            $this->em->remove($mvtable);
            $this->em->flush();
            return $this->json('file deleted successfully');
        } else {
            return $this->json('file not found');
        }
    }
}
