<?php

namespace App\Controller;

use App\Repository\AdminSliderRepository;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(CategoriesRepository $categoriesRepository, AdminSliderRepository $sliderRepository): Response
    {
        $categories = $categoriesRepository->findAll();
        $sliders = $sliderRepository->findBy([], ['ordre' => 'ASC']);

        
            return $this->render('main/index.html.twig', [
                'categories' => $categories,
                'sliders' => $sliders
            ]);

    }


    // public function nav(CategoriesRepository $categoriesRepository): Response
    // {
    //     $categories = $categoriesRepository->findAll();

    //         return $this->render('_partials/_nav.html.twig', [
    //             'categories' => $categories
    //         ]);

    // }
 
}
