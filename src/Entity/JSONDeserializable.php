<?php

namespace App\Entity;

/**
 * Interface JSONDeserializable A factory method to initialize objects from a JSON array.
 * @var $json array The dictionary/associative array to initialize the object from.
 * @return mixed
 *      object if the initialization passed (the type of the object is the class, where this interface is implemented);
 *      null if the initialization has failed.
 * @package App\Entity
 */
interface JSONDeserializable {
    public static function fromJSON($json);
}