<?php

namespace ISL\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', 'date')
            ->add('titre', 'text')
            ->add('auteur', 'text')
            ->add('contenu', 'textarea')
            ->add('publication', 'checkbox', array('required'=>false))
            ->add('image', new ImageType())
                
            ->add('categories', 'entity', array(
                                            'class'=> 'ISLBlogBundle:Categorie',
                                            'property' => 'nom',
                                            'multiple' => true,
                                            'expanded' => true,
                                            'query_builder' => function(\ISL\BlogBundle\Entity\CategorieRepository $repo){
                                                
                                                return $repo->getCategoriesFiltrees();
                                            }
                                        )
            )
            
            ->add('save', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ISL\BlogBundle\Entity\Article'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'isl_blogbundle_article';
    }
}
