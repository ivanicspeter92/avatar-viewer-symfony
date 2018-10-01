<?php
/**
 * Created by PhpStorm.
 * User: ivanicspeter92
 * Date: 01/10/2018
 * Time: 7.54
 */

namespace App\Tests\Entity;

use App\Entity\ProfileImageProvider;
use PHPUnit\Framework\TestCase;
use Twig\Profiler\Profile;

class RecognizeFromURLTest extends TestCase
{
    public function testNullValueIsRecognizedAsNull()
    {
        $this->assertNull(ProfileImageProvider::recognizeFromURL(null));
    }

    public function emptyStringIsRecognizedAsNull()
    {
        $this->assertNull(ProfileImageProvider::recognizeFromURL(""));
    }

    public function testRecognizingGravararURLs() {
        $urls = array(
            "https://s.gravatar.com/avatar/a45e413399ecc1437f4a9426e5b47161?s=80",
            "http://s.gravatar.com/avatar/a45e413399ecc1437f4a9426e5b47161?s=80",
            strtoupper("https://s.gravatar.com/avatar/a45e413399ecc1437f4a9426e5b47161?s=80")
        );

        foreach ($urls as $url) {
            $this->assertEquals(ProfileImageProvider::Gravatar, ProfileImageProvider::recognizeFromURL($url), "URL " . $url . " wasn't recognized as Gravatar link!");
        }
    }
}
