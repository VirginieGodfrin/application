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
        
        $name = $this->get('session')->get('name');
        
        
        return $this->render(
          'ISLBlogBundle:Blog:test.html.twig',      
          array(
              'page' => 2,
              'objet' => array('nom'=>'Berger', 'prenom'=>'Gregory', 'Age'=>34),
              'html' => '<div>Hello world i\'m in a div</div>',
              'monArray' => array(1,32,43,12),
              'exercice' => array('Nom'=>'Berger', 'Prenom'=>'Gregory', 'Age'=>34, 'Ville'=>'Liège'),
          )
        );
    }
    
    public function voirAction($id){
        return new Response('<body>Article '.$id.'</body>');
    }
    
    public function ajouterAction(Request $req){
       
        $this->get('session')->getFlashBag()
                ->add('error', 'Une erreur est survenue');
        
        $url = $this->generateUrl('isl_blog_index');
        return $this->redirect($url);
        
        
        
    }
    
    public function modifierAction($id){
        
    }
   
    public function supprimerAction($id){
        
    }
}
