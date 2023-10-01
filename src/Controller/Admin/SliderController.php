<?php

namespace App\Controller\Admin;

use App\Entity\AdminSlider;
use App\Form\Admin\AdminSliderFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AdminSliderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/admin/slider', name: 'admin_slider_')]
class SliderController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(AdminSliderRepository $sliderRepository): Response
    {
        $sliders = $sliderRepository->findBy([], ['ordre' => 'ASC']);

        return $this->render('admin/slider/index.html.twig', compact('sliders'));
    }

    #[Route('/ajout', name: 'add')]
    public function add(Request $request, EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {

        $slider = new AdminSlider();
        $sliderForm = $this->createForm(AdminSliderFormType::class, $slider);
        $sliderForm->handleRequest($request);

        if ($sliderForm->isSubmitted() && $sliderForm->isValid()) {
            
            $image = $sliderForm->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $slider->setImage($newFilename);

            $slider->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($slider);
            $manager->flush();

            $this->addFlash('success', 'Image d\'accueil ajoutée avec succès !');

            return $this->redirectToRoute('main');
        }
    }

        return $this->render('admin/slider/add.html.twig', [
            'sliderForm' => $sliderForm->createView()
        ]);
    }

    #[Route('/edition/{id}', name: 'edit')]
    public function edit(Request $request, EntityManagerInterface $manager, AdminSlider $slider, SluggerInterface $slugger): Response
    {


        $sliderForm = $this->createForm(AdminSliderFormType::class, $slider);
        $sliderForm->handleRequest($request);

        if ($sliderForm->isSubmitted() && $sliderForm->isValid()) {

            $image = $sliderForm->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $slider->setImage($newFilename);
            
            }

            $slider->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($slider);
            $manager->flush();

            $this->addFlash('success', ' modifié avec succès !');

            return $this->redirectToRoute('main');
        }

        return $this->render('admin/slider/edit.html.twig', [
            'sliderForm' => $sliderForm->createView()
        ]);
    }

    #[Route('/supprimer/{id}', name: 'delete')]
    public function delete(AdminSlider $adminSlider, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($adminSlider);
        $entityManager->flush();

        $this->addFlash('success', 'Image d\'accueil supprimée avec succès.');

        return $this->redirectToRoute('admin_slider_index');
    }
}