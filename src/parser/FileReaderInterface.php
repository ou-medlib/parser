<?php
/**
 * This file is part of the OUWBMedlib\Parser component.
 *
 * This class contains static methods for reading files.
 *
 * @fileName FileReaderInterface.php
 * @version 1.0
 * @author Keith Engwall <engwall@oakland.edu>
 * @copyright (c) Oakland University William Beaumont (OUWB) Medical Library
 * @license MIT
 */

namespace OUWBMedlib\Parser;

/**
 * Interface FileReaderInterface
 * @package Medlib\Parser
 */
interface FileReaderInterface
{
    /**
     * readCSV() reads a csv file into an array keyed by column headers and checks
     * that the expected header fields are present.
     *
     * @param string $path is the path to the CSV file
     * @param string $groupBy is the header label containing grouping data
     * @param string $sortField is the header label for the sorting field
     * @return array of records
     */
    public static function readCSV(string $path, string $groupBy, string $sortField):array;

    /**
     * readJSON() reads a json file and checks it for the expected top-level element.
     *
     * @param string $path is the path to the json file
     * @param string $test is the top level element that is expected to be present
     * @return array of contents under the top-level element
     */    public static function readJSON(string $path, string $test):array;
}