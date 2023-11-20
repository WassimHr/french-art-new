<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Orders;
use DateTimeImmutable;

use App\Entity\OrdersDetails;
use App\Form\RegistrationFormType;
use App\Security\UsersAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

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

    #[Route('/edition/{id}', name: 'edit')]
    public function edit(Request $request, Users $user , UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UsersAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {

        $currentUser = $this->getUser();
        if ($currentUser !== $user) {
           
            throw $this->createAccessDeniedException('Vous n\'avez pas le droit d\'éditer ce profil.');
        }

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(["ROLE_USER"]);
            $user->setCreatedAt(new DateTimeImmutable());

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            $this->addFlash('success', "Utilisateur modifié avec succès !");
            return $this->redirectToRoute('main');

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('admin/users/edit.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/orders', name: 'orders')]
    public function orders(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'Commande de l\'utilisateur',
        ]);
    }
}
