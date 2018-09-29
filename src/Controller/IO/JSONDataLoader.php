<?php

namespace App\Controller\IO;

use Doctrine\Instantiator\Exception\UnexpectedValueException;
use Symfony\Component\Dotenv\Exception\PathException;

class JSONDataLoader implements RawDataLoader
{
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