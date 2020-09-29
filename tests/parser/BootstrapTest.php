<?php
/**
 * This file is part of the Medlib\Parser component.
 *
 * This class contains the static bootstrap() method that reads a configuration file
 * and sets up error handling.
 *
 * @fileName BootstrapTest.php
 * @test for Bootstrap.php
 * @version 1.0
 * @author Keith Engwall <engwall@oakland.edu>
 * @copyright (c) Oakland University William Beaumont (OUWB) Medical Library
 * @license MIT
 */

namespace OUWBMedlib\Parser;

use PHPUnit\Framework\TestCase;

/**
 * Class BootstrapTest
 * @package OUWBMedlib\Parser
 */
class BootstrapTest extends TestCase
{
    private $root;

    public function setup():void
    {
        $this->root = getSetupPath();
    }

    /**
     * testMissingConfig() checks for an Exception when the config path is wrong
     * @throws \Exception
     */
    public function testMissingConfig()
    {
        $this->expectExceptionMessage('file_get_contents(bleah): failed to open stream: No such file or directory');
        Bootstrap::bootstrap("bleah");
    }

    /**
     * testInvalidConfig() checks for an Exception when the config file lacks the required 'paths' top level key
     * @throws \Exception
     */
    public function testInvalidConfig()
    {
        $this->expectExceptionMessage("File ".$this->root."data/empty_config.json does not contain array with key 'paths'");
        Bootstrap::bootstrap($this->root.'data/empty_config.json');
    }

    /**
     * testValidConfig() checks for the 'paths' key in the returned array
     * @throws \Exception
     */
    public function testValidConfig()
    {
        $this->assertArrayHasKey('paths', Bootstrap::bootstrap($this->root.'data/config.json'));

    }
}
