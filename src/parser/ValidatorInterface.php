<?php
/**
 * This file is part of the OUWBMedlib\Parser component.
 *
 * @fileName ValidatorInterface.php
 * @version 1.0
 * @author Keith Engwall <engwall@oakland.edu>
 * @copyright (c) Oakland University William Beaumont (OUWB) Medical Library
 * @license MIT
 */


namespace OUWBMedlib\Parser;

/**
 * Interface ValidatorInterface
 * @package Medlib\Parser
 */
interface ValidatorInterface
{

    /**
     * validateData() validates record data based on a set of available rules
     *
     * @param string $data is the data value to be validated
     * @param array $rule is the rule used to validate the data
     * @return bool
     */
    public static function validateData(string $data, array $rule): bool;
}