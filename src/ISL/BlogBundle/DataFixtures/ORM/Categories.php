<?php

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Description of Categories
 *
 * @author gberger
 */
class Categories extends AbstractFixture implements OrderedFixtureInterface{
    
    public function load(\Doctrine\Common\Persistence\ObjectManager $manager) {
        $categories = array('php', 'chatons', 'programmation', 'tutoriel');
        $index = 0;
        foreach ($categories as $cat) {
            $c = new \ISL\BlogBundle\Entity\Categorie();
            $c->setNom($cat);
            
            $manager->persist($c);
            $this->addReference('cat-'.$index, $c);
            $index++;
            
        }
        $manager->flush();
        
    }
    
    public function getOrder() {
        return 1;
    }
}
