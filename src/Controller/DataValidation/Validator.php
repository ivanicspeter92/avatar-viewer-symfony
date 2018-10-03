<?php

namespace App\Controller\DataValidation;

/**
 * An abstract class for validator objects.
 * @package App\Controller\DataValidation
 */
abstract class Validator {
    /**
     * Validates the given value and returns a boolean indicating the result.
     * @param mixed $value The value to validate according to the rules of the Validator.
     * @return bool
     */
    abstract public static function validate($value);

    private function __construct() {
    }
}