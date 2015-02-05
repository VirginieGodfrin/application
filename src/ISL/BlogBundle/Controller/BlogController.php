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
        
    }
    
    public function voirAction($id){
        return new Response('<body>Article '.$id.'</body>');
    }
    
    public function ajouterAction(){
        
    }
    
    public function modifierAction($id){
        
    }
   
    public function supprimerAction($id){
        
    }
}
