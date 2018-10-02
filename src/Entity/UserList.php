<?php

namespace App\Entity;

class UserList
{
    /**
     * @var array of User objects
     */
    private $users;

    /**
     * UserList constructor. Filters out any objects from the array that are not User objects.
     * @param $users array of User objects
     * @param string $sortedBy The attribute to sort by, possible values: null, 'addeddate'.
     */
    public function __construct($users, $sortedBy = "addeddate") {
        $users = array_filter($users, function ($element) {
            return $element instanceof User;
        });

        if (strtolower($sortedBy ) == "addeddate") {
            // seems like all sort functions take the address (&) of a variable and there isn't one which would return the sorted array as a result
            usort($users, function($a, $b) {
                return $a->getAddedDate() <= $b->getAddedDate();
            });
        }

        $this->users = $users;
    }

    /**
     * @return array of User objects
     */
    public function getUsers() {
        return $this->users;
    }
}