<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;


#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class BanWorld extends Constraint
{
    public function _construct(
        string $message = 'The value "{{ value }}" is not valid.',
        array $banWorlds = ['spam' , 'viagra']) 
    {

    }   
}
