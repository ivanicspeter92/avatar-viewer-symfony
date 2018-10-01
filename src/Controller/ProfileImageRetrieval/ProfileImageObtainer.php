<?php

namespace App\Controller\ProfileImageRetrieval;

interface ProfileImageObtainer
{
    /**
     * @param $email string
     * @return mixed; a URL string to the image or null if it cannot be found.
     */
    public function getImageURLForEmail($email);
}