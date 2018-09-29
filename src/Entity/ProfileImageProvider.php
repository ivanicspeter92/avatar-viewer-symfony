<?php

namespace App\Entity;

/**
 * Class ProfileImageProvider An enumerator class for a set of profile image providers.
 * @package App\Entity
 */
abstract class ProfileImageProvider
{
    const Gravatar = 0;
    const Libravatar = 1;
}