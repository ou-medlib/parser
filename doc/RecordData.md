# OUWBMedlib\Parser
(c) 2020 Oakland University William Beaumont Medical Library

Author: [Keith Engwall <engwall@oakland.edu>](mailto:engwall@oakland.edu)

License: [MIT](https://opensource.org/licenses/MIT)

## Records Data File
* [Overview](#Overview)
* [Example](#Example)
* [Contents](#Contents)
    * [GroupBy Field](#GroupBy)
    * [Sort Field](#SortField)

### Overview
The `records.csv`* file is the file of records which 
have been assigned to the various groups defined in the
[Page Map](PageMap.md) file.

This is a file of records and can contain whatever fields you 
wish to display, so long as there is a [Group Field](#GroupBy) 
(e.g. Course) column and a [Sort Field](#SortField) (e.g. Author,
Title, etc.) column.

*Note: the path to this file (including its name) is defined within the 
[config.json](Config.md) file, so you may name it whatever you like.

### Example
Below are the contents of an example `records.csv` file:
```csv
Course, Title, Author, Year, URL
"CHEM101", "Fundamentals of Chemistry", "Jones", "2012", "http://publisher.com/books/view.php?id=1234"
"CHEM101;CHEM230", "Lab Safety and You", "Smith", "2019", "http://university.edu/chemdept/labsafety.htm"
"ENG101;ENG344", "Style Manual", "Bates", "2020", "http://bates.com/style/"
"PHIL120", "I Drank What? The Immortal Words of Socrates", "Kilmer", "1985",
```
In a spreadsheet program, this would look like the following:

|Course|Title|Author|Year|URL|
|------|-----|------|----|---|
|CHEM101|Fundamentals of Chemistry|Jones|2012|http://publisher.com/view.php?id=1234|
|CHEM101;CHEM230|Lab Safety and You|Smith|2019|http://university.edu/chemdept/labsafety.htm|
|ENG101;ENG344|Style Manual|Bates|2020|http://bates.com/style|
|PHIL120|I Drank What? The Immortal Words of Socrates|Kilmer|1985||

### Contents
The `records.csv` file must contain the following:

* List the field labels in the first row
* Enter the field containing the Group IDs in the [Config](Config.md) file, 
under `"GroupBy": "Field":`
* Enter the delimiter used to separate the Group IDs in the [Config](Config.md)
file under `"GroupBy": "Delimiter":`
* Check that all Group IDs are listed in the [Page Map](PageMap.md) file

All other content is optional.  The order of fields does not matter.
If a record is missing a field (see the Kilmer title in the above example)
simply leave the field empty.  It will be stored as an empty field in the
[returned array](RecordParser.md).
