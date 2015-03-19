<?php

namespace ISL\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends EntityRepository
{
    
    public function selectAll(){
        return $this->createQueryBuilder('a')
                ->getQuery()
                ->getResult();
    }
    
    public function selectOne($id){
        $qb = $this->createQueryBuilder('a');
        
        $qb->where('a.id = :id');
        $qb->setParameter('id', $id);
        
        $res = $qb->getQuery()->getResult();
        
        if($res){
            // si la requete renvoit des resultats, on prend le premier
            // NB: d'autres méthodes existent $qb->getQuery()->getSingleResult()
            // qui lance une exception si il y a plus d'un résultat
            
            return $res[0];
        }else{
            return null;
        }
    }
    
    
    public function selectByAuteurOuTitre($auteur, $titre){
        $qb = $this->createQueryBuilder('a');
        $qb->where('a.auteur = :auteur');
        $qb->orWhere('a.titre = :titre');
        $qb->setParameter('auteur', $auteur);
        $qb->setParameter('titre', $titre);
        
        return $qb->getQuery()->getResult();
    }
    
    /**
     * 
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @return \Doctrine\ORM\QueryBuilder
     * 
     * filtre les résultats pour l'année en cours
     */
    public function whereAnneeEnCours(\Doctrine\ORM\QueryBuilder $qb){
        $debut = new \DateTime(date('Y').'-01-01');
        $fin = new \DateTime(date('Y').'-12-31');
        
        $qb->andWhere('a.date BETWEEN :debut AND :fin');
        
        $qb->setParameter('debut', $debut);
        $qb->setParameter('fin', $fin);
        
        return $qb;
    }
    
    
    public function selectByAuteurPourAnneeEnCours($auteur){
        $qb = $this->createQueryBuilder('a');
        $qb->where('a.auteur = :auteur');
        $qb->setParameter('auteur', $auteur);
        
        $qb = $this->whereAnneeEnCours($qb);
        return $qb->getQuery()->getResult();
    }
    
    public function selectByMotCleSurTitre($mot_cle){
        $qb = $this->createQueryBuilder('a');
        
        $qb->where($qb->expr()->like('a.titre', ':mot_cle'));
        $qb->setParameter('mot_cle', '%'.$mot_cle.'%');
        
        // filtrer par annee en cours
        // $qb = $this->whereAnneeEnCours($qb);
        return $qb->getQuery()->getResult();
    }
    
    
    public function selectByAuthorOrTitreDQL($auteur, $titre){
        
        $dql = "SELECT a FROM ISLBlogBundle:Article a"
                . "WHERE a.auteur = :auteur"
                . "OR a.titre = :titre";
                
        $query = $this->_em->createQuery($dql);
        $query->setParameter('auteur', $auteur);
        $query->setParameter('titre', $titre);
        
        return $query->getResult();
    }
    
    public function getArticleAvecCommentaires($id){
        $qb = $this->createQueryBuilder('a');
        $qb->join('a.commentaires', 'c');
        $qb->addSelect('c');
        $qb->where('a.id = :id');
        $qb->setParameter('id', $id);
        return $qb->getQuery()->getOneOrNullResult();
    }
}
