<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\OrdersDetails;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/commande', name: 'orders_')]
class OrdersController extends AbstractController
{
    #[Route('/ajout', name: 'add')]
    public function add(SessionInterface $session, ProductsRepository $productsRepository, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $panier = $session->get('panier', []);

        if ($panier ===  []) {
            $this->addFlash('warning', 'Votre panier est vide');
            return $this->redirectToRoute('main');
        }

        $order = new Orders();

        $order->setCreatedAt(new \DateTimeImmutable());
        $order->setUsers($this->getUser());
        $order->setReference(uniqid());

        foreach ($panier as $item => $quantity) {
            $orderDetails = new OrdersDetails();

            $product = $productsRepository->find($item);
            $price = $product->getPrice();

            $orderDetails->setProducts($product);
            $orderDetails->setPrice($price);
            $orderDetails->setQuantity($quantity);

            $order->addOrdersDetail($orderDetails);

        }

        $em->persist($order);
        $em->flush();

        $session->remove('panier');

        $this->addFlash('success', 'Commande créee avec succès !');
        return $this->redirectToRoute('main');
    }
}
