<?php
/**
 * This file is part of the Medlib\Parser component.
 *
 * This class contains the static bootstrap() method that reads a configuration file
 * and sets up error handling.
 *
 * @fileName FileReaderTest.php
 * @test for FileReader.php
 * @version 1.0
 * @author Keith Engwall <engwall@oakland.edu>
 * @copyright (c) Oakland University William Beaumont (OUWB) Medical Library
 * @license MIT
 */

namespace OUWBMedlib\Parser;

use PHPUnit\Framework\TestCase;

/**
 * Class FileReaderTest
 * @package OUWBMedlib\Parser
 */
class FileReaderTest extends TestCase
{
    private $root;

    public function setup():void
    {
        $this->root = getSetupPath();
    }

    /**
     * testReadCSV() tests whether the return array contains a record with an expected 'Title' key
     * @throws \Exception
     */
    public function testReadCSV()
    {
        $csv = FileReader::readCSV($this->root."data/records.csv", "Course","Author");
        $this->assertArrayHasKey('Title', $csv[1]);
    }

    /**
     * testCSVFileNotFoundException() checks the Exception for when the path to the file is wrong
     * @throws \Exception
     */
    public function testCSVFileNotFoundException()
    {
        $this->expectExceptionMessage("`".$this->root."data/record.csv`: failed to open stream: No such file or directory");
        FileReader::readCSV($this->root."data/record.csv", "Courses","Author");
    }

    /**
     * testGroupByException() checks the Exception for when the GroupBy string does not match a record field label
     * @throws \Exception
     */
    public function testGroupByException()
    {
        $this->expectExceptionMessage("Record data file does not have expected header 'Courses'");
        FileReader::readCSV($this->root."data/records.csv", "Courses","Author");
    }

    /**
     * testSortFieldException() checks the Exception for when the SortField string does not match a record field label
     * @throws \Exception
     */
    public function testSortFieldException()
    {
        $this->expectExceptionMessage("Record data file does not have expected header 'Authors'");
        FileReader::readCSV($this->root."data/records.csv", "Course","Authors");
    }

    /**
     * testReadJSON() checks that the return array has the expected key "M1"
     * @throws \Exception
     */
    public function testReadJSON()
    {
        $json = FileReader::readJSON($this->root."data/page_map.json","pages");
        $this->assertArrayHasKey("M1", $json["pages"]);
    }

    /**
     * testReadJSONException() checks the Exception when the return array does not contain an expected key
     * @throws \Exception
     */
    public function testReadJSONException()
    {
        $this->expectExceptionMessage("File ".$this->root."data/page_map.json does not contain array with key 'page'");
        FileReader::readJSON($this->root."data/page_map.json","page");
    }

    /**
     * testJSONFileNotFound() checks the Exception when the path to the file is wrong
     * @throws \Exception
     */
    public function testJSONFileNotFoundException()
    {
        $this->expectExceptionMessage("file_get_contents(".$this->root."data/page_maps.json): failed to open stream: No such file or directory");
        FileReader::readJSON($this->root."data/page_maps.json","page");
    }

}
