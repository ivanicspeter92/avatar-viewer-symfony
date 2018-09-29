<?php

namespace App\Tests\Controller\Persistence;

use App\Controller\Persistence\JSONStore;
use Symfony\Component\Dotenv\Exception\PathException;
use App\Entity\User;

class JSONStoreInitializerTest extends \PHPUnit\Framework\TestCase
{
    public function testInitializingWithInvalidPathRaisesException()
    {
        $this->expectException(PathException::class);

        new JSONStore("/path/to/some/non-existing/folder");
    }

    public function testInitializingWithDefaultPathRaisesNoException()
    {
        try
        {
            $store = new JSONStore();
            $this->assertNotNull($store);
        }
        catch (PathException $ex) {
            $this->fail("PathException occurred - make sure that the default path exists " . JSONStore::defaultPath);
        }
    }
}

class UsersViaDefaultPathTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var JSONStore
     */
    private $store;
    /**
     * @var array
     */
    private $users;

    public function setUp()
    {
        parent::setUp();

        $this->store = new JSONStore();
        $this->users = $this->store->getUsers();
    }

    public function testGetUsersReturnsArray()
    {
        $this->assertTrue(is_array($this->users));
    }

    public function testGetUsersArrayLongerThanOneElement()
    {
        $this->assertTrue(count($this->users) >= 2);
    }

    public function testFirstUserEmailIsAmongEmailsOfObtainedUsers()
    {
        $this->assertContains("ivanicspeter92@gmail.com", array_map(function ($u) {
            return $u->getEmail();
        }, $this->users));
    }

    public function testAllParsedObjectsAreUsers()
    {
        foreach ($this->users as $object) {
            $this->assertTrue($object instanceof User, "Users array contained object with the type " . gettype($object));
        }
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
        $this->user = JSONStore::parseUser($this->record);
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
        $this->user = JSONStore::parseUser($this->record);
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
        $this->user = JSONStore::parseUser($this->record);
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