<?php

namespace App\Entity;

use App\Controller\DataValidation\EmailValidator;
// use App\Controller\ProfileImageRetrieval\GravatarImageObtainer;
// use App\Controller\ProfileImageRetrieval\LibravatarImageObtainer;

class User
{
    private $email;
    private $profile_image_url;
    private $added_date;

    /**
     * User constructor.
     * @param string $email
     * @param string $profile_image_url
     * @param \DateTime $added_date The date when the user was added. If null is given, defaults to the current timestamp.
     */
    public function __construct($email, $profile_image_url = null, $added_date = null)
    {
        $this->email = $email;

        // if($profile_image_url == null) // fallback to find an image
        //     $profile_image_url = (new GravatarImageObtainer())->getImageURLForEmail($email) ?: (new LibravatarImageObtainer())->getImageURLForEmail($email);

        $this->profile_image_url = $profile_image_url;

        if ($added_date instanceof \DateTime) {
            $this->added_date = $added_date;
        } else {
            $this->added_date = new \DateTime();
        }
    }

    public function hasValidEmail(): bool
    {
        return EmailValidator::validate($this->email);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getProfileImageUrl()
    {
        return $this->profile_image_url;
    }

    public function getProfileImageProvider()
    {
        return ProfileImageProvider::recognizeFromURL($this->profile_image_url);
    }

    public function getAddedDate(): \DateTime
    {
        return $this->added_date;
    }
}