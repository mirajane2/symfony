<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;


#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class BanWorld extends Constraint
{
    public function _construct(
        string $message = 'This contains a banned world {{ banWorld }}',
        array $banWorlds = ['spam' , 'viagra']) 
    {

    }   
}
