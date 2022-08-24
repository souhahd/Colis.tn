<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class UserCrudController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }


    /**
     * @Route("/super/admin/users", name="app_users_show")
     */
    public function index(UserRepository $userRepository): Response
    {

        return $this->render('super_admin/utilisateur/index.html.twig', ['users'=>$userRepository->findByRole('ROLE_USER')]);
    }


    /**
     * @Route("/super/admin/users/add", name="app_user_create")
     */
    public function addUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response{

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $plaintextPassword = $user->getPlainPassword();
            // encode the plain password

            $hashedPassword = $userPasswordHasher->hashPassword(
                $user,
                $plaintextPassword
            );

            $user->setPassword($hashedPassword);


            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('admincolis.tn@gmail.com', 'Colis.tn Mail Bot'))
                    ->to($user->getEmail())
                    ->subject('Veuillez confirmer votre email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            $this->addFlash('success','Ajout terminée avec success!');
            return $this->redirectToRoute('app_users_show');

        }

        return $this->render('super_admin/utilisateur/new.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
         * @Route("/verify/email", name="app_verify_email")
         */
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
        {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            // validate email confirmation link, sets User::isVerified=true and persists
            try {
                $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
            } catch (VerifyEmailExceptionInterface $exception) {
                $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

                return $this->redirectToRoute('app_register');
            }

            // @TODO Change the redirect on success and handle or remove the flash message in your templates
            $this->addFlash('success', 'Votre adresse e-mail a été vérifiée.');

            return $this->redirectToRoute('app_home');
        }

    /**
     * @Route ("/super/admin/users/{id<[0-9]+>}", name="app_user_avertir")
     * @return Response
     */
    public function avertirUser(User $user, EntityManagerInterface $em): Response
        {
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('admincolis.tn@gmail.com', 'Colis.tn Mail Bot'))
                    ->to($user->getEmail())
                    ->subject('Avertisement')
                    ->htmlTemplate('super_admin/utilisateur/avertir_email.html.twig')
            );
            // do anything else you need here, like send an email
            $user->setNombreAvertis($user->getNombreAvertis()+1);
            $em->flush();
            $this->addFlash('success','Utilisteur averti!');
            return $this->redirectToRoute('app_users_show');
        }



    /**
     * @Route("/super/admin/user/{id<[0-9]+>}/edit", name="app_userbyid_edit",  methods={"GET", "PUT", "POST"})
     */
    public function edit(User $user, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success','Utilisateur a été modifié avec success.');
            return $this->redirectToRoute('app_users_show');

        }
        return $this->render('super_admin/utilisateur/edit.html.twig', ['userForm' => $form->createView(),'user'=>$user]);

    }


    /**
     * @Route("super_admin/utilisateur/{id<[0-9]+>}", name="app_user_delete", methods={"DELETE", "POST"})
     */
    public function delete(User $user, Request $request, EntityManagerInterface $em):Response
    {

        if($this->isCsrfTokenValid('user_deletion_' . $user->getId(), $request->request->get('csrf_token'))){
            $em->remove($user);
            $em->flush();
            $this->addFlash('info','User a été supprimé avec success.');
        }


        return $this->redirectToRoute('app_users_show');
    }



    /**
     * @Route("/super/admin/users/archive", name="app_users_show_archive")
     */
    public function show_archive(UserRepository $userRepository): Response
    {
        return $this->render('super_admin/utilisateur/index_archive.html.twig', ['users'=>$userRepository->findAllUsersArchive('ROLE_USER')]);
    }

    /**
     * @Route("/super/admin/users/averti", name="app_users_show_averti")
     */
    public function show_averti(UserRepository $userRepository): Response
    {

        return $this->render('super_admin/utilisateur/index_averti.html.twig', ['users'=>$userRepository->findAllUsersAverti('ROLE_USER')]);
    }

    /**
     * @Route("/super/admin/users/banni", name="app_users_show_banni")
     */
    public function show_banni(UserRepository $userRepository): Response
    {

        return $this->render('super_admin/utilisateur/index_banni.html.twig', ['users'=>$userRepository->findAllUsersBanni('ROLE_USER')]);
    }

    /**
     * @Route("super/admin/user/{id<[0-9]+>}", name="app_down_user", methods={"GET", "PUT", "POST"})
     */
    public function archiver(User $user, Request $request, EntityManagerInterface $em):Response
    {

        if($this->isCsrfTokenValid('user_down_' . $user->getId(), $request->request->get('csrf_token'))){
            $user->setIsActive(0);
            $em->flush();
            $this->addFlash('info','Utilisateur a été archivé avec success.');
        }


        return $this->redirectToRoute('app_users_show_archive');

    }

    /**
     * @Route("super/admin/user/{id<[0-9]+>}", name="app_up_user", methods={"GET", "PUT", "POST"})
     */
    public function desarchiver(User $user, Request $request, EntityManagerInterface $em):Response
    {

        if($this->isCsrfTokenValid('user_up_' . $user->getId(), $request->request->get('csrf_token'))){
            $user->setIsActive(1);
            $em->flush();
            $this->addFlash('info','Utilisateur a été desarchivé avec success.');
        }


        return $this->redirectToRoute('app_users_show_archive');

    }

    /**
     * @Route("super/admin/user/{id<[0-9]+>}", name="app_user_banni", methods={"GET", "PUT", "POST"})
     */
    public function bannir(User $user, EntityManagerInterface $em):Response
    {
        $user->setIsBannir(1);
        $em->flush();
        $this->addFlash('info','Utilisateur a été banni avec success.');

        return $this->redirectToRoute('app_users_show_banni');

    }

    /**
     * @Route("super/admin/user/{id<[0-9]+>}", name="app_user_debloquer", methods={"GET", "PUT", "POST"})
     */
    public function debloquer(User $user, EntityManagerInterface $em):Response
    {
        $user->setIsBannir(0);
        $em->flush();
        $this->addFlash('info','Utilisateur a été debloqué avec success.');

        return $this->redirectToRoute('app_users_show_banni');

    }


}