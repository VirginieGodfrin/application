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
            throw $this->createNotFoundException("Pas d'article trouvé pour l'id ".$article->getId());
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
      /*
      $formBuilder = $this->createFormBuilder($article);
      $formBuilder->add('auteur')
                ->add('titre')
                ->add('contenu')
                ->add('date')
                ->add('publication', 'checkbox', array('required'=>false));
      $form = $formBuilder->getForm();
      */
      $form = $this->createForm(new \ISL\BlogBundle\Form\ArticleType(), $article);
      $form->handleRequest($req);
      
      if($form->isValid()){
          $em = $this->getDoctrine()->getManager();
          $em->persist($article);
          $em->flush();
          return $this->redirect(
                  $this->generateUrl('isl_lire_slug', 
                          array('slug'=>$article->getSlug()))
                  );
      }
      
      return $this->render(
              'ISLBlogBundle:Blog:ajouter.html_1.twig', 
              array('form'=>$form->createView())
            );
        
        
    }
    
    public function modifierAction(Article $article){
        $form = $this->createForm(
                new \ISL\BlogBundle\Form\ArticleModificationType(), 
                $article
               );
        
        $form_supprimer = $this->createDeleteForm($article->getId());
        
        $request = $this->get('request');
        $form->handleRequest($request);
        
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirect(
                    $this->generateUrl('isl_lire_slug', 
                            array('slug'=>$article->getSlug())
                            )
                    );
        }
        return $this->render('ISLBlogBundle:Blog:modifier.html.twig', 
                array('form'=>$form->createView(),
                      'form_supprimer' => $form_supprimer->createView()
                    )
                );
    }
   
    public function supprimerAction(Article $article){
        $form = $this->createDeleteForm($article->getId());
        $form->handleRequest($this->get('request'));
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success','Article a été supprimé');
            
        }
        return $this->redirect($this->generateUrl('isl_blog_index'));
    }
    
    private function createDeleteForm($id){
        return $this->createFormBuilder()
                ->setAction(
                    $this->generateUrl('isl_blog_supprimer', 
                                        array('id'=>$id)
                                      )
                    )
                ->setMethod('DELETE')
                ->add('submit', 'submit', array('label'=>'Delete'))
                ->getForm();
        
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
