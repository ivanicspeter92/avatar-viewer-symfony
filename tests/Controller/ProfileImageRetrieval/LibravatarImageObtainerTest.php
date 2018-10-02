<?php

namespace App\Tests\Controller\ProfileImageRetrieval;

use App\Controller\ProfileImageRetrieval\LibravatarImageObtainer;
use PHPUnit\Framework\TestCase;

class LibravatarImageObtainerTest extends TestCase
{
    /**
     * @var LibravatarImageObtainer
     */
    private $obtainer;

    public function setUp()
    {
        $this->obtainer = new LibravatarImageObtainer();
    }

    public function testNullIsReturnedForEmptyEmailString()
    {
        $this->assertNull($this->obtainer->getImageURLForEmail(""));
    }

    public function testNullIsReturnedForNullEmail()
    {
        $this->assertNull($this->obtainer->getImageURLForEmail(null));
    }

    public function testNullIsReturnedForGibberishEmail() {
        $this->assertNull($this->obtainer->getImageURLForEmail("dsadas@gmail.com"));
    }

    public function testExpectedURLContainsImageIDForMyEmail()
    {
        $expectedID = "a45e413399ecc1437f4a9426e5b47161";

        $this->assertContains($expectedID, $this->obtainer->getImageURLForEmail("ivanicspeter92@gmail.com"));
    }
}
