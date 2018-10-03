<?php

namespace App\Entity;

/**
 * Class ProfileImageProvider An enumerator class for a set of profile image providers.
 * @package App\Entity
 */
abstract class ProfileImageProvider {
    const Gravatar = "Gravatar";
    const Libravatar = "Libravatar";

    static public function recognizeFromURL($string) {
        if (is_string($string)) {
            if (strpos(strtolower($string), "gravatar") != 0)
                return ProfileImageProvider::Gravatar;
            elseif (strpos(strtolower($string), "libravatar") != 0)
                return ProfileImageProvider::Libravatar;
        }
        return null;
    }
}