# OUWBMedlib\Parser
(c) 2020 Oakland University William Beaumont Medical Library

Author: [Keith Engwall <engwall@oakland.edu>](mailto:engwall@oakland.edu)

License: [MIT](https://opensource.org/licenses/MIT)

## Template

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

You can also include the autoload.php file directly in your page 

### Retrieving the Data

In order to retrieve the formatted data from the parser, you must
pass a string matching the page IDs in the [Page Map](PageMap.md)
file to the `RecordsParser::parseRecords()` method.



##
Previous: [Result Array](ResultArray.md) | Next: [Files](Files.md)