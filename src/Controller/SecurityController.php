<?php

namespace App\Controller;

use MercurySeries\FlashyBundle\FlashyNotifier;
use PhpParser\Node\Stmt\Else_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils , FlashyNotifier $flashy): Response
    {
        if ($this->getUser()) {
            $this->addFlash('error', 'Vous ètes déjà connecté');
           // $this->$flashy->success('Vous ètes déjà connecté', 'http://your-awesome-link.com');
            return $this->redirectToRoute('app_home');
        }


        return $this->render('security/login.html.twig', [
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'last_username' => $authenticationUtils->getLastUsername(),
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(FlashyNotifier $flashy)
    {
        $this->$flashy->success('Vous ètes deconnecte', 'http://your-awesome-link.com');
        throw new \Exception('logout() should never be reached');
    }
}
