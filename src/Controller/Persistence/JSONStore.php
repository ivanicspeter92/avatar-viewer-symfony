<?php

namespace App\Controller\Persistence;

use App\Controller\IO\JSONDataLoader;
use Symfony\Component\Dotenv\Exception\PathException;
use App\Entity\User;

class JSONStore extends PersistenceStore
{
    const defaultPath = "src/Repository";

    /**
     * @var string
     */
    private $pathToFiles;

    public function __construct($pathToFiles = JSONStore::defaultPath)
    {
        if (file_exists($pathToFiles)) {
            $this->pathToFiles = $pathToFiles;
        } else {
            throw new PathException($pathToFiles);
        }
    }

    public function getUsers()
    {
        $rawUsers = JSONDataLoader::loadJSONFileContentsAtPath($this->pathToFiles . "/users.json");
        $parsedUsers = array_map(function ($u) {
            return $this->parseUser($u);
        }, $rawUsers);

        return $parsedUsers;
    }

    # region Parser functions
    public static function parseUser($record)
    {
        if (isset($record["email"])) {
            $email = $record["email"];

            return new User($email, @$record["profile_image_url"], @$record["profile_image_provider"], new \DateTime(@$record["added_date"]));
        } else {
            return null;
        }
    }
    # endregion
}