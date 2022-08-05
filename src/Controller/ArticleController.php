<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article/create", methods={"GET", "POST"}, name="app_article_create")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $article = new Article();

        $form=$this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $article=$form->getData();
            $em->persist($article);
            $em->flush();
            $this->addFlash('success','Article a été crée avec success.');
            return $this->redirectToRoute('app_blog');
        }
        return $this->renderForm('article/create.html.twig',['formArticle'=>$form]);

    }
    /**
     *@Route("/article/{id<[0-9]+>}", name="app_article_show", methods={"GET"})
     */
    public function show(Article $article):Response
    {
        if(null === $article)
        {
            throw $this->createNotFoundException('Article #' . $article->id .'  not found!');
        }
        return $this->render('article/show.html.twig', compact('article'));
    }

    /**
     * @Route("/article/{id<[0-9]+>}/edit", name="app_article_edit", methods={"GET", "PUT", "POST"})
     */
    public function edit(Article $article, Request $request, EntityManagerInterface $em):Response
    {

        $form=$this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success','Article a été modifié avec success.');
            return $this->render('article/show.html.twig',compact('article'));

        }
        return $this->render('article/edit.html.twig', ['articleForm' => $form->createView(),'article'=>$article]);


    }


//    /**
//     * @Route("/article/{id<[0-9]+>}", name="app_article_delete", methods={"DELETE", "POST"})
//     */
//    public function delete(Article $article, Request $request, EntityManagerInterface $em):Response
//    {
//
//
//    }


    /**
     * @Route("/article", name="app_article")
     */
    public function index(ArticleRepository $articleRep): Response
    {
        return $this->render('article/index.html.twig',['article'=>$articleRep->findBy([],['createdAt'=>'ASC'])]);
    }



}
