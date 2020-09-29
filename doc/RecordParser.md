# OUWBMedlib\Parser
(c) 2020 Oakland University William Beaumont Medical Library

Author: [Keith Engwall <engwall@oakland.edu>](mailto:engwall@oakland.edu)

License: [MIT](https://opensource.org/licenses/MIT)

## RecordParser class
* [Overview](#Overview)
* [Interface](#Interface)

### Overview
The `RecordsParser` class is the only class that you 
need to interface with.

By calling the `RecordsParser::parseRecords()` method 
statically from your [display template](Template.md) (or 
corresponding controller if you are using an MVC framework)
and passing it the ID of the page you've
defined in the [Page Map](PageMap.md) file, the method
will return an array of groups, each of which contains 
the group's name and a sorted list of records.

If you pass the method the reserved "DEBUG" ID,
the method will return an array that contains a *record
report* and a *validation report*. 

The **record report** contains all records, each with all of 
its fields, as well as a list of the names of the groups 
to which the record has been assigned.

The **validation report** contains a list of records that
have failed at least one validation check, as defined
in the [Config File](Config.md).

### Interface
Below is the interface to the `RecordsParser` class:
```php
interface RecordsParserInterface
{
    public static function parseRecords(
        String $pageId, 
        String $configPath // optional
        ):array;
}
```
The `parseRecords()` static method takes two 
parameters:

* `$pageId` is a string representing a page defined
in the [Page Map](PageMap.md) file, or the "DEBUG"
string for debug mode

* `$configPath` (optional) is a string indicating an
alternate path to the [Config File](Config.md). By
default, the file is located in the `src/parser` 
directory, and you may leave out this parameter if 
you use it from there

* The `parseRecords()` method will return an array containing the list
of groups, each with a list of records, designated for
the page associated with the ID passed to the method

* The contents of this array can be displayed by passing it to
a [template](Template.md) containing the layout for the data.


##
Previous: [Config File](Config.md) | Next: [Result Array](ResultArray.md)

[Home](../README.md)