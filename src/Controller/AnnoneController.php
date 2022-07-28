<?php

namespace App\Controller;


use App\Entity\Annonce;
use App\Entity\Colis;
use App\Form\AnnonceFormType;
use App\Repository\AnnonceRepository;
use App\Repository\ColisRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AnnoneController extends AbstractController
{


    /**
     * @Route("/annonce/create", methods={"GET", "POST", "PATCH"},name="app_annonce_create")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {


        if($request->isMethod('POST'))
        {
            $data = $request->request->all();
            $annonce= new Annonce();
            $colis= new Colis();



            if ($this->isCsrfTokenValid('annonce_create',$data['_token'])) {

                $annonce->setAdresseArrivee($data['addressdep']);
                $annonce->setAdresseDepart($data['addressarr']);
                $annonce->setPrixProposee($data['prix']);
                $annonce->setDateProposee(DateTime::createFromFormat('Y-m-d', $data['datepro']));

                $colis->setObjetColis($data['objet']);
                $colis->setQuantiteColis($data['quantite']);
                $colis->setLargeurColis($data['largeur']);
                $colis->setLongeurColis($data['longeur']);
                $colis->setHauteurColis($data['hauteur']);
                $colis->setPoidsUnitaireColis($data['poids']);
                $colis->setImage($data['imagecolis']);
                $colis->setDescriptionColis($data['description']);
            }
            $em->persist($colis);
            $annonce->addIdColi($colis);

            $em->persist($annonce);
            $em->flush();

            return $this->redirectToRoute('app_annone_show',['id'=> $annonce->getId()]);


        }else{
            return $this->render('annonce/create.html.twig');
        }

    }


    /**
     * @Route ("annonce/{id<[0-9]+>}" ,name="app_annone_show", methods={"GET"})
     */
    public function show(Annonce $annonce):Response{

        if(null === $annonce)
        {
            throw $this->createNotFoundException('Annonce #' . $annonce->id .'  not found!');
        }
        return $this->render('annonce/show.html.twig', compact('annonce'));
    }

    /**
     * @Route("/annonce/{id<[0-9]+>}/edit", name="app_annonce_edit", methods={"GET", "PUT", "POST"})
     */
    public function edit(Annonce $annonce,Request $request, EntityManagerInterface $em ,ManagerRegistry $doctrine): Response{
        if($request->isMethod('POST')) {
            $data = $request->request->all();

            $colis = $em->getRepository(Colis::class)->find(['id'=>$annonce->getIdColis()->get('0')->getId()]);

            if ($this->isCsrfTokenValid('annonce_edit', $data['_token'])) {
                $annonce->setAdresseArrivee($data['addressdep']);
                $annonce->setAdresseDepart($data['addressarr']);
                $annonce->setPrixProposee($data['prix']);
                $annonce->setDateProposee(DateTime::createFromFormat('Y-m-d', $data['datepro']));





                $colis->setObjetColis($data['objet']);
                $colis->setQuantiteColis($data['quantite']);
                $colis->setLargeurColis($data['largeur']);
                $colis->setLongeurColis($data['longeur']);
                $colis->setHauteurColis($data['hauteur']);
                $colis->setPoidsUnitaireColis($data['poids']);
                $colis->setImage($data['imagecolis']);
                $colis->setDescriptionColis($data['description']);


                $annonce->addIdColi($colis);

            }
            $em->flush();
            $this->addFlash('success','Annonce a été modifié avec success.');
            return $this->redirectToRoute('app_annone_show',['id'=> $annonce->getId()]);
        }else{
            return $this->render('annonce/edit.html.twig', compact('annonce'));

        }
    }


    /**
     * @Route("/annonce/{id<[0-9]+>}", name="app_annonce_delete", methods={"DELETE", "POST"})
     */
    public function delete(Annonce $annonce, Request $request, EntityManagerInterface $em):Response
    {

        if($this->isCsrfTokenValid('annonce_deletion_' . $annonce->getId(), $request->request->get('csrf_token2'))){


            $em->remove($annonce);
            $em->flush();
            $this->addFlash('info','Annonce a été supprimé avec success.');
        }

        return $this->redirectToRoute('app_annonce');
    }
    /**
     * @Route("/annonce", name="app_annonce")
     */
    public function index(AnnonceRepository $repannonce): Response
    {
        return $this->render('annonce/index.html.twig',['annonce'=>$repannonce->findBy([],['dateProposee'=>'ASC'])]);
    }

}