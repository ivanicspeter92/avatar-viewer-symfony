<?php

namespace App\Tests\Controller\ProfileImageRetrieval;

use App\Controller\ProfileImageRetrieval\GravatarImageObtainer;
use PHPUnit\Framework\TestCase;

class GravatarImageObtainerTest extends TestCase
{
    const expectedDefaultIdentifier = "d41d8cd98f00b204e9800998ecf8427e";

    /**
     * @var GravatarImageObtainer
     */
    private $obtainer;

    public function setUp()
    {
        $this->obtainer = new GravatarImageObtainer();
    }


    public function testDefaultReturnedForEmptyEmailString()
    {
        $this->assertContains(GravatarImageObtainerTest::expectedDefaultIdentifier, $this->obtainer->getImageURLForEmail(""));
    }

    public function testDefaultIsReturnedForNullEmail()
    {
        $this->assertContains(GravatarImageObtainerTest::expectedDefaultIdentifier, $this->obtainer->getImageURLForEmail(null));
    }

    public function testExpectedURLContainsImageIDForMyEmail()
    {
        $expectedID = "a45e413399ecc1437f4a9426e5b47161";

        $this->assertContains($expectedID, $this->obtainer->getImageURLForEmail("ivanicspeter92@gmail.com"));
    }
}
