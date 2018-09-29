<?php

namespace App\Controller\IO;

use Doctrine\Instantiator\Exception\UnexpectedValueException;
use PHPUnit\Runner\Exception;
use Symfony\Component\Dotenv\Exception\PathException;

class JSONDataLoader implements RawDataLoader
{
    /**
     * @param $path string The absolute or relative path to read the data from.
     * @return mixed; an associative array (dictionary) or an array of associative arays (dictionaries)
     * @throws PathException if the path does not exist or is not readable.
     * @throws UnexpectedValueException if the desired file is not in JSON format.
     */
    public static function loadJSONFileContentsAtPath($path)
    {
        $contents = @file_get_contents($path);

        if ($contents === FALSE) {
            throw new PathException($path);
        } else {
            $decoded_contents = json_decode($contents, true);

            if ($decoded_contents == null) {
                throw new UnexpectedValueException("The value in the file at " . $path . "could not be parsed as JSON!");
            } else {
                return $decoded_contents;
            }
        }
    }
}