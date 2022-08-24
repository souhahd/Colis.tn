<?php

namespace App\Controller\Admin;

use App\Repository\AnnonceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceCrudController extends AbstractController
{
    /**
     * @Route("/super/admin/annonces", name="app_annonces_show")
     */
    public function index(AnnonceRepository $repannonce): Response
    {
        return $this->render('super_admin/annonce/index.html.twig',['annonces'=>$repannonce->findBy([],['dateProposee'=>'ASC'])]);
    }

    /**
     * @Route("/super/admin/annonce/create", methods={"GET", "POST", "PATCH"}, name="app_add_annonce")
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


}