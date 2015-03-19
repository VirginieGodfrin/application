<?php
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ISL\BlogBundle\Entity\Article;
/**
 * Description of Articles
 *
 * @author gberger
 */
class Articles implements FixtureInterface{
    
    public function load(ObjectManager $manager){
        $nbr = 20;
        
        for($i = 1; $i < $nbr; $i++){
            $article = new Article();
            $article->setAuteur("Greg Berger");
            $article->setTitre("Article ".$i);
            $article->setContenu($i." - Lorem ipsum etc.");
            
            
            $image = new ISL\BlogBundle\Entity\Image();
            $image->setUrl('https://placekitten.com/g/200/300');
            $image->setAlt('placeholder');
            $article->setImage($image);
            $manager->persist($article);
        }
        $manager->flush();
    }
    
}
