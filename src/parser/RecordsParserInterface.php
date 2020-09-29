<?php

/**
 * This file is part of the OUWBMedlib\Parser component.
 *
 * @fileName RecordsParserInterface.php
 * @version 1.0
 * @author Keith Engwall <engwall@oakland.edu>
 * @copyright (c) Oakland University William Beaumont (OUWB) Medical Library
 * @license MIT
 *
 */

namespace OUWBMedlib\Parser;

/**
 * Interface RecordsParserInterface
 * @package Medlib\Parser
 */
interface RecordsParserInterface
{
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
     */
    public static function parseRecords(String $pageIdRaw, String $configPathRaw):array;
}