<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="app_user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    /**
     * @Route("/user/{id<[0-9]+>}", name="app_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        if(null === $user)
        {
            throw $this->createNotFoundException('User #' . $user->id .'  not found!');
        }
        return $this->render('user/show.html.twig', compact('user'));
    }

    /**
     * @Route("/user/{id<[0-9]+>}/edit", name="app_user_edit",  methods={"GET", "PUT", "POST"})
     */
    public function edit(User $user, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success','Profil a été modifié avec success.');
            return $this->render('user/show.html.twig',compact('user'));

        }
        return $this->render('user/edit.html.twig', ['userForm' => $form->createView(),'user'=>$user]);

    }
}
