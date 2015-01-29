<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ISL\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


/**
 * Description of BlogController
 *
 * @author gberger
 */
class BlogController extends Controller{
    
    public function lireAction($id){
        return new Response('<body>Article '.$id.'</body>');
    }
    
    public function testComplexeAction($mois, $annee, $categorie, $format){
        $content = '<body>';
        $content .= '<h1>Articles de '.$mois.'/'.$annee.'</h1>';
        $content .= '<p>';
        $content .= 'Contenu de la catégorie <b>'.$categorie.'</b>';
        $content .= ' au format '.$format;
        $content .= '</p>';
        $content .= '</body>';
        
        return new Response($content);
    }
    
}
