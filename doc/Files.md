# OUWBMedlib\Parser
(c) 2020 Oakland University William Beaumont Medical Library

Authorengwall@oakland.edu)

License//opensource.org/licenses/MIT)

## Files

Files that you need to configure or reference are listed below:

 vendor/ouwbmedlib/parser

*  **composer.json** - package manifest

*  **data** - user-editable files containing content

*  **page_map.json.example** - sample map to organize data
    
    *  **records.csv.example** - sample source data

*  **doc** - Package Documentation

*  **Config.md** - Details of config.json file

    *  **Files.md** - List of files in package

    *  **Installation.md** - Installation instructions
 
    *  **Overview.md** - Overview of package functionality

    *  **RecordData.md** - Guidelines for record datafile

    *  **RecordParser.md** - Documentation for user interface

    *  **ResultArray.md** - Result structure

    *  **Template.md** - Guidelines for display template

    *  **Usage.md** - Summary of how to use package

*  **LICENSE** - license information

*  **README.md** - front page to documentation

*  **src** - source code and configuration

*  **parser**
 
    *  **Bootstrap.php** - package configuration, error handling, etc.
 
        *  **BootstrapInterface.php**

        *  **config.json.example** - sample configuration file

        *  **FileReader.php** - methods to read CSV and JSON formats

        *  **FileReaderInterface.php**

        *  **RecordsParser** - user interface - parseRecords() method

        *  **RecordsParserInterface.php**

        *  **Validator** - data validation method

        *  **ValidatorInterface**

*  **tests** - unit tests

    *  **parser**
    
        *  **BootstrapTest.php**
 
        *  **FileReaderTest.php**
  
        *  **RecordsParserTest.php**
 
        *  **ValidatorTest.php**




##
Previous: [Template](Template.md)

[Home](../README.md)