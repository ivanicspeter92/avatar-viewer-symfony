<?php

namespace App\Tests\ViewModel;

use PHPUnit\Framework\TestCase;
use App\ViewModel\UserListViewModel;
use App\Entity\User;

class UserListWithStringArrayInitializationTest extends TestCase
{
    private $userList;

    public function __construct()
    {
        parent::__construct();

        $this->userList = new UserListViewModel(array("user1", "user2", "user3"));
    }

    public function testGetUsersReturnsEmptyArray()
    {
        $this->assertEquals(array(), $this->userList->getUsers());
    }
}

class UserListWithWithNowTimestampedUserEntityObjectArrayTest extends TestCase
{
    private $users;
    private $userList;

    public function __construct()
    {
        parent::__construct();

        $this->users = array(
            new User("ivanicspeter92@gmail.com"), // initialized first, has oldest timestamp
            new User("example@example.com"),
            new User("test@test.com") // initialized last, has youngest timestamp
        );
        $this->userList = new UserListViewModel($this->users);
    }

    public function testGetUsersReturnsArrayOfLengthThree()
    {
        $this->assertEquals(3, count($this->userList->getUsers()));
    }

    public function testGetUsersReturnsReverseArrayAsUsers()
    {
        $this->assertEquals(array_reverse($this->users), $this->userList->getUsers());
    }
}

class UserListWithWithCustomTimestampedUserEntityObjectArrayTest extends TestCase
{
    private $users;
    private $userList;

    public function __construct()
    {
        parent::__construct();

        $this->users = array(
            new User("newest@test.com", null, new \DateTime("2018-01-01")),
            new User("oldest@test.com", null, new \DateTime("1992-05-25")),
            new User("middle@test.com", null, new \DateTime("2000-01-01"))
        );
        $this->userList = new UserListViewModel($this->users);
    }

    public function testGetUsersReturnsArrayOfLengthThree()
    {
        $this->assertEquals(3, count($this->userList->getUsers()));
    }

    public function testGetUsersReturnsDifferentArrayAsUsers()
    {
        $this->assertNotEquals($this->users, $this->userList->getUsers());
    }
}