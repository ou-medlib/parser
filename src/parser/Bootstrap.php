<?php
/**
 * This file is part of the OUWBMedlib\Parser component.
 *
 * This class contains the static bootstrap() method that reads a configuration file
 * and sets up error handling.
 *
 * @fileName Bootstrap.php
 * @version 1.0
 * @author Keith Engwall <engwall@oakland.edu>
 * @copyright (c) Oakland University William Beaumont (OUWB) Medical Library
 * @license MIT
 */

namespace OUWBMedlib\Parser;

use Whoops\Exception\Inspector;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

/**
 * Class Bootstrap
 * @package Medlib\Parser
 * @implements BootstrapInterface
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * bootstrap() sets up error handling and reads the configuration file
     * and returns a config array.
     *
     * @param string $path of the configuration file
     * @return array of configurations
     * @throws \Exception if unable to read configuration file
     */
    public static function bootstrap(string $path): array
    {
        // initialize error handling and format error page
        self::setupErrorHandling();

        // read configurations for file paths, sorting, validation, etc.
        return FileReader::readJSON($path, 'paths');
    }

    /**
     * setupErrorHandling() configures the error handler
     */
    protected static function setupErrorHandling():void {

        // initialize error handler
        $whoops = new Run();
        $handler = new PrettyPageHandler();

        // add details table to error page
        $handler->addDataTableCallback(
            'Details',
            function(Inspector $inspector) {
                $data = array();
                $data['Message'] = $inspector->getExceptionMessage();
                $exception = $inspector->getException();
                $data['Exception class'] = get_class($exception);
                $data['Exception code'] = $exception->getCode();
                $data['Line'] = $exception->getLine();
                return $data;
            }
        );

        // push and register the handler to handle exceptions
        $whoops->pushHandler($handler);
        $whoops->register();
    }

}