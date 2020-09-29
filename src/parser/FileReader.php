<?php
/**
 * This file is part of the OUWBMedlib\Parser component.
 *
 * This class contains static methods for reading files.
 *
 * @fileName FileReader.php
 * @version 1.0
 * @author Keith Engwall <engwall@oakland.edu>
 * @copyright (c) Oakland University William Beaumont (OUWB) Medical Library
 * @license MIT
 */

namespace OUWBMedlib\Parser;

use League\Csv;

class FileReader implements FileReaderInterface
{
    /**
     * readCSV() reads a csv file into an array keyed by column headers and checks
     * that the expected header fields are present.
     *
     * @param string $path is the path to the CSV file
     * @param string $groupBy is the header label containing grouping data
     * @param string $sortField is the header label for the sorting field
     * @return array of records
     * @throws \Exception
     */
    public static function readCSV(string $path, string $groupBy, string $sortField): array
    {
        // open the CSV in read mode
        $reader = Csv\Reader::createFromPath($path, 'r');

        // set header offset
        $reader->setHeaderOffset(0);

        // check headers for the labels used for grouping and sorting records
        $headers = $reader->getHeader();
        if  ( ! Validator::validateData($groupBy, ["method" => "in", "args" => $headers]) )
        {
            throw new \Exception("Record data file does not have expected header '".$groupBy."'");
        }

        if ( ! Validator::validateData($sortField, ["method" => "in", "args" => $headers]) )
        {
            throw new \Exception("Record data file does not have expected header '".$sortField."'");

        }

        // return array of records
        return iterator_to_array($reader->getRecords());
    }

    /**
     * readJSON() reads a json file and checks it for the expected top-level element.
     *
     * @param string $path is the path to the json file
     * @param string $test is the top level element that is expected to be present
     * @return array of contents under the top-level element
     * @throws \Exception if top level element is not present
     */
    public static function readJSON(string $path, string $test): array
    {

        // open and decode json file at $path
        $file = file_get_contents($path);
        $result = json_decode($file, true);

        // check whether array contains expected key
        if ( ! isset($result[$test])) {
            throw new \Exception("File ".$path." does not contain array with key '".$test."'");
        }

        return $result;
    }
}