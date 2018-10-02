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


class ParseUserRecordWithEmailAndAddedDateTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var array
     */
    private $record;
    /**
     * @var User
     */
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->record = array(
            "email" => "ivanicspeter92@gmail.com",
            "added_date" => "2018-09-28T18:38:24.584930Z"
        );
        $this->user = User::fromJSON($this->record);
    }

    public function testEmailsAreEqual()
    {
        $this->assertEquals($this->record["email"], $this->user->getEmail());
    }

    public function testAddedDatesAreEqual()
    {
        $this->assertEquals(new \DateTime($this->record["added_date"]), $this->user->getAddedDate());
    }
}

class ParseUserRecordFromEmptyDictionaryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var array
     */
    private $record;
    /**
     * @var User
     */
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->record = array();
        $this->user = User::fromJSON($this->record);
    }

    public function testUserIsParsedAsNull()
    {
        $this->assertNull($this->user);
    }
}

class ParseUserRecordWithEmailAddressOnlyTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var array
     */
    private $record;
    /**
     * @var User
     */
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->record = array(
            "email" => "ivanicspeter92@gmail.com"
        );
        $this->user = User::fromJSON($this->record);
    }

    public function testUserIsParsedAsUser()
    {
        $this->assertTrue($this->user instanceof User);
    }

    public function testEmailsAreEqual()
    {
        $this->assertEquals($this->record["email"], $this->user->getEmail());
    }

    public function testAddedDateIsNotNull()
    {
        $this->assertNotNull($this->user->getAddedDate());
    }

    public function testAddedDateIsBeforeCurrentTimetamp()
    {
        $this->assertLessThanOrEqual(new \DateTime(), $this->user->getAddedDate());
    }

    public function testProfileImageProviderIsNull()
    {
        $this->assertNull($this->user->getProfileImageProvider());
    }

    public function testProfileImageIsNull()
    {
        $this->assertNull($this->user->getProfileImageUrl());
    }
}