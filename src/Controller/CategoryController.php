<?php

namespace App\Controller;

use App\Entity\Category;
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
        $categories = $this->em->getRepository(Category::class)->findAll();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER =>
            function ($categories) {
                return $categories->getId();
            },
            AbstractNormalizer::IGNORED_ATTRIBUTES => [
                '__initializer__', '__isInitialized__',
                '__cloner__', 'mouvements', 'mouvementl', 'stocks'
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
        $jsonObject = $serializer->serialize($categories, 'json');
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/api/add-category", name="app_add_category", methods={"POST"})
     */
    public function addCategory(Request $request)
    {
        $categoryRequest = json_decode($request->getContent());
        $category = new Category();
        $category->setCategoryCode($categoryRequest->CategoryCode)
            ->setCategoryLabel($categoryRequest->CategoryLabel);
        $this->em->persist($category);
        $this->em->flush();
        return new JsonResponse("Category created", 200);
    }

    /**
     * @Route("/api/edit-category/{id}", name="app_edit_category", methods={"PUT"})
     */
    public function editCategory(Request $request)
    {
        $categoryRequest = json_decode($request->getContent());
        $category = $this->em->getRepository(Category::class)->find($request->get('id'));
        $category->setCategoryCode($categoryRequest->CategoryCode)
            ->setCategoryLabel($categoryRequest->CategoryLabel);
        $this->em->persist($category);
        $this->em->flush();
        return new JsonResponse("Category updated", 200);
    }

    /**
     * @Route("/api/delete-category/{id}", name="app_delete_category", methods={"DELETE"})
     */
    public function deleteCategory(Request $request)
    {
        $category = $this->em->getRepository(Category::class)->find($request->get('id'));
        $this->em->remove($category);
        $this->em->flush();
        return new JsonResponse("Category deleted successfully", 200);
    }
}
