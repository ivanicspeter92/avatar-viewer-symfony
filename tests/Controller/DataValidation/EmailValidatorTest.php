<?php

namespace App\Tests\Controller\DataValidation;

use App\Controller\DataValidation\EmailValidator;

class EmailValidatorTest extends \PHPUnit\Framework\TestCase
{
    # region Valid email addresses
    public function testMyGmailAddressIsEvaluatedAsTrue()
    {
        $this->assertTrue(EmailValidator::validate("ivanicspeter92@gmail.com"));
    }
    # endregion

    # region Invalid email addresses
    public function testNullValueIsEvaluatedAsFalse()
    {
        $this->assertFalse(EmailValidator::validate(null));
    }

    public function testEmptyStringIsEvaluatedAsFalse()
    {
        $this->assertFalse(EmailValidator::validate(""));
    }

    public function testTooShortUsernameIsEvaluatedAsFalse()
    {
        $this->assertFalse(EmailValidator::validate("a@gmail.com"));
    }

    public function testDomainlessAddressIsEvaluatedAsFalse()
    {
        $this->assertFalse(EmailValidator::validate("ivanicspeter@.com"));
    }

    public function testDomainWithoutUsernameIsEvaluatedAsFalse()
    {
        $this->assertFalse(EmailValidator::validate("@gmail.com"));
    }

    public function testGmailAddressWithoutComEndingIsEvaluatedAsFalse()
    {
        $this->assertFalse(EmailValidator::validate("ivanicspeter92@gmail"));
    }

    public function testDotComEndingIsEvaluatedAsFalse()
    {
        $this->assertFalse(EmailValidator::validate(".com"));
    }

    public function testLocalIPAddressIsEvaluatedAsFalse()
    {
        $this->assertFalse(EmailValidator::validate("127.0.0.1"));
    }
    # endregion
}
