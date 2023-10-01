<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Orders;
use App\Entity\OrdersDetails;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profile', name: 'profile_')]

class ProfileController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(): Response
    {

        // $orders = $user->getOrders();
        // $orderDetails = $orders[0]->getOrdersDetails();

        return $this->render('profile/index.html.twig'
        // [
        //     compact('user','orders', 'orderDetails')]
        );
    }

    #[Route('/orders', name: 'orders')]
    public function orders(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'Commande de l\'utilisateur',
        ]);
    }
}
