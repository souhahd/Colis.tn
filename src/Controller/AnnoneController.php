<?php

namespace App\Controller;


use App\Entity\Annonce;
use App\Entity\Colis;
use App\Repository\AnnonceRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnoneController extends AbstractController
{

    /**
     * @Route("/annonce", name="app_annonce")
     */
    public function home(AnnonceRepository $repannonce): Response
    {
        return $this->render('annonce/index.html.twig',['annonce'=>$repannonce->findBy([],['dateProposee'=>'ASC'])]);
    }

    /**
     * @Route ("annonce/{id<[0-9]+>}" ,name="app_annone_show")
     */
    public function show(Annonce $annonce):Response{

        if(null === $annonce)
        {
            throw $this->createNotFoundException('Annonce #' . $annonce->id .'  not found!');
        }
        return $this->render('annonce/show.html.twig', compact('annonce'));
    }

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

}