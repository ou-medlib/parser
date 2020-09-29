<?php
/**
 * This file is part of the OUWBMedlib\Parser component.
 *
 * @fileName RecordsParser.php
 * @version 1.0
 * @author Keith Engwall <engwall@oakland.edu>
 * @copyright (c) Oakland University William Beaumont (OUWB) Medical Library
 * @license MIT
 * 
 * @expects a json configuration file (default path: __DIR__."/config.json")
 * @expects a json page map file containing a top level key {'pages': 
 * @expects a CSV spreadsheet of records with a header row of field names
 * 
 * This class contains the static method parseRecords(), which will parse a
 * CSV file of records for display on a set of one or more related webpages.
 *
 * Records are grouped into lists according to a set of identifiers listed in
 * in a specified field within the CSV, and the lists are distributed among
 * webpages according to a json page map file.
 *
 * Record data may be validated by a specified set of validation rules.
 *
 * A json configuration file provides the paths to both the record file and
 * the page map file, as well as grouping and sorting fields, as well as validation
 * rules.
 *
 * This component is used to parse the textbooks spreadsheet maintained 
 * by the OUWB Medical Library into textbook lists for each course in each
 * year of the medical school curriculum.
 */

declare(strict_types=1);

namespace OUWBMedlib\Parser;

/**
 * @className RecordsParser
 * @package Medlib\Textbooks
 * @implements RendererInterface
 */
class RecordsParser implements RecordsParserInterface
{
    const CONFIG_PATH = __DIR__ . '/config.json'; // configuration file
    const PARSE_DEBUG = 'DEBUG'; // argument for debug mode

    /**
     * The parseRecords() function is called with a page ID string, which is used to
     * identify the set of grouping lists for the corresponding page as indicated
     * in the page map file.
     *
     * An alternative path to the configuration file may also be provided.
     *
     * @param string $pageIdRaw is the page requested by the user
     * @param string $configPathRaw is the path of the config file
     * @return array textbook data organized and sorted for display
     * @throws \Exception in DEBUG mode as a means of testing the page
     *                    after an update
     */
    public static function parseRecords(string $pageIdRaw, string $configPathRaw=self::CONFIG_PATH): array
    {
        // sanitize inputs
        $pageID = filter_var($pageIdRaw, FILTER_SANITIZE_STRING);
        $configPath = filter_var($configPathRaw, FILTER_SANITIZE_STRING);

        // set up error handling, read configurations, etc.
        $config = Bootstrap::bootstrap($configPath);

        // get pageMap data
        $mapPath = $config['paths']['pageMap'];
        $pageMap = self::getPageMap($mapPath);
        
        // get record data
        $dataPath = $config['paths']['recordData'];
        $recordData = self::getRecordData($dataPath, $config);

        // parse the record data according to the page map for the page specified by $pageID
        return self::parseData($pageID, $pageMap, $recordData);
    }

    /**
     * getPageMap() checks the path for a json file containing top level element 'pages'
     * and returns the page map data within.
     * 
     * @param string $path is the file path
     * @return array is an array of the contents of the 'pages' element
     * @throws \Exception if top level 'pages' is missing
     */
    private static function getPageMap(string $path): array
    {
        // load page map data for courses
        $pageData = FileReader::readJSON($path, 'pages');
        
        return $pageData['pages'];
    }

    /**
     * getRecordData() checks the path for a CSV file of records containing header labels
     * for grouping and sorting fields, and returns an array of the records, the expected
     * fields, and validation rules specified in configurations
     * 
     * @param string $path is the path to the records CSV file
     * @param array $config is the configurations
     * @return array of records, required field labels, and validation rules
     * @throws \Exception if unable to load CSV file or if CSV file does not contain required labels
     */
    private static function getRecordData(string $path, array $config): array
    {
        $recordData = array();
        // get the textbook data records
        $recordData['records'] = FileReader::readCSV($path, $config['groupBy']['field'], $config['sortField']);
        // get the validation methods for the data
        $recordData['validation'] = $config['validation'];
        // get the field data will be grouped by from the config file
        $recordData['groupBy'] = $config['groupBy'];
        // get the field data will be sorted by from the config file
        $recordData['sortField'] = $config['sortField'];

        return $recordData;
    }
    
