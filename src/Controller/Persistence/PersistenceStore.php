<?php

namespace App\Controller\Persistence;

/**
 * Class PersistenceStore An abstract class for objects which are responsible for storing and reloading application-specific data.
 * @package App\Controller\Persistence
 */
abstract class PersistenceStore {
    /**
     * @return array The array of users retrieved from the storage.
     */
    abstract public function getUsers();

    /**
     * @param $users
     * @return null
     * @throws \Exception of appropriate type, if storing the users has failed.
     */
    abstract public function saveUsers($users);
}