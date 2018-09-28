<?php

namespace App\Entity;

class User
{
    private $email;
    private $profile_image_url;
    private $profile_image_provider;
    private $added_date;

    /**
     * User constructor.
     * @param string $email
     * @param string $profile_image_url
     * @param ProfileImageProvider, null $profile_image_provider
     * @param \DateTime $added_date The date when the user was added. If null is given, defaults to the current timestamp.
     */
    public function __construct($email, $profile_image_url, $profile_image_provider = null, $added_date = null)
    {
        $this->email = $email;
        $this->profile_image_url = $profile_image_url;
        $this->profile_image_provider = $profile_image_provider;

        if ($added_date instanceof \DateTime) {
            $this->added_date = $added_date;
        } else {
            $this->added_date = new \DateTime();
        }
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getProfileImageUrl()
    {
        return $this->profile_image_url;
    }

    /**
     * @return string, null
     */
    public function getProfileImageProvider()
    {
        return $this->profile_image_provider;
    }

    /**
     * @return \DateTime
     */
    public function getAddedDate(): \DateTime
    {
        return $this->added_date;
    }
}