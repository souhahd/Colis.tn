<?php

namespace App\Controller\Admin;

use App\Repository\TrajetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrajetCrudController extends AbstractController
{
    /**
     * @Route("/super/admin/trajets", name="app_trajets_show")
     */
    public function index(TrajetRepository $trajetRepository): Response
    {
        return $this->render('super_admin/trajet/index.html.twig', ['trajets'=>$trajetRepository->findBy([],['dateDepart'=>'ASC'])]);
    }
}