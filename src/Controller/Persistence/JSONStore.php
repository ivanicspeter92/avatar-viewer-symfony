<?php

namespace App\Controller\Persistence;

use App\Controller\IO\JSONDataLoader;
use Symfony\Component\Dotenv\Exception\PathException;
use App\Entity\User;


/**
 * Class JSONStore A PersistenceStore subclass which users JSON files to store application-specific data.
 * @package App\Controller\Persistence
 */
class JSONStore extends PersistenceStore {
    const defaultPath = __DIR__ . "/../../Repository";  // TODO: not very elegant, should be using root path to the repository instead if possible

    /**
     * @var string
     */
    private $pathToFiles;

    public function __construct($pathToFiles = JSONStore::defaultPath) {
        if (file_exists($pathToFiles)) {
            $this->pathToFiles = $pathToFiles;
        } else {
            throw new PathException($pathToFiles);
        }
    }

    public function getUsers() {
        try {
            $rawUsers = JSONDataLoader::loadJSONFileContentsAtPath($this->getUsersPath());
            $parsedUsers = array_map(function ($u) {
                return User::fromJSON($u);
            }, $rawUsers);

            return $parsedUsers;
        } catch (PathException $ex) {
            return array();
        }
    }

    public function saveUsers($users) {
        $fp = fopen($this->getUsersPath(), 'w');
        fwrite($fp, json_encode($users));
        fclose($fp);
    }

    # region Private
    private function getUsersPath() {
        return $this->pathToFiles . "/users.json";
    }
    # endregion
}