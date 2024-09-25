<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Validator\BanWorld;

class BanWorldValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var BanWorld $constraint */

        if (null === $value || '' === $value) {
            return;
        }
        $value = strtolower($value);
        foreach ($constraint->banWorlds as $banWorld){
            if (str_contains($value, $banWorld)){
                $this->context->buildViolation($constraint->message)
                ->setParameter('{{ banworld }}', $banWorld)
                ->addViolation();
            }
        }

    } 
}
