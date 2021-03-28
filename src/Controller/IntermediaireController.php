<?php

namespace App\Controller;

use App\Entity\Intermediaire;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use SplFileObject;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IntermediaireController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/api/intermediaires-fill", name="app_intermediaires_fill", methods={"POST"})
     */
    public function fillAllIntermediaires(Request $request): Response
    {
        $file = $request->files->get('intermediaire');
        $fileName = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
        $line = file_get_contents($file);
        $fileCSV = fopen("csv/" . $fileName, "w");
        fwrite($fileCSV, $line);
        fclose($fileCSV);
        chmod("csv/" . $fileName, 0644);
        $file = new SplFileObject("csv/" . $fileName);
        $file->setFlags(SplFileObject::READ_CSV);
        $file->setCsvControl(';', '"', '\\');
        foreach ($file as $row) {
            if ($row[0] === 'Date' || $row[0] === 'DATETRANSACTION' || $row[0] === 'date') {
                continue;
            }
            $TransactionDate = new DateTime();
            $intermediaire = (new Intermediaire())
                ->setTransactionDate($row[0] !== null ? $TransactionDate->setDate(intval(substr($row[0], 6, 4)), intval(substr($row[0], 3, 2)), intval(substr($row[0], 0, 2))) : null)
                ->setContractNumber(array_key_exists(1, $row) ? intval($row[1]) : 0)
                ->setDirection(array_key_exists(2, $row) ? $row[2] : "")
                ->setValueCode(array_key_exists(3, $row) ? $row[3] : "")
                ->setValueLabel(array_key_exists(4, $row) ? $row[4] : "")
                ->setValueCharacteristic(array_key_exists(5, $row) ? intval($row[5]) : 0)
                ->setMarket(array_key_exists(6, $row) ? intval($row[6]) : 0)
                ->setProfit(array_key_exists(7, $row) ? intval($row[7]) : 0)
                ->setClient(array_key_exists(8, $row) ? $row[8] : "")
                ->setAccountType(array_key_exists(9, $row) ? intval($row[9]) : 0)
                ->setCountry(array_key_exists(10, $row) ? $row[10] : "")
                ->setQuantity(array_key_exists(11, $row) ? intval($row[11]) : 0)
                ->setCours(array_key_exists(12, $row) ? intval($row[12]) : 0)
                ->setIntermediaireCode(array_key_exists(13, $row) ? intval($row[13]) : 0)
                ->setReglement(array_key_exists(14, $row) ? intval($row[14]) : 0)
                ->setCommission(array_key_exists(15, $row) ? intval($row[15]) : 0);
            $this->em->persist($intermediaire);
        }

        $this->em->flush();

        return $this->json('file uploded in database');
    }
}
