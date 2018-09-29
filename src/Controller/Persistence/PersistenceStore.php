<?php

namespace App\Controller\Persistence;


abstract class PersistenceStore
{
    abstract public function getUsers();
}