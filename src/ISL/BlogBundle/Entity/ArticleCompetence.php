<?php

namespace ISL\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArticleCompetence
 *
 * @ORM\Table(name="blog_article_competence")
 * @ORM\Entity(repositoryClass="ISL\BlogBundle\Entity\ArticleCompetenceRepository")
 */
class ArticleCompetence
{
    
    
    /**
     *
     * @var Article
     * @ORM\ManyToOne(targetEntity="Article", cascade={"persist"})
     * @ORM\Id
     */
    private $article;
    
    
    /**
     *
     * @var Competence
     * @ORM\ManyToOne(targetEntity="Competence", cascade={"persist"})
     * @ORM\Id
     */
    private $competence;


    /**
     * @var string
     *
     * @ORM\Column(name="niveau", type="string", length=255)
     */
    private $niveau;


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
     * Set niveau
     *
     * @param string $niveau
     * @return ArticleCompetence
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return string 
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set article
     *
     * @param \ISL\BlogBundle\Entity\Article $article
     * @return ArticleCompetence
     */
    public function setArticle(\ISL\BlogBundle\Entity\Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \ISL\BlogBundle\Entity\Article 
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set competence
     *
     * @param \ISL\BlogBundle\Entity\Competence $competence
     * @return ArticleCompetence
     */
    public function setCompetence(\ISL\BlogBundle\Entity\Competence $competence)
    {
        $this->competence = $competence;

        return $this;
    }

    /**
     * Get competence
     *
     * @return \ISL\BlogBundle\Entity\Competence 
     */
    public function getCompetence()
    {
        return $this->competence;
    }
}
