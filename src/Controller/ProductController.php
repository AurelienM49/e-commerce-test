<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Product;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/produits/{cat}", name="products")
     */
    public function index(Request $request, $cat): Response
    {

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $applyFilter = [];

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $products = $this->em->getRepository(Product::class)->findWithSearch($search);
            if($search->string !=  '')
                $applyFilter['string'] = $search->string;
            for ($i=0; $i < count($search->categories); $i++) { 
                $applyFilter[$i] = $search->categories[$i]->getName();
            }
        } else if ($cat == 'all') {
            $products = $this->em->getRepository(Product::class)->findAll();
        } else {
            $products = $this->em->getRepository(Product::class)->findByCategorie($cat);
        }
        return $this->render('product/index.html.twig', [
            'products' => $products, 'form' => $form->createView(), 'applyFilter' => $applyFilter
        ]);
    }

    /**
     * @Route("/produit/{slug}", name="product_details")
     */
    public function show($slug): Response
    {
        $product = $this->em->getRepository(Product::class)->findOneBySlug($slug);
        if (!$product) {
            return $this->redirectToRoute('products');
        }
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}
