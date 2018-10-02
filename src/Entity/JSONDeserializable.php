<?php

namespace App\Entity;


interface JSONDeserializable
{
    public static function fromJSON($json);
}