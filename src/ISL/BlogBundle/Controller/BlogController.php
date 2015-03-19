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
        
        $articles = $repo->selectAll();
        
        
        return $this->render('ISLBlogBundle::index.html.twig',
                    array('articles'=>$articles)
                );
    }
    
    public function voirAction($id){
        /** @var \ISL\BlogBundle\Entity\ArticleRepository **/
        $repo = $this->getDoctrine()->getManager()->getRepository('ISLBlogBundle:Article');
        
        // utilisation de la méthode de base
        //$article =  $repo->find($id);
        
        // utilisation de notre méthode custom
        $article = $repo->selectOne($id);
        
        if($article==null){
            throw $this->createNotFoundException("Pas d'article trouvé pour l'id ".$id);
        }
        return $this->render('ISLBlogBundle:Blog:voir.html.twig', 
                    array('article' => $article)
                );
    }
    
    public function ajouterAction(Request $req){
       
      
       $article = new Article();
        $article->setAuteur('Greg Berger');
        $article->setTitre('Article sur les compétences');
        $article->setContenu('Cet article nous a permis de tester l\'ajout de catégories');
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
        $repo = $em->getRepository('ISLBlogBundle:Competence');
        $competences = $repo->findAll();
        foreach ($competences as $comp) {
            //$article->addCategorie($categorie);
            $compArt = new \ISL\BlogBundle\Entity\ArticleCompetence();
            $compArt->setArticle($article);
            $compArt->setCompetence($comp);
            $compArt->setNiveau('expert absolu');
            $em->persist($compArt);
            
        }        
        
        $em->flush();
        return $this->render('ISLBlogBundle:Blog:ajouter.html.twig');
        
        
    }
    
    public function modifierAction($id, Request $req){
        return $this->render('ISLBlogBundle:Blog:modifier.html.twig');
    }
   
    public function supprimerAction($id){
        
    }
    
    public function derniersArticlesAction($qty=3){
        $articles = $this->getDoctrine()->getManager()->getRepository('ISLBlogBundle:Article')->findBy(array(), null, $qty, 0);
        
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
