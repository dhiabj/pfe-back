<?php

namespace App\Controller;

use App\Entity\Category;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/api/categories", name="app_categories_all", methods={"GET"})
     */
    public function getAllCategories(): Response
    {
        $categories = $this->em->getRepository(Category::class)->findByAll();

        return $this->json($categories);
    }

    /**
     * @Route("/api/delete-category/{CategoryCode}", name="app_delete_category", methods={"DELETE"})
     */
    public function deleteCategory(Request $request)
    {
        $cc = $this->getDoctrine()->getRepository(Category::class)->find($request->get('CategoryCode'));
        $this->em->remove($cc);
        $this->em->flush();
        return $this->json('Category Code deleted successfully');
    }
}
