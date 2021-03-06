<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $em;

    /**
     * @param $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @Route("/nos-produits", name="products")
     */
    public function index(): Response
    {

        $products = $this->em->getRepository(Product::class)->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/produit/{slug}", name="product_details")
     */
    public function show($slug): Response
    {

        $product = $this->em->getRepository(Product::class)->findOneBySlug($slug);
        if(!$product){
            return $this->redirectToRoute('products');
        }
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}
