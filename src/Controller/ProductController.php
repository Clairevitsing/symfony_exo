<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\Common\Proxy\Proxy;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_list')]
    public function product(
        ProductRepository $productRepository,
        PaginatorInterface $paginator,
        Request $request

    ): Response {
        $products = $paginator->paginate(
            $productRepository->findAll(),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('product/list.html.twig', [
            'products' => $products
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

    #[Route('/createProduct', name: 'newProduct', methods: ['GET', 'POST'])]
    public function new(

        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // dd($form->getData);
            $product = $form->getData();
            // dd($product);
            $manager->persist($product);
            $manager->flush();

            $this->addFlash(
                'success',
                'The new product has been created'
            );
            return $this->redirectToRoute('product_list');
        }
        return $this->render('product/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/product/edit/{id}', name: 'product_edit')]
    public function edit(
        Request $request,
        ProductRepository $productRepository,
        EntityManagerInterface $manager,
        $id
    ): Response {
        $product = $productRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // dd($form->getData);
            $product = $form->getData();
            // dd($product);
            $manager->persist($product);
            $manager->flush();

            $this->addFlash(
                'success',
                'The new product has been editted successfully'
            );
            return $this->redirectToRoute('product_list');
        }
        return $this->render('product/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/product/delete/{id}', name: 'product_delete')]
    public function delete(
        Request $request,
        ProductRepository $productRepository,
        EntityManagerInterface $manager,
        $id
    ): Response {
        $product = $productRepository->findOneBy(['id' => $id]);
        if (!$product) {
            $this->addFlash(
                'Success',
                'Don\'t find product in question!'
            );
            return $this->redirectToRoute('product_list');
        }

        $manager->remove($product);
        $manager->flush();

        $this->addFlash(
            'success',
            'The new product has been deleted successfully'
        );
        return $this->redirectToRoute('product_list');
    }
}
