<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\Admin\AdminCategoriesType;

#[Route('/admin/categories', name: 'admin_categories_')]
class CategoriesController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        $categories = $categoriesRepository->findBy([], ['id' => 'asc']);

        return $this->render('admin/categories/index.html.twig', compact('categories'));
    }

    #[Route('/ajout', name: 'add')]
    public function add(Request $request, EntityManagerInterface $manager): Response
    {

        $category = new Categories();
        $categoryForm = $this->createForm(AdminCategoriesType::class, $category);
        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            $slug = $category->getName();
            $category->setSlug($slug);
            $manager->persist($category);
            $manager->flush();

            $this->addFlash('success', 'Catégorie ajoutée avec succès !');

            return $this->redirectToRoute('main');
        }

        return $this->render('admin/categories/add.html.twig', [
            'categoryForm' => $categoryForm->createView()
        ]);
    }

    #[Route('/supprimer/{slug}', name: 'delete')]
    public function delete(Categories $categories, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($categories);
        $entityManager->flush();

        $this->addFlash('success', 'Catégorie supprimée avec succès.');

        return $this->redirectToRoute('admin_categories_index');
    }
}