<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\ProfileImageProvider;

class UserWithAllValuesTest extends \PHPUnit\Framework\TestCase
{
    private $email;
    private $profileImageURL;
    private $profileImageProvider;
    private $addedDate;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->email = "ivanicspeter92@gmail.com";
        $this->profileImageURL = "https://s.gravatar.com/avatar/a45e413399ecc1437f4a9426e5b47161?s=80";
        $this->profileImageProvider = ProfileImageProvider::Gravatar;
        $this->addedDate = new \DateTime("2018-09-28T18:38:24.584930Z");
    }

    /**
     * @var User
     */
    private $testUser;

    public function setUp()
    {
        parent::setUp();

        $this->testUser = new User($this->email, $this->profileImageURL, $this->profileImageProvider, $this->addedDate);
    }

    public function testGetEmail()
    {
        $this->assertEquals($this->email, $this->testUser->getEmail());
    }

    public function testGetProfileImageURL()
    {
        $this->assertEquals($this->profileImageURL, $this->testUser->getProfileImageUrl());
    }

    public function testProfileImageProvider()
    {
        $this->assertEquals($this->profileImageProvider, $this->testUser->getProfileImageProvider());
    }

    public function testGetAddedDate()
    {
        $this->assertEquals($this->addedDate, $this->testUser->getAddedDate());
    }
}

class UserInitializedWithoutAddedDate extends \PHPUnit\Framework\TestCase
{
    private $email;
    private $profileImageURL;
    private $profileImageProvider;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->email = "ivanicspeter92@gmail.com";
        $this->profileImageURL = "https://s.gravatar.com/avatar/a45e413399ecc1437f4a9426e5b47161?s=80";
        $this->profileImageProvider = ProfileImageProvider::Gravatar;
    }

    /**
     * @var User
     */
    private $testUser;

    public function setUp()
    {
        parent::setUp();

        $this->testUser = new User($this->email, $this->profileImageURL, $this->profileImageProvider); // datetime should default to NOW
    }

    public function testAddedIsNotNull()
    {
        $this->assertNotNull($this->testUser->getAddedDate());
    }

    public function testAddedDateIsBeforeNow()
    {
        $this->assertLessThan(new \DateTime(), $this->testUser->getAddedDate());
    }
}