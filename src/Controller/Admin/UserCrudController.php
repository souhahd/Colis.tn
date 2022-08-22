<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserCrudController extends AbstractController
{
    /**
     * @Route("/super/admin/users", name="app_users_show")
     */
    public function index(UserRepository $userRepository): Response
    {

        return $this->render('super_admin/utilisateur/index.html.twig', ['users'=>$userRepository->findByRole('ROLE_USER')]);
    }



}