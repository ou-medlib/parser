<?php
/**
 * This file is part of the Medlib\Parser component.
 *
 * This class contains the static bootstrap() method that reads a configuration file
 * and sets up error handling.
 *
 * @fileName ValidatorTest.php
 * @test for Validator.php
 * @version 1.0
 * @author Keith Engwall <engwall@oakland.edu>
 * @copyright (c) Oakland University William Beaumont (OUWB) Medical Library
 * @license MIT
 */

namespace OUWBMedlib\Parser;

use PHPUnit\Framework\TestCase;

/**
 * Class ValidatorTest
 * @package OUWBMedlib\Parser
 */
class ValidatorTest extends TestCase
{

    private $root;

    public function setup():void
    {
        $this->root = getSetupPath();
    }

    /**
     * testValidateData() checks that valid fields return a true value upon correct validation
     * and false upon failed validation
     */
    public function testValidateData()
    {
        $this->assertTrue(Validator::validateData("http://github.com",array("method" => "url")));
        $this->assertTrue(Validator::validateData("1984", array("method" => "date","args" => ["Y"])));
        $this->assertFalse(Validator::validateData("httpgithub",array("method" => "url")));
        $this->assertFalse(Validator::validateData("198x", array("method" => "date","args" => ["Y"])));
    }

    /**
     * testBadMethodCall() checks Exception for when the method parameter passed to the validateData is incorrect
     */
    public function testBadMethodCall()
    {
        $this->expectExceptionMessage("Undefined index: method");
        Validator::validateData("1984", array("date","Y"));
    }

    /**
     * testBadArgsCall() checks Exception for when the args parameter passed to validateData is incorrect
     */
    public function testBadArgsCall()
    {
        $this->expectExceptionMessage("Invalid argument supplied for foreach()");
        Validator::validateData("1984", array("method" => "date","args" => "Y"));
    }
}
