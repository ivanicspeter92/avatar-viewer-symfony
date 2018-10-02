<?php

namespace App\Controller\ProfileImageRetrieval;

use Services_Libravatar;

class LibravatarImageObtainer implements ProfileImageObtainer
{
    private const defaultAvatarIdentifier = "d41d8cd98f00b204e9800998ecf8427e";

    public function getImageURLForEmail($email)
    {
        $api = new Services_Libravatar();

        $url = $api->getUrl($email);

        if (strpos($url, LibravatarImageObtainer::defaultAvatarIdentifier)) {
            return null;
        } else {
            return $url;
        }
    }
}