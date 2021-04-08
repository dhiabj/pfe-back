<?php

namespace App\Controller;

use App\Entity\Value;
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

class ValueController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/api/values", name="app_values_all", methods={"GET"})
     */
    public function getAllValues(): Response
    {
        $values = $this->em->getRepository(Value::class)->findAll();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER =>
            function ($values) {
                return $values->getId();
            },
            AbstractNormalizer::IGNORED_ATTRIBUTES => [
                '__initializer__', '__isInitialized__',
                '__cloner__', 'mouvements', 'mouvementl', 'stocks', 'intermediaires'
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
        $jsonObject = $serializer->serialize($values, 'json');
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/api/add-value", name="app_add_value", methods={"POST"})
     */
    public function addValue(Request $request)
    {
        $valueRequest = json_decode($request->getContent());
        $value = new Value();
        $value->setIsin($valueRequest->ValueCode)
            ->setValueLabel($valueRequest->ValueLabel)
            ->setMnemonique($valueRequest->Mnemonique)
            ->setValueType($valueRequest->ValueType)
            ->setNbTitresadmisBourse($valueRequest->NbTitresadmisBourse)
            ->setNbCodFlott($valueRequest->NbCodFlott)
            ->setGroupCotation($valueRequest->GroupCotation)
            ->setSuperSecteur($valueRequest->SuperSecteur);
        $this->em->persist($value);
        $this->em->flush();
        return new JsonResponse("Value created", 200);
    }

    /**
     * @Route("/api/edit-value/{id}", name="app_edit_value", methods={"PUT"})
     */
    public function editValue(Request $request)
    {
        $valueRequest = json_decode($request->getContent());
        $value = $this->em->getRepository(Value::class)->find($request->get('id'));
        $value->setIsin($valueRequest->ValueCode)
            ->setValueLabel($valueRequest->ValueLabel)
            ->setMnemonique($valueRequest->Mnemonique)
            ->setValueType($valueRequest->ValueType)
            ->setNbTitresadmisBourse($valueRequest->NbTitresadmisBourse)
            ->setNbCodFlott($valueRequest->NbCodFlott)
            ->setGroupCotation($valueRequest->GroupCotation)
            ->setSuperSecteur($valueRequest->SuperSecteur);
        $this->em->persist($value);
        $this->em->flush();
        return new JsonResponse("Value updated", 200);
    }

    /**
     * @Route("/api/delete-value/{id}", name="app_delete_value", methods={"DELETE"})
     */
    public function deleteValue(Request $request)
    {
        $value = $this->em->getRepository(Value::class)->find($request->get('id'));
        $this->em->remove($value);
        $this->em->flush();
        return new JsonResponse("Value deleted successfully", 200);
    }
}
