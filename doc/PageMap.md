# OUWBMedlib\Parser
(c) 2020 Oakland University William Beaumont Medical Library

Author: [Keith Engwall <engwall@oakland.edu>](mailto:engwall@oakland.edu)

License: [MIT](https://opensource.org/licenses/MIT)

## Page Map File
* [Overview](#Overview)
* [Example](#Example)
* [Contents](#Contents)
    * [PageIDs](#PageIDs)
    * [Groups](#Groups)

### Overview
The `page_map.json`* file contains the Page Map for the Medlib\Parser package.


The page map consists of

* **[Page IDs](#PageID)** used to identify the page on which the lists
will be displayed

* **[Groups Data](#Groups)** used to configure the group(s) to which each 
record has been assigned in the [Record Data](RecordData.md)

*Note: the path to this file (including its name) is defined within the 
[config.json](Config.md) file, so you may name it whatever you like.

### Example
Below are the contents of an example of an example `page_map.json` file:
```json
{
    "pages": {
        "YR1": {
            "CHEM101": "Introduction to Chemistry",
            "ENG101": "Fundamentals of Writing",
            "PHIL120": "Ancient Philosophy"
        },
        "YR2": {
            "CHEM230": "Organic Chemistry",
            "ENG220": "20th Century American Poetry",
            "REL201": "World Religions",
            "PHYS205": "Modern Physics"
        },
        "YR3": {
            "MATH320": "Differential Equations",
            "PHYS205": "Modern Physics",
            "ENG344": "Advanced Creative Writing"
        }
    }
}
```
### Contents
The `"paths"` element is used to identify the 
page_map.json file and must be present.

#### PageIDs
```json
"YR1": {
    ...
}
```
The `"<PageID>"` element represents a page on your website
and must match the string passed to the `parseRecords()` 
method.  It contains the set of list groups to be displayed
on the page.

#### Groups
```json
"CHEM101": "Introduction to Chemistry",
"ENG101": "Fundamentals of Writing",
"PHIL120": "Ancient Philosophy"
```
The `"<GroupID>" => "<GroupName>"` assignment maps the name
of a group to the Group ID used in the [Record Data](RecordData.md)
to identify a group to which a record has been assigned.  The
`"<GroupID>"` string must match the ID strings used in the records.
The `"<GroupName>"` string may be used as the title of the group's 
record list as displayed on the page.

Note that the *same Group ID* may be used on multiple pages (see
PHYS205 in the example above).  This is appropriate if *all
instances of this group will list the same records*.  If they
have different record lists, then use *a different group ID*
with the same group name, and apply the codes as appropriate in
the [Record Data](RecordData.md) file.

##


