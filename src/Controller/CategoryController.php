<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'category_list')]
    public function category(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/list.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/category/{id}', name: 'category_item')]
    public function item(
        Category $category
    ): Response {
        return $this->render('category/item.html.twig', [
            'category' => $category,
        ]);
    }
}
