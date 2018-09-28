<?php

namespace App\Controller\DataValidation;


/**
 * Class EmailValidator A Validator subclass for validating email addresses.
 * @package App\Controller\DataValidation
 */
class EmailValidator extends Validator
{
    public static function validate($value)
    {
        if (is_string($value))
        {
            $regex = "/[A-Z0-9a-z._%+-]{2,64}+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,64}/";
            $matching_result = preg_match($regex, $value);

            return $matching_result == 1;
        }
        return false;
    }
}