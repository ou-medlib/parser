# OUWBMedlib\Parser
(c) 2020 Oakland University William Beaumont Medical Library

Author: [Keith Engwall <engwall@oakland.edu>](mailto:engwall@oakland.edu)

License: [MIT](https://opensource.org/licenses/MIT)

## Overview
The OUWBMedlib\Parser is a parsing engine that
will transform a CSV file of records into a validated array
structured for display of the records in set of grouped lists
on one or more pages.

The OUWBMedlib\Parser package consists of 

* a RecordsParser class

* several helper classes
* a page map JSON file containing one or more page identifiers
containing a set of record-list groups to be displayed on the page
* a CSV file within which the records may be managed
* a configuration JSON file containing the paths to the page 
map and records file, the grouping and sorting field labels,
and rules to be used to validate data in specified fields

The parser is accessed via the static method 
`RecordsParser::parseRecords(string $pageID): array`.

Passing a `string $pageID` to the method will return an `array`
containing the set of record lists for that page, which may
be passed to a template for display.

Passing `"DEBUG"` as the pageID will return an `array`
containing a list of all records with the groups to which
they are assigned, as well as a list of any records that
fail a validation check, along with the field that failed
the check.

##

Previous: [Home](../README.md)

Next: [Installation](Installation.md)
