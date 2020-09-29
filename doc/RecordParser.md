# OUWBMedlib\Parser
(c) 2020 Oakland University William Beaumont Medical Library

Author: [Keith Engwall <engwall@oakland.edu>](mailto:engwall@oakland.edu)

License: [MIT](https://opensource.org/licenses/MIT)

## RecordParser class

### Overview
The `RecordsParser` class is the only class that you 
need to interface with.

By calling the `RecordsParser::parseRecords()` method 
statically and passing it the ID of the page you've
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
the page associated with the ID passed to the method.
The contents of this array can be displayed by passing it to
a template containing the layout for the data (see [Usage](Usage.md)).
The structure of the array is listed below


### Result Array Structure
The result array will be in one of two formats, depending
on whether you pass a page ID or the "DEBUG" string.

#### Array Structure for page ID
The structure of the result array when a page ID is passed
is 
```
$result:
    <groupID1>: [
        groupName: "Name of group"
        recordList: [
            [
                <Field1>: "Value1",
                <Field2>: "Value2",
                ...
            ],
            [
                <Field1>: "Value1",
                <Field2>: "Value2",
                ...
            ],
            ...
        ]
    ],
    <groupID2>: [
        groupName: "Name of group"
        recordList: [
            ...
        ]
    ],
    ...
]          
```

##### Result Array
```
$result[<groupID>] = array();
```
The top level of the result array has group IDs as keys,
and an array of group data as values.

##### Group Data Array
```
$result[<groupID>][
                    'groupName' => string,
                    'recordList' => array()
                  ];

```
The next level of the result array is the group data
array, which has two keys:
* `"groupName"` is a string for the name of the group

* `"recordList"` contains an array of records

##### Record List Array
```
$result[<groupID>]['recordList']
                        [0]: array(),
                        [1]: array(),
                        [2]: array(),
                        ...
```
The next level of the result array is a list of record arrays

##### Record Array
```
$result[<groupID>]['recordList']
                        [0][
                            '<Field1>' => "Value1",
                            '<Field2>' => "Value2",
                            ...
                        ],
                        [1][
                            '<Field1>' => "Value1",
                            '<Field2>' => "Value2",
                            ...
                        ],
                        ...
```
The lowest level of the result array contains record data
keyed on the field labels from the [Record Data](RecordData.md) file.

#### Result Example
Below is an example of how the data in the [Record Data](RecordData.md) example
might look when organized according to the [Page Map](PageMap.md) example,
if the page ID "YR1" was passed to `RecordsParser::parseRecords()`:
```php
RecordsParser::parseRecords("YR1") = array(
    "PHIL120" => array(
        "groupName" => "Ancient Philosophy",                // Groups sorted by name
        "recordList" => array(
            array(
                "Course" => "PHIL120",
                "Title" => "I Drank What?...",
                "Author" => "Kilmer",                       // Records sorted by SortField
                ...
            )
        )   
    ),
    "ENG101" => array(
        "groupName" => "Fundamentals of Writing",           
        "recordList" => array(
            array(                                          // Records are left intact
                "Course" => "ENG101;ENG344",                // Just part of the record
                "Title" => "Style Manual",
                "Author" => "Bates",
                ...
            )                                         
         )
    ),                                                 
    "CHEM101" => array(                                     
        "groupName" => "Introduction to Chemistry",         
        "recordList" => array(                              
            array(                                          
                "Course" => "CHEM101",
                "Title" => "Fundamentals of Chemistry",
                "Author" => "Jones",
                ...                                         
            ),
            array(                                          
                 "Course" => "CHEM101;CHEM230",
                 "Title" => "Lab Safety and You",
                 "Author" => "Smith",
                 ...                                           
            ),
            ...                                             
        )
    ),
);
```
* Note that the groups are sorted by the group name.

* The titles are sorted by the `SortField` configuration 
from the [Config File](Config.md).

* The record from the [Record Data](RecordData.md) file 
remains intact. Note that the `GroupBy` field is present, 
but only serves as data in this context.

#### Array Structure for DEBUG
The structure of the result array when "DEBUG" is passed to the
`parseRecords()` method is slightly different.

```
$result:
    recordList: [
        [
            <Field1>: "Value1",
            <Field2>: "Value2",
            ...
            groupList: [
                <groupID1>: <groupName1>,
                <groupID2>: <groupName2>,
                ...
            ]
        ],
        ...
    ],
    ['invalid']: [
        [
            <Field1>: "Value1",
            <Field2>: "Value2",
            ...
            invalidField: <FieldN>
        ],
        ...        
    ]    
```
##### Result Array
```
$result[
          'recordList' => array(),
          'invalid' => array()
       ];
```
The top level array has two keys
* `"recordList"` contains all of the records

* `"invalid"` contains a list of records that have 
failed at least one of the validation checks

##### Record Array for Record List
```
$result['recordList'][0][
                '<Field1>' => "Value1",
                '<Field2>' => "Value2",
                ...
                'groupList' => [
                    '<groupID1>' => "groupName1",
                    '<groupID2>' => "groupName2",
                    ...
                ]
            ],
            ...
```
The `'recordList'` array contains a list of records, 
each of which has all of its original fields, plus
a `'groupList'` field, which contains an array of the names
of the groups to which the record belongs.  This allows you
to display either the group ID or group name in the debug display.

##### Record Array for Invalid List
```
$result['invalid'][0][
             '<Field1>' => "Value1",
             '<Field2>' => "Value2",
             ...
             'invalidField' => "<FieldN>"
         ],
         ...
```
The `'invalid'` array contains a list of any records that have
failed a validation check.  Each record has all of its
original field, plus an `'invalidField'` field, which contains
the label of the field whose data failed the validation check,
in order to make it easier to identify errors in the data.