<?php

namespace App\Tests\Controller\IO;

use App\Controller\IO\JSONDataLoader;
use Symfony\Component\Dotenv\Exception\PathException;
use Doctrine\Instantiator\Exception\UnexpectedValueException;

class JSONDataLoaderTest extends \PHPUnit\Framework\TestCase
{
    public function testLoadingFromNonExistingPathRaisesPathException()
    {
        $this->expectException(PathException::class);

        JSONDataLoader::loadJSONFileContentsAtPath("/path/to/some/non-existing/folder/file.json");
    }

    public function testLoadingIndexPHPRaisesException()
    {
        $this->expectException(UnexpectedValueException::class);

        JSONDataLoader::loadJSONFileContentsAtPath("public/index.php");
    }

    public function testParsingComposerJSONReturnsSomething() {
        $contents = JSONDataLoader::loadJSONFileContentsAtPath("composer.json");

        $this->assertNotNull($contents);
    }
}
