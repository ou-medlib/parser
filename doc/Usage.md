# OUWBMedlib\Parser
(c) 2020 Oakland University William Beaumont Medical Library

Author: [Keith Engwall <engwall@oakland.edu>](mailto:engwall@oakland.edu)

License: [MIT](https://opensource.org/licenses/MIT)

## Usage

1. Decide which sets of lists you want to display on which 
page on your website, and prepare your [Page Map File](PageMap.md)
accordingly

2. Prepare your [Record Data File](RecordData.md), deciding which column 
will be used to sort your records within your lists, and creating a column
that contains the IDs of the groups (from your page map) in which you wish
each record to be listed.  Use a delimiter (e.g. ';', '|', etc.) to separate
the codes inside the field.
3. Edit the [configuration file](Config.md) `src/config.json.example`
    1. Edit `'recordData'` path to point to your Record Data File
    2. Edit `'pageMap'` path to point to your Page Map File
    3. Edit `'groupBy'` section to specify the group ID `'field'` in your spreadsheet,
    as well as the `'delim'`iter
    4. Edit `'sortField'` to specify the sorting field in your spreadsheet
    5. Edit `'validation'` section to set up validation rules for your 
    data (optional)
4. Rename the configuration file to `config.json`
5. Prepare a [template](Template.md) you will use to load and display the data


##
Previous: [Installation](Installation.md) | Next: [RecordParser Class](RecordParser.md)

[Home](../README.md)