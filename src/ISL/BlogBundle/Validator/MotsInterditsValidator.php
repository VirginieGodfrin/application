<?php

namespace ISL\BlogBundle\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
/**
 * 
 *
 * @author gberger
 */
class MotsInterditsValidator extends ConstraintValidator{
    
    public function validate($value, Constraint $constraint){
        $mots_interdits = array('ajax', 'javascript', 'cms', 'wordpress', 'réseaux');
        foreach ($mots_interdits as $mot){
            if(strpos($value, $mot) !== false){
                $this->context->addViolation($constraint->message);
            }
        }
            
    }
}
