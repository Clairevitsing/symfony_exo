<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(ProductRepository $productRepository): Response
    {
        //sur ma page d'accueil je veux les produits 
        // -visible
        // -en promotion
        // -créés il a y moins d'un an
        // -ordonnées pas prix croissant
        // -limités à 5
        $products = $productRepository->findHomepageProducts();
        #dd($products);


        return $this->render('home/home.html.twig', [
            'products' => $products,
        ]);
    }
}
