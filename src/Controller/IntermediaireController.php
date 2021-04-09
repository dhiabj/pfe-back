<?php

namespace App\Controller;

use App\Entity\IntermAccount;
use App\Entity\Intermediaire;
use App\Entity\Market;
use App\Entity\Profit;
use App\Entity\Reglement;
use App\Entity\Value;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use LimitIterator;
use SplFileObject;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        /*$fileName = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
        $line = file_get_contents($file);
        $fileCSV = fopen("csv/" . $fileName, "w");
        fwrite($fileCSV, $line);
        fclose($fileCSV);
        chmod("csv/" . $fileName, 0644);*/
        $file = new SplFileObject($file);
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY | SplFileObject::READ_AHEAD  | SplFileObject::DROP_NEW_LINE);
        $file->setCsvControl(';', '"', '\\');
        $it = new LimitIterator($file, 1);
        foreach ($it as $row) {
            $TransactionDate = new DateTime();
            $codeVal = $row[3];
            $value = $this->em->getRepository(Value::class)->findOneBy(['Isin' => $codeVal]);
            if (!$value) {
                $value = new Value();
                $value->setIsin($codeVal);
                $this->em->persist($value);
                $this->em->flush();
            }
            $marketCode = $row[6];
            $market = $this->em->getRepository(Market::class)->findOneBy(['MarketCode' => $marketCode]);
            if (!$market) {
                $market = new Market();
                $market->setMarketCode($marketCode);
                $this->em->persist($market);
                $this->em->flush();
            }
            $profitCode = $row[7];
            $profit = $this->em->getRepository(Profit::class)->findOneBy(['ProfitCode' => $profitCode]);
            if (!$profit) {
                $profit = new Profit();
                $profit->setProfitCode($profitCode);
                $this->em->persist($profit);
                $this->em->flush();
            }
            $accountCode = $row[9];
            $account = $this->em->getRepository(IntermAccount::class)->findOneBy(['AccountCode' => $accountCode]);
            if (!$account) {
                $account = new IntermAccount();
                $account->setAccountCode($accountCode);
                $this->em->persist($account);
                $this->em->flush();
            }
            $reglementCode = $row[14];
            $reglement = $this->em->getRepository(Reglement::class)->findOneBy(['ReglementCode' => $reglementCode]);
            if (!$reglement) {
                $reglement = new Reglement();
                $reglement->setReglementCode($reglementCode);
                $this->em->persist($reglement);
                $this->em->flush();
            }
            $intermediaire = (new Intermediaire())
                ->setTransactionDate($TransactionDate->setDate((substr($row[0], 6, 4)), (substr($row[0], 3, 2)), (substr($row[0], 0, 2))))
                ->setContractNumber($row[1])
                ->setDirection($row[2])
                ->setValueCode($value)
                ->setValueLabel($row[4])
                ->setValueCharacteristic($row[5])
                ->setMarket($market)
                ->setProfit($profit)
                ->setClient($row[8])
                ->setAccountType($account)
                ->setCountry($row[10])
                ->setQuantity($row[11])
                ->setCours(floatval($row[12]))
                ->setIntermediaireCode($row[13])
                ->setReglement($reglement)
                ->setCommission(floatval($row[15]));
            $this->em->persist($intermediaire);
        }
        $this->em->flush();
        return new JsonResponse("file uploded in database", 200);
    }
}
