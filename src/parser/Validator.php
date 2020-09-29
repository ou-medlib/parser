<?php

/**
 * This file is part of the OUWBMedlib\Parser component.
 *
 * This class contains the static validateData() method that validates a string of data
 * according to a specified rule.
 *
 * @fileName Validator.php
 * @version 1.0
 *
 * @author Keith Engwall <engwall@oakland.edu>
 * @copyright (c) Oakland University William Beaumont (OUWB) Medical Library
 * @license MIT
 *
 */

namespace OUWBMedlib\Parser;

/**
 * Class Validator
 * @package Medlib\Parser
 * @implements ValidatorInterface
 */
class Validator implements ValidatorInterface
{

    /**
     * validateData() validates record data based on a set of available rules
     *
     * @param string $data is the data value to be validated
     * @param array $rule is the rule used to validate the data
     * @return bool
     */
    public static function validateData(string $data, array $rule): bool
    {
        $validator = new \Respect\Validation\Validator(); // initialize validator

        // the method specified in the configuration is called as a variable method
        // and thus must match a Respect\Validation\Validator method.
        $method = $rule['method'];

        // an array of arguments may be passed, which will be supplied in the given order
        // to the Respect\Validation\Validator method.
        if( isset($rule['args']) ) {  // if arguments are passed
            $argSet = $rule['args'];
            $args = '';
            foreach ($argSet as $arg) {
                $args .= $arg.", ";
            }
            $argList = preg_replace('/, $/', '', $args);
            $result = $validator->$method($argList)->validate($data);  // validate with arguments
        } else {
            $result = $validator->$method()->validate($data);  // otherwise validate without arguments
        }

        return $result;
    }
}