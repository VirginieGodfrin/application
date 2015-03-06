<?php

namespace ISL\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="blog_commentaire")
 * @ORM\Entity(repositoryClass="ISL\BlogBundle\Entity\CommentaireRepository")
 */
class Commentaire
{
    
    
    public function __construct() {
        $this->date = new \DateTime();
    }
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="string", length=255)
     */
    private $auteur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

     
    /**
     *
     * @var String
     * @ORM\Column(name="contenu", type="string", length=255)
     */
    private $contenu;
    
    
    /**
     *
     * @var Article
     * @ORM\ManyToOne(targetEntity="Article", cascade={"persist"}, inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;
   
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     * @return Commentaire
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Commentaire
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }
    
    function getArticle() {
        return $this->article;
    }

    function setArticle(Article $article) {
        $this->article = $article;
    }



    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Commentaire
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }
}