    /**
     * parseData() parses records and groups them by set of groups in the specified grouping field, 
     * sorting the records by the specified sorting field, and organizes the groups according to
     * the page map.
     * 
     * In debug mode, the record data is validated and records are placed into a single list, 
     * sorted by the sorting field.  A list of records that failed validation is also generated
     * for review.
     * 
     * @param string $pageID is the id used to identify the page (or for debug mode)
     * @param array $pageMap is the page map data
     * @param array $data contains records, grouping and sorting fields, and validation rules
     * @return array is an array of records parsed for display
     * @throws \Exception if unable to parse the data
     */
    private static function parseData(string $pageID, array $pageMap, array $data): array
    {
        // create array for result
        $result = array();

        //pull in configurations for the sorting and grouping fields
        $sortField = $data['sortField'];
        $groupField = $data['groupBy']['field'];
        $delim = $data['groupBy']['delim'];
        
        // pull in the records
        $records = $data['records'];

        // If the page argument passed is the debug keyword, provide debug report.
        //
        // The debug report will provide a single list of all records with record data,
        // including the set of groups under which the record is listed.
        //
        // The debug report will also provide a list of records that fail validation
        // so that they may be checked.
        //
        if ( $pageID == self::PARSE_DEBUG ) {
            
            // validate the record data and store invalid records for the report
            $validationRules = $data['validation'];
            $invalidRecords = self::validate($records, $validationRules);
            $result['invalid'] = self::recordSort($invalidRecords, $sortField);
            
            // compile list of all listing groups in page map
            $groups = array();
            foreach ( $pageMap as $key => $page) {
                $groups = array_merge($groups, $page);
            }

            // initialize record list in result
            $result['recordList'] = array();
            // compile a list of all records, including the set of groups to which they belong
            foreach ($records as $offset => $record) {
                
                // compile list of listing group names, keyed on the group id, for display
                $record['groupList'] = array();
                $keyArray = explode($delim, $record[$groupField]);
                foreach ($keyArray as $groupID) {
                    array_push($record['groupList'], $groups[$groupID]);
                }

                // add record to the record list
                array_push($result['recordList'], $record);
            }

            // sort record list
            $result['recordList'] = self::recordSort($result['recordList'], $sortField);

        // if the page id exists in the page map, create lists of records for each group in that page
        } elseif ( array_key_exists($pageID, $pageMap) ) {
            // get the list of groups in the specified page
            $groups = $pageMap[$pageID];
            // create an array for each group containing the group name and a list of records
            foreach ($groups as $groupID => $groupName) {
                $result[$groupID]['groupName'] = $groupName;
                $result[$groupID]['recordList'] = array();
            }

            // add records to their corresponding group lists
            foreach ($records as $offset => $record) {
                // get the list of groups in the record's groupBy field
                $keyArray = explode($delim, $record[$groupField]);
                // add the record to each group in the list
                foreach ($keyArray as $key) {
                    if ( array_key_exists($key, $result) ) {
                        array_push($result[$key]['recordList'], $record);
                    }
                }
            }

            // sort list groups for the current page by group name
            usort($result, function($a, $b) {
                return $a <=> $b;
            });

            // sort the records in each group by the sorting field
            foreach ($result as $course => $array) {
                $result[$course]['recordList'] = self::recordSort($result[$course]['recordList'], $sortField);
            }
        } else {
            // if the page ID is not in the page map then throw an exception
            throw new \Exception($pageID." not in page map.");
        }

        // return the parsed array of records for display
        return $result;
    }

    /**
     * validate() goes through the list of records and validates the data according to
     * the validation rules in the configurations.
     *
     * @param array $records is the array of records to be validated
     * @param array $validationRules is an array of validation rules
     * @return array is an array of invalid records and their corresponding label for the debug report
     */
    private static function validate(array $records, array $validationRules): array
    {
        // initialize return array
        $invalidRecords = array();

        // for each book in the file
        foreach ($records as $offset => $record) {

            foreach ($record as $label => $value) {

                // if the field has a validation method defined, validate the value
                if (array_key_exists($label, $validationRules)) {
                    // if the field contains data
                    if ( ! $value == '') {
                        $valid = Validator::validateData($value, $validationRules[$label]);
                        // if the data is invalid, store the record and the corresponding label for debugging
                        if ($valid == false) {
                            $record['invalidField'] = $label;
                            array_push( $invalidRecords, $record);
                        }
                    }

                }

            }
        }
        
        return $invalidRecords;
    }
    
    /**
     * recordSort() sorts a list of records by the specified field
     *
     * @param array $recordList is the list of records
     * @param string $sortField is the field by which to sort the records
     * @return array of sorted records
     */
    private static function recordSort(array $recordList, string $sortField): array
    {
        usort($recordList, function($a, $b) use ($sortField) {
            return $a[$sortField] <=> $b[$sortField];
        });

        return $recordList;
    }
}
