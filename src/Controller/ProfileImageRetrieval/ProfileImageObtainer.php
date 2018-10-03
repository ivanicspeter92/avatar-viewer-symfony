<?php

namespace App\Controller\ProfileImageRetrieval;

/**
 * Interface ProfileImageObtainer Responsible for obtaining profile image related data for users (or other objects).
 * @package App\Controller\ProfileImageRetrieval
 */
interface ProfileImageObtainer {
    /**
     * @param $email string
     * @return string; a URL string to the image
     */
    public function getImageURLForEmail($email);
}