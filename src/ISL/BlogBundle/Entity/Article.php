<?php

namespace ISL\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use ISL\BlogBundle\Validator\MotsInterdits;
    

/**
 * Article
 *
 * @ORM\Table(name="blog_article")
 * @ORM\Entity(repositoryClass="ISL\BlogBundle\Entity\ArticleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Article
{
    
    
    public function __construct() {
        $this->date = new \DateTime();
        $this->publication = true;
        $this->categories = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @Assert\Length(min=5, minMessage="Le nom de l'auteur doit comporter minimum {{ limit }} caractères")
     * @ORM\Column(name="auteur", type="string", length=255)
     */
    private $auteur;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     * @MotsInterdits(message="non!!")
     */
    private $contenu;
    
    /**
     *
     * @var type boolean
     * 
     * @ORM\Column(name="publication", type="boolean")
     */
    private $publication;
    
    /**
     *
     * @var type String
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist"})
     *  
     */
    private $image;
    
    /**
     *
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Categorie", cascade={"persist"})
     */
    private $categories;
    
    
    /**
     *
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Commentaire", mappedBy="article")
     */
    private $commentaires;
    
    
    /**
     *
     * @var type \DateTime
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;
    
    /**
     *
     * @var type String
     * @Gedmo\Slug(fields={"id","titre"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;


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
     * Set date
     *
     * @param \DateTime $date
     * @return Article
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

    /**
     * Set titre
     *
     * @param string $titre
     * @return Article
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     * @return Article
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
     * Set contenu
     *
     * @param string $contenu
     * @return Article
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
    
    function getPublication() {
        return $this->publication;
    }

    function setPublication($publication) {
        $this->publication = $publication;
    }
    
    function getImage() {
        return $this->image;
    }

    function setImage(Image $image) {
        $this->image = $image;
    }

    function getCategories() {
        return $this->categories;
    }

    function setCategories(ArrayCollection $categories) {
        $this->categories = $categories;
    }

    public function addCategorie(Categorie $cat){
        if(! $this->categories->contains($cat)){
            $this->categories->add($cat);
        }
        
    }
    
    public function removeCategorie(Categorie $cat){
        if($this->categories->contains($cat)){
            $this->categories->removeElement($cat);
        }
    }
    
    function getCommentaires() {
        return $this->commentaires;
    }

    function setCommentaires(ArrayCollection $commentaires) {
        $this->commentaires = $commentaires;
    }

    public function addCommentaire(Commentaire $comm){
        $this->commentaires->add($comm);
        $comm->setArticle($this);
        return $this;
    }
    
    public function removeCommentaire(Commentaire $comm){
        $this->commentaires->removeElement($comm);
    }
    
    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function setUpdatedAt(\DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function refreshUpdateDate(){
        $this->setUpdatedAt(new \DateTime);
    }

    
    function getSlug() {
        return $this->slug;
    }

    function setSlug(type $slug) {
        $this->slug = $slug;
    }
   
}
