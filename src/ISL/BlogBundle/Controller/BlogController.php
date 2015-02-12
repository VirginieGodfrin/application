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


/**
 * Description of BlogController
 *
 * @author gberger
 */
class BlogController extends Controller{
    
    public function indexAction($page=''){
        
        return $this->render('ISLBlogBundle::index.html.twig');
    }
    
    public function voirAction($id){
        return new Response('<body>Article '.$id.'</body>');
    }
    
    public function ajouterAction(Request $req){
       
      
       
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
}
