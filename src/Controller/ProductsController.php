<?php

namespace App\Controller;

use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpClient\Response;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produits', name: 'products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('products/index.html.twig');
//        'machin' => 'Liste des produits',
    }

    #[Route('/{slug}', name: 'details')]
    public function details(Products $product): Response
    {
//        dd($product);
//        dd($product->getName());
        // Exemple avec tableau associatif :
//        return $this->render('products/details.html.twig', [
//            'nom du produit : ' => $product->getName(),
//            'details du produit : ' => $product->getDescription()
//        ]);
        // Exemple avec la méthode compact
        return $this->render('products/details.html.twig', compact('product'));
    }
}
