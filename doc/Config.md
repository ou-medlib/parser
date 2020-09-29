# OUWBMedlib\Parser
(c) 2020 Oakland University William Beaumont Medical Library

Author: [Keith Engwall <engwall@oakland.edu>](mailto:engwall@oakland.edu)

License: [MIT](https://opensource.org/licenses/MIT)

## Config File

* [Overview](#Overview)
* [Example](#Example)
* [Contents](#Contents)
    * [Paths](#Paths)
    * [GroupBy](#GroupBy)
    * [SortField](#SortField)
    * [Validation](#Validation)

### Overview
The `config.json` file contains the configurations for the OUWBMedlib\Parser package. 
By default, the package looks for this file in the `src/parser` directory*.
An [example file](../src/config.json.example) is provided within the `src/parser` 
directory, and should be renamed to `config.json` once you have entered your
configurations.  

The configurations set within the config.json file are:

* **[Paths](#Paths)** to the [Page Map](PageMap.md) and
[Record Data](RecordData.md) files

* The **[GroupBy](#GroupBy)** element, which contains settings for grouping records into sets
* The **[Sort Field](#SortField)** by which records will be sorted
* **[Validation](#Validation)** rules used to validate data in 
specified fields

* You may specify an alternate path (including file name) to the 
Config file when you call the static `parseRecords` method (see 
[RecordsParser](RecordsParser.md) doc), so you may name it whatever
you like, so long as it is in the json format below.

### Example
Below are the contents of an example `config.json` file:
 ```json
{
     "paths": {
        "recordData": "/path/to/data/records.csv",
        "pageMap": "/path/to/data/page_map.json"
     },
     "groupBy": {
         "field": "Course",
         "delim": ";"
     },
     "sortField": "Author",
     "validation": {
         "URL": {
             "method": "url"
         },
         "Year": {
            "method": "date",
            "args": ["Y"]
         },
         "Edition": {
            "method": "regex",
            "args": ["/1st|2nd|3rd|[4-9]th|[1-9][0-9]th/"]
         }
     }
}
```

### Contents
The `"paths"` element is used to identify the 
config.json file and must be present. 

Let's look at each of these sections:
#### Paths
```json
"paths": {
    "recordData": "/path/to/data/records.csv",
    "pageMap": "/path/to/data/page_map.json"
}
```
The `"paths"` element contains the paths of the 
user-defined files used by the package.

* `"recordData"` is a string that defines the path to the [CSV 
file](RecordData.md) containing the records to be parsed.

* `"pageMap"` is a string that defines the path to the [Page Map](PageMap.md)
file containing information on which group lists
appear on which webpage

#### GroupBy
```json
     "groupBy": {
         "field": "Course",
         "delim": ";"
     }
```
The `"groupBy"` element is used to group records into
lists (e.g. lists of textbooks required in a set of 
courses).

* `"field"` is a string that defines the label of the field in the 
[Record Data](RecordData.md) file that contains 
the IDs (e.g. course IDs) of the groups defined in 
the [Page Map](PageMap.md).

* `"delim"` is a string that defines the delimiter used to separate 
IDs within the groupBy field.

#### SortField
```json
"sortField": "Author"
```
The `"sortField"` element is a string defines the label of the
field in the [Record Data](RecordData.md) file that
whose contents the records will be used to sort the
records in their lists.

#### Validation
```json
"validation": {
    "URL": {
        "method": "url"
    },
    "Year": {
        "method": "date",
        "args": ["Y"]
    },
    "Edition": {
        "method": "regex",
        "args": ["/1st|2nd|3rd|[4-9]th|[1-9][0-9]th/"]
    }
}
```
The `"validation"` element contains rules used
to validate data within specific fields. The 
[Respect\Validation](https://github.com/Respect/Validation)
package is used to validate data.

* `"<FieldLabel>"` is a string that must match the label of the field
containing the data to be validated

* `"method"` is a string defines the name of the 
[Validator method](https://respect-validation.readthedocs.io/en/2.0/list-of-rules/)
used to validate the data.  The `"method"` must match the name of the
method as would be used when calling that method 
(e.g. ['dateTime'](https://respect-validation.readthedocs.io/en/2.0/rules/DateTime/))

* `"args"` is an array that contains the set of arguments to be passed to
the method identified by `"method"`.  See the 
[method documentation](https://respect-validation.readthedocs.io/en/2.0/list-of-rules/)
for details.  Note when reviewing the documentation that arguments are passed directly to the
method, and the data being validated is passed to a validate() submethod:
`Validator::method($args)->validate($data)`.



##

