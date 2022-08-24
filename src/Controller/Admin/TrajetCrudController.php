<?php

namespace App\Controller\Admin;

use App\Entity\Trajet;
use App\Form\TrajetFormType;
use App\Repository\TrajetRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

class TrajetCrudController extends AbstractController
{
    /**
     * @Route("/super/admin/trajets", name="app_trajets_show")
     */
    public function index(TrajetRepository $trajetRepository): Response
    {
        return $this->render('super_admin/trajet/index.html.twig', ['trajets'=>$trajetRepository->findBy([],['dateDepart'=>'ASC'])]);
    }

    /**
     * @Route("/super/admin/trajets/archive", name="app_trajets_show_archive")
     */
    public function showarchive(TrajetRepository $trajetRepository): Response
    {
        return $this->render('super_admin/trajet/index_archive.html.twig', ['trajets'=>$trajetRepository->findAllTrajetArchive()]);
    }

    /**
     * @Route("/super/admin/trajet/create", methods={"GET", "POST", "PATCH"}, name="app_add_trajet")
     */
    public function create(Request $request, EntityManagerInterface $em, UserRepository $userRepository): Response
    {
        if($request->isMethod('POST'))
        {

            $trajet = new Trajet();
            $data = $request->request->all();
            $x=$userRepository->findOneByEmail($data['email']);
            $user = $userRepository->find($x);

            if ($this->isCsrfTokenValid('trajet_create',$data['_token'])) {


                $trajet->setUser($user);
                $trajet->setLieuDepartTrajet($data['adrdep']);
                $trajet->setLieuArriveeTrajet($data['adrarr']);
                $trajet->setDetourMaxTrajet($data['dtrmax']);
                $trajet->setDateDepart(DateTime::createFromFormat('Y-m-d\TH:i', $data['datedep']));
                $trajet->setFormatObjet($data['format']);

            }

            $em->persist($trajet);
            $em->flush();
            $this->addFlash('success','Trajet a été ajouté avec success.');
            return $this->redirectToRoute('app_trajets_show');


        }else{
            return $this->render('super_admin/trajet/new.html.twig');
        }
    }

    /**
     * @Route("super/admin/trajet/{id<[0-9]+>}/edit", name="app_edit_trajet", methods={"GET", "PUT", "POST"})
     */
    public function edit(Trajet $trajet, Request $request, EntityManagerInterface $em):Response
    {
        $form = $this->createForm(TrajetFormType::class, $trajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success','Trajet a été modifié avec success.');
            return $this->redirectToRoute('app_trajets_show');

        }
        return $this->render('super_admin/trajet/edit.html.twig', ['trajetForm' => $form->createView(),'trajet'=>$trajet]);



    }

    /**
     * @Route("super_admin/trajet/{id<[0-9]+>}", name="app_trajet_deletebyadmin", methods={"DELETE", "POST"})
     */
    public function delete(Trajet $trajet, Request $request, EntityManagerInterface $em):Response
    {

        if($this->isCsrfTokenValid('trajet_deletion_' . $trajet->getId(), $request->request->get('csrf_token'))){
            $em->remove($trajet);
            $em->flush();
            $this->addFlash('info','Trajet a été supprimé avec success.');
        }


        return $this->redirectToRoute('app_trajets_show');
    }

    /**
     * @Route("super/admin/trajet/{id<[0-9]+>}", name="app_down_trajet", methods={"GET", "PUT", "POST"})
     */
    public function archiver(Trajet $trajet, Request $request, EntityManagerInterface $em):Response
    {

        if($this->isCsrfTokenValid('trajet_down_' . $trajet->getId(), $request->request->get('csrf_token'))){
            $trajet->setShowed(0);
            $em->flush();
            $this->addFlash('info','Trajet a été archivé avec success.');
        }


        return $this->redirectToRoute('app_trajets_show');

    }


    /**
     * @Route("super/admin/trajet/{id<[0-9]+>}", name="app_up_trajet", methods={"GET", "PUT", "POST"})
     */
    public function desarchiver(Trajet $trajet, Request $request, EntityManagerInterface $em):Response
    {
        if($this->isCsrfTokenValid('trajet_up_' . $trajet->getId(), $request->request->get('csrf_token'))){
            $trajet->setShowed(1);
            $em->flush();
            $this->addFlash('info','Trajet a été désarchivé avec success.');
        }


        return $this->redirectToRoute('app_trajets_show');

    }

    /**
     * @Route("/super/admin/trajets/done", name="app_trajets_show_done")
     */
    public function showdone(TrajetRepository $trajetRepository): Response
    {
        return $this->render('super_admin/trajet/index_done.html.twig', ['trajets'=>$trajetRepository->findAll()]);
    }

    /**
     * @Route("/super/admin/trajets/notyet", name="app_trajets_show_notyet")
     */
    public function shownotyet(TrajetRepository $trajetRepository): Response
    {
        return $this->render('super_admin/trajet/index_notyet.html.twig', ['trajets'=>$trajetRepository->findAll()]);
    }

}