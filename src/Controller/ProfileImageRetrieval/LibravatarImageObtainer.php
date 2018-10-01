<?php

namespace App\Controller\ProfileImageRetrieval;

use Services_Libravatar;

class LibravatarImageObtainer implements ProfileImageObtainer
{
    public function getImageURLForEmail($email)
    {
        $api = new Services_Libravatar();

        $url = $api->getUrl($email);

        return $url;
    }
}