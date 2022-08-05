<?php

namespace App\Controller;

use App\Entity\Trajet;
use App\Form\TrajetFormType;
use App\Repository\TrajetRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrajetController extends AbstractController
{

    /**
     * @Route("/trajet/create", methods={"GET", "POST"}, name="app_trajet_create")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $trajet = new Trajet();
        $form = $this->createForm(TrajetFormType::class, $trajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $trajet=$form->getData();
            $em->persist($trajet);
            $em->flush();
            $this->addFlash('success','Trajet a été crée avec success.');

            return $this->redirectToRoute('app_trajet');
        }
        return $this->render('trajet/create.html.twig', ['trajetForm' => $form->createView()]);
    }

    /**
     *@Route("/trajet/{id<[0-9]+>}", name="app_trajet_show", methods={"GET"})
     */
    public function show(Trajet $trajet):Response
    {
        if(null === $trajet)
        {
            throw $this->createNotFoundException('Trajet #' . $trajet->id .'  not found!');
        }
        return $this->render('trajet/show.html.twig', compact('trajet'));

    }

    /**
     * @Route("/trajet/{id<[0-9]+>}/edit", name="app_trajet_edit", methods={"GET", "PUT", "POST"})
     */
    public function edit(Trajet $trajet, Request $request, EntityManagerInterface $em):Response
    {
        $form = $this->createForm(TrajetFormType::class, $trajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success','Trajet a été modifié avec success.');
            return $this->render('trajet/show.html.twig',compact('trajet'));

        }
        return $this->render('trajet/edit.html.twig', ['trajetForm' => $form->createView(),'trajet'=>$trajet]);



    }

    /**
     * @Route("/trajet/{id<[0-9]+>}", name="app_trajet_delete", methods={"DELETE", "POST"})
     */
    public function delete(Trajet $trajet, Request $request, EntityManagerInterface $em):Response
    {

        if($this->isCsrfTokenValid('trajet_deletion_' . $trajet->getId(), $request->request->get('csrf_token'))){
            $em->remove($trajet);
            $em->flush();
            $this->addFlash('info','Trajet a été supprimé avec success.');
        }


       return $this->redirectToRoute('app_trajet');
    }

    /**
     * @Route("/trajet", name="app_trajet")
     */
    public function index(TrajetRepository $trajetrep): Response
    {
        return $this->render('trajet/index.html.twig',['trajet'=>$trajetrep->findBy([],['createdAt'=>'ASC'])]);
    }
}