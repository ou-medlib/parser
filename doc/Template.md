# OUWBMedlib\Parser
(c) 2020 Oakland University William Beaumont Medical Library

Author: [Keith Engwall <engwall@oakland.edu>](mailto:engwall@oakland.edu)

License: [MIT](https://opensource.org/licenses/MIT)

## Template
* [Overview](#Overview)
* [Including the Code](#Including the Code)
* [Retrieving the Data](#Retrieving the Data)
* [Displaying the Data](#Displaying the Data)

### Overview
The OUWBMedlib\Parser package is designed to work with
your display template, whether as part of a framework or
as a made-from-scratch PHP file.

This page will provide some guidance in how to configure your
template to display lists of records, but you have complete
control over how the data appears on your website.

This page only covers the structural display of content.  Formatting
your content with styles is beyond the scope of this document.

### Including the Code
In order to use OUWBMedlib\Parser package, you must load the package 
and its dependencies. If you have installed the package from an existing
composer package (e.g. from a framework), chances are that all packages
will already be autoloaded, and you should be able to simply call the 
`RecordsParser::parseRecords()` method, as described below.

You can also include the autoload.php file directly in your page with
the following statement, typically in the <head>

```php
<?php
    include path/to/autoload.php; //by default, vendor/autoload.php
?>
``` 

### Retrieving the Data

In order to retrieve the formatted data from the parser, you must
pass a string matching the page IDs in the [Page Map](PageMap.md)
file to the `RecordsParser::parseRecords()` method:

```php
<?php
    $pageId = "Pg2"; // use the ID for the current page
    $recordLists = RecordsParser::parseRecords($pageId);
?>
```

You now have a [result array](ResultArray.md) containing each list group
for the current page.

### Displaying the Data

In order to display the data, you must loop over the array and 
echo the contents within your desired template structure.

Below is a basic example in PHP:

```php
if ($pageID == 'DEBUG') {  // print in debug mode
    // print record report
    printTable("Record Report", $recordLists['recordList']);
    // print invalid record report
    printTable("Invalid Records", $recordLists['invalid']);
} else {
  // loop through groups
  foreach ($recordLists as $groupID => $group) {
    // print list using the group name as a title
    printTable($data['groupName'], $data['recordList']);
  }
}

// print the list as a table
function printTable($table_name, $array) {
    echo "<h2>".$table_name."</h2>\n"; // table name
    echo "<table>\n";
    echo "    <tr>";
    echo "<th>Author</th>";
    echo "<th>Title</th>";
    echo "<th>Year</th>";
    echo "<th>ISBN</th>";

    // if we are printing the invalid record report from debug mode, 
    // add a field for the invalid field
    if (isset($array[0]['invalidField'])) { echo "<th>Invalid Field</th>"; }
    echo "</tr>\n";
    // loop through the records and print them in the table
    foreach ($array as $offset => $record) {
        echo "    <tr>";
        echo "<td>".$record['Author']."</td>";
        // You can combine array fields into an organized display.
        echo "<td>";
        // If there's a URL, make a link
        if ($record['URL'] !== '') {
            echo "<a href=\"".$record['URL']."\" target=\"_blank\">";
        }
        echo $record['Title'];
        if ($record['URL'] !== '') { echo "</a>"; }
        // Display the edition if it is specified
        if ($record['Edition'] !== '') {
            echo ", ".$record['Edition']." Ed.";
        }
        // If the book is required, say so 
        // (note the class for adding emphasis through css)
        if ($record['Status'] == 'Required') {
            echo " <span class='required'>Required</span>";
        }
        echo "</td>";
        echo "<td>".$record['Year']."</td>";
        echo "<td>".$record['ISBN']."</td>";
        // If we're in the invalid record report, add this data
        if (isset($record['invalidField'])) { 
            echo "<td>".$record['invalidField']."</td>";
        }
        echo "</tr>\n";
        // if we're in the record report, 
        // add the course list on the next row
        if (isset($record['groupList'])) {
            echo "    <tr>";
            foreach ($record['groupList'] as $course) {
                echo "<td>".$course."</td>";
            }
            echo "</tr>\n";
        } 
    }
    echo "</table>\n";
```
Frameworks may use other template lanugages, such as Twig, but
the logic structures would be similar.  You can then use CSS and/or 
JavaScript to clean up the look or add features such as collapsed lists.

##
Previous: [Result Array](ResultArray.md) | Next: [Files](Files.md)

[Home](../README.md)