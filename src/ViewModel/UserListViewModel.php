<?php

namespace App\ViewModel;

use App\Entity\User;

class UserListViewModel
{
    /**
     * @var array of User objects
     */
    private $users;

    public function __construct($users)
    {
        $users = array_filter($users, function ($element) {
            return $element instanceof User;
        });

        // seems like all sort functions take the address (&) of a variable and there isn't one which would return the sorted array as a result
        usort($users, function($a, $b) {
            return $a->getAddedDate() <= $b->getAddedDate();
        });

        $this->users = $users;
    }

    /**
     * @return array of User objects
     */
    public function getUsers()
    {
        return $this->users;
    }
}