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

class SaveAndReadBackTest extends \PHPUnit\Framework\TestCase {
    /**
     * @var JSONStore
     */
    private $store;
    /**
     * @var array
     */
    private $initialUsers;
    /**
     * @var User
     */
    private $newUser;

    public function setUp() {
        parent::setUp();

        $this->store = new JSONStore(".");
        $this->initialUsers = $this->store->getUsers();

        $newUserEmail = $this->generateRandomString(5) . "@gmail.com";
        $this->newUser = new User($newUserEmail);

        $this->store->saveUsers(array_merge($this->initialUsers, array($this->newUser)));
    }

    public function testStoreReturnsArrayWithOneMoreItemThanInitialUsers() {
        $usersInStore = $this->store->getUsers();
        $this->assertEquals(count($this->initialUsers) + 1, count($usersInStore));
    }

    public function testNewUserEmailIsReturnedByStore() {
        $usersInStore = $this->store->getUsers();
        $this->assertContains($this->newUser->getEmail(), array_map(function (User $u) { return $u->getEmail(); }, $usersInStore), "User cannot be found in store. \n\nUser:\n" . json_encode($this->newUser) . "\n\nUsers in store:\n" . json_encode($usersInStore) . "\n");

        // TODO check why this assertion does not work - maybe missing == implementation in `User` class?
        // $this->assertContains($this->newUser, $usersInStore, "User cannot be found in store. \n\nUser:\n" . json_encode($this->newUser) . "\n\nUsers in store:\n" . json_encode($usersInStore) . "\n");
    }

    # region Private
    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
    # endregion
}