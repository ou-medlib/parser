<?php
/**
 * This file is part of the OUWBMedlib\Parser component.
 *
 * @fileName BootstrapInterface.php
 * @version 1.0
 * @author Keith Engwall <engwall@oakland.edu>
 * @copyright (c) Oakland University William Beaumont (OUWB) Medical Library
 * @license MIT
 */

namespace OUWBMedlib\Parser;

/**
 * Interface BootstrapInterface
 * @package Medlib\Parser
 */
interface BootstrapInterface
{
    /**
     * bootstrap() sets up error handling and reads the configuration file
     * and returns a config array.
     *
     * @param string $config_path
     * @return array
     */
    public static function bootstrap(string $config_path): array;
}