<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ISL\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use ISL\BlogBundle\Entity\Article;
use ISL\BlogBundle\Entity\Commentaire;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


/**
 * Description of BlogController
 *
 * @author gberger
 */
class BlogController extends Controller{
    
    public function indexAction($page=''){
        // récupération du repository défini comme un service
        // voir ISL/BlogBundle/Resources/config/services.yml
        // $repo = $this->get('article_repository');
        
        // méthode traditionnelle pour récupérer le repository
        /** @var  ISL\BlogBundle\Entity\ArticleRepository **/
        $repo = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('ISLBlogBundle:Article');
        
        //$articles = $repo->getAllWithCategorieAndImage();
        $articles = $repo->findAll();
        
        
        return $this->render('ISLBlogBundle::index.html.twig',
                    array('articles'=>$articles)
                );
    }
    /**
     * @Route("/blog/id/{id}")
     * @ParamConverter("article", class="ISLBlogBundle:Article", options={"repository_method"="getArticleAvecCommentairesEtCategories"})
     * 
     */
    public function voirAction(Article $article){
        /** @var \ISL\BlogBundle\Entity\ArticleRepository **/
        
        if($article==null){
            throw $this->createNotFoundException("Pas d'article trouvé pour l'id ".$id);
        }
        return $this->render('ISLBlogBundle:Blog:voir.html.twig', 
                    array('article' => $article)
                );
    }
    
    
    public function lireAction($slug){
        $repo = $this->getDoctrine()->getManager()->getRepository('ISLBlogBundle:Article');
        $article = $repo->findOneBySlug($slug);
        if($article == null){
            throw $this->createNotFoundException('Article non trouvé');
        }
        return $this->render('ISLBlogBundle:Blog:voir.html.twig', 
                array('article'=>$article));
    }
    
    public function ajouterAction(Request $req){
      $article = new Article();
      $formBuilder = $this->createFormBuilder($article);
      $formBuilder->add('auteur')
                ->add('titre')
                ->add('contenu')
                ->add('date')
                ->add('publication');
      $form = $formBuilder->getForm();
      
      $form->handleRequest($req);
      
      if($form->isValid()){
          $em = $this->getDoctrine()->getManager();
          $em->persist($article);
          $em->flush();
          return $this->redirect($this->generateUrl('isl_lire_slug', array('slug'=>$article->getSlug())));
      }
      
      return $this->render('ISLBlogBundle:Blog:ajouter.html.twig', array('form'=>$form->createView()));
        
        
    }
    
    public function modifierAction($id, Request $req){
        return $this->render('ISLBlogBundle:Blog:modifier.html.twig');
    }
   
    public function supprimerAction($id){
        
    }
    
    public function derniersArticlesAction($qty=3){
        $articles = $this->getDoctrine()->getManager()->getRepository('ISLBlogBundle:Article')->findBy(array(), array('updatedAt'=>'DESC'), $qty, 0);
        
        return $this->render('ISLBlogBundle:_partials:derniersArticles.html.twig',array('articles'=>$articles));
    }
    
    public function testAction(){
        $em = $this->getDoctrine()->getManager();
        $categories  = array('analyse', 'développement', 'testing', 'administration système', 'divers');
        foreach($categories as $cat)
        {
            $comp = new \ISL\BlogBundle\Entity\Competence();
            $comp->setNom($cat);
            $em->persist($comp);
        }
        $em->flush();
        return new Response();
    }
}
