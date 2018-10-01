<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\ProfileImageProvider;
use Symfony\Component\Validator\Constraints\Date;

class UserWithAllValuesTest extends \PHPUnit\Framework\TestCase
{
    private $email;
    private $profileImageURL;
    private $addedDate;
    /**
     * @var User
     */
    private $testUser;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->email = "ivanicspeter92@gmail.com";
        $this->profileImageURL = "https://s.gravatar.com/avatar/a45e413399ecc1437f4a9426e5b47161?s=80";
        $this->addedDate = new \DateTime("2018-09-28T18:38:24.584930Z");
    }

    public function setUp()
    {
        parent::setUp();

        $this->testUser = new User($this->email, $this->profileImageURL, $this->addedDate);
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
        $this->assertEquals(ProfileImageProvider::Gravatar, $this->testUser->getProfileImageProvider());
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

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->email = "ivanicspeter92@gmail.com";
        $this->profileImageURL = "https://s.gravatar.com/avatar/a45e413399ecc1437f4a9426e5b47161?s=80";
    }

    /**
     * @var User
     */
    private $testUser;

    public function setUp()
    {
        parent::setUp();

        $this->testUser = new User($this->email, $this->profileImageURL); // datetime should default to NOW
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

class UserComparisonTest extends \PHPUnit\Framework\TestCase {
    public function testUserEqualsItself()
    {
        $user = new User("ivanicspeter92@gmail.com");
        $this->assertEquals($user, $user);
    }

    public function testSameEmailAndAddedDateUsersAreEquals()
    {
        $userA = new User("ivanicspeter92@gmail.com", null, new \DateTime("2000-01-01"));
        $userB = new User("ivanicspeter92@gmail.com", null, new \DateTime("2000-01-01"));

        $this->assertEquals($userA, $userB);
    }
}