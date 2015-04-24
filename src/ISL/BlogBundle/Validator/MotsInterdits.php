<?php
namespace ISL\BlogBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 *  @Annotation
 */
class MotsInterdits extends Constraint {
    public $message = "vous avez utilisé un mot interdit";
    
    
}
