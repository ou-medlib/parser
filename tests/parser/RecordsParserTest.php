<?php
/**
 * This file is part of the Medlib\Parser component.
 *
 * This class contains the static bootstrap() method that reads a configuration file
 * and sets up error handling.
 *
 * @fileName RecordsParserTest.php
 * @test for RecordsParser.php
 * @version 1.0
 * @author Keith Engwall <engwall@oakland.edu>
 * @copyright (c) Oakland University William Beaumont (OUWB) Medical Library
 * @license MIT
 */

namespace OUWBMedlib\Parser;

use PHPUnit\Framework\TestCase;

/**
 * Class RecordsParserTest
 * @package OUWBMedlib\Parser
 */
class RecordsParserTest extends TestCase
{

    private $root;

    public function setup():void
    {
        $this->root = getSetupPath();
    }

    /**
     * testInvalidPage() checks Exception when the page ID is not in the page map file
     * @throws \Exception
     */
    public function testInvalidPage()
    {
        $this->expectExceptionMessage('bleah not in page map.');
        RecordsParser::parseRecords("bleah",$this->root.'data/config.json');
    }

    /**
     * testInvalidConfig() checks Exception when the return array does not contain an expected key
     * @throws \Exception
     */
    public function testInvalidConfig()
    {
        $this->expectExceptionMessage("File ".$this->root."data/empty_config.json does not contain array with key 'paths'");
        RecordsParser::parseRecords("DEBUG", $this->root.'data/empty_config.json');
    }

    /**
     * thestMissingConfig() checks Exception when the path to the file is wrong
     * @throws \Exception
     */
    public function testMissingConfig()
    {
        $this->expectExceptionMessage('file_get_contents('.realpath(dirname(__DIR__.'/../../src/parser/config.json')).'/config.json): failed to open stream: No such file or directory');
        RecordsParser::parseRecords("DEBUG");
    }

    /**
     * testValidPageRequests checks that the return array contains a record with an expected key
     * @throws \Exception
     */
    public function testValidPageRequests()
    {
        $this->assertArrayHasKey('invalid', RecordsParser::parseRecords("DEBUG",$this->root.'data/config.json'));
        $records = RecordsParser::parseRecords("M1", $this->root.'data/config.json');
        $this->assertStringContainsString('Anatomical',$records[0]['groupName']);
    }
}
