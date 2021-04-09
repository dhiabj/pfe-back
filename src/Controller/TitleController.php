<?php

namespace App\Controller;

use App\Entity\Title;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TitleController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/api/titles", name="app_titles_all", methods={"GET"})
     */
    public function getTitles(): Response
    {
        $titles = $this->em->getRepository(Title::class)->findAll();
        return $this->json($titles);
    }

    /**
     * @Route("/api/add-title", name="app_add_title", methods={"POST"})
     */
    public function addTitle(Request $request)
    {
        $titleRequest = json_decode($request->getContent());
        $title = new Title();
        $title->setTitleCode($titleRequest->TitleCode)
            ->setTitleLabel($titleRequest->TitleLabel);
        $this->em->persist($title);
        $this->em->flush();
        return new JsonResponse("Title created", 200);
    }

    /**
     * @Route("/api/edit-title/{id}", name="app_edit_title", methods={"PUT"})
     */
    public function editTitle(Request $request)
    {
        $titleRequest = json_decode($request->getContent());
        $title = $this->em->getRepository(Title::class)->find($request->get('id'));
        $title->setTitleCode($titleRequest->TitleCode)
            ->setTitleLabel($titleRequest->TitleLabel)
            ->setUpdateDate(new DateTime());
        $this->em->persist($title);
        $this->em->flush();
        return new JsonResponse("Title updated", 200);
    }

    /**
     * @Route("/api/delete-title/{id}", name="app_delete_title", methods={"DELETE"})
     */
    public function deleteTitle(Request $request)
    {
        $title = $this->em->getRepository(Title::class)->find($request->get('id'));
        $this->em->remove($title);
        $this->em->flush();
        return new JsonResponse("Title deleted", 200);
    }
}
