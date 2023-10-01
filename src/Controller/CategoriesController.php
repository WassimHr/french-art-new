<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\ProductsRepository;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/categories', name: 'categories_')]

class CategoriesController extends AbstractController
{
    #[Route('/{slug}', name: 'list' )]
    public function list(Categories $category, ProductsRepository $productsRepository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);

        $products = $productsRepository->findProductsPaginated($page, $category->getSlug(), 3);
        
        return $this->render('categories/list.html.twig', compact('category', 'products'));
       
    }
    
    public function listCategories() { 
        
    }
}
