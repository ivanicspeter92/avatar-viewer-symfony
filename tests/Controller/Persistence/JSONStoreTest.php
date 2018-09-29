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