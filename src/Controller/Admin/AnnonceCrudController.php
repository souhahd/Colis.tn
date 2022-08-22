<?php

namespace App\Controller\Admin;

use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

}