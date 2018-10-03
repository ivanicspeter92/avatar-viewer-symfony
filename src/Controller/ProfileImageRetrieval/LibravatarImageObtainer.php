<?php

namespace App\Controller\ProfileImageRetrieval;

use Services_Libravatar;

class LibravatarImageObtainer implements ProfileImageObtainer {
    public function getImageURLForEmail($email) {
        $api = new Services_Libravatar();
        $api->setDefault("404");

        $url = $api->getUrl($email);
        if (@file_get_contents($url)) { // check if the content of the URL is valid data
            return $url;
        } else {
            return null;
        }
    }
}