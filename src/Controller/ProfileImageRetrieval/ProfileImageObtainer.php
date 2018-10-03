<?php

namespace App\Controller\ProfileImageRetrieval;

interface ProfileImageObtainer {
    /**
     * @param $email string
     * @return string; a URL string to the image
     */
    public function getImageURLForEmail($email);
}