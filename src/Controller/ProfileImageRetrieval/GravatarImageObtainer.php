<?php

namespace App\Controller\ProfileImageRetrieval;

use Ornicar\GravatarBundle\GravatarApi;

/**
 * Class GravatarImageObtainer An adapter to the Gravatar API to resolve profile image related data of users (or other objects).
 * @package App\Controller\ProfileImageRetrieval
 */
class GravatarImageObtainer implements ProfileImageObtainer {
    public function getImageURLForEmail($email) {
        $api = new GravatarApi();

        if ($api->exists($email)) {
            $url = $api->getURL($email);

            return $url;
        } else {
            return null;
        }
    }
}