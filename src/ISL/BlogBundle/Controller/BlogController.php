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


/**
 * Description of BlogController
 *
 * @author gberger
 */
class BlogController extends Controller{
    
    public function indexAction($page=''){
        
        $repo = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('ISLBlogBundle:Article');
        // $repo = $this->get('article_repository');
        $articles = $repo->findAll();
        
        return $this->render('ISLBlogBundle::index.html.twig',
                    array('articles'=>$articles)
                );
    }
    
    public function voirAction($id){
        return new Response('<body>Article '.$id.'</body>');
    }
    
    public function ajouterAction(Request $req){
       
      
       $article = new Article();
       $article->setAuteur('Berger');
       $article->setTitre('Mon premier article');
       $article->setContenu('Lorem ipsum dolor sit amet etc');
       $em = $this->getDoctrine()->getManager();
       $em->persist($article);
       $em->flush();
        return $this->render('ISLBlogBundle:Blog:ajouter.html.twig');
        
        
    }
    
    public function modifierAction($id, Request $req){
        return $this->render('ISLBlogBundle:Blog:modifier.html.twig');
    }
   
    public function supprimerAction($id){
        
    }
    
    public function derniersArticlesAction($qty=3){
        $articles = array(array('titre'=>'Article 1'),array('titre'=>'Article 2'),array('titre'=>'Article 3'),array('titre'=>'Article 4'));
        
        return $this->render('ISLBlogBundle:_partials:derniersArticles.html.twig',array('articles'=>$articles));
    }
    
    public function testAction(){
        $mots_interdits = $this->get('isl_blog.antimotsinterdits');
        $compteur = $mots_interdits->combienDeMotsInvalides("terroriste nazi nul!");
        if($compteur > 0){
            throw new \Exception("Trop de mots interdits");
            
        }
        return $this->render("ISLBlogBundle::index.html.twig");
    }
}
