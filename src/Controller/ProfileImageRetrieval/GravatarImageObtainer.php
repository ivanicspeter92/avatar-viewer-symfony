<?php

namespace App\Controller\ProfileImageRetrieval;

use Ornicar\GravatarBundle\GravatarApi;

class GravatarImageObtainer implements ProfileImageObtainer
{
    public function getImageURLForEmail($email)
    {
        $api = new GravatarApi();

        if ($api->exists($email)) {
            $url = $api->getURL($email);

            return $url;
        } else {
            return null;
        }
    }
}