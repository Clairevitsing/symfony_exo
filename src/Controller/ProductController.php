<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\Common\Proxy\Proxy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_list')]
    public function product(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('product/list.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/{id}', name: 'product_item')]
    public function item(
        Product $product
    ): Response {
        return $this->render('product/item.html.twig', [
            'product' => $product,
        ]);
    }
}
