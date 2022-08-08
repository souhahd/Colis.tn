<?php

namespace App\Controller;

use App\Entity\Annonce;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceCrudController extends AbstractController
{
    /**
     * @Route("/annonce_crud", name="app_annonce_crud")
     */
    public function index(): Response
    {
        return $this->render('annonce_crud/index.html.twig', [
            'controller_name' => 'AnnonceCrudController',
        ]);
    }

    /**
     * @Route("/annonce_crud/create", methods={"GET", "POST"}, name="app_annonce_create")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceCrudController::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $annonce=$form->getData();
            $em->persist($annonce);
            $em->flush();
            $this->addFlash('success','Annonce a été crée avec success.');

            return $this->redirectToRoute('app_annonce_crud');
        }
        return $this->render('annonce_crud/create.html.twig', ['annonceForm' => $form->createView()]);
    }


}
