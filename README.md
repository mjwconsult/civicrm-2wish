# mjw2wish

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

The "patchwork" extension from https://github.com/artfulrobot/patchwork

## Installation

Learn more about installing CiviCRM extensions in the [CiviCRM Sysadmin Guide](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/).

## Configuration

You need to set the `mjw2wish_displaynamecustomfield` setting using the API4 Explorer and Setting.Set.
Find the custom field name by using API4 Explorer Contact.Get and look for it in "Select".

Example: `constituent_information.Marital_Status`

## What this does?

- Adds the contents of a customfield to the contact `display_name` if you specify the name of a custom field in the setting "mjw2wish_displaynamecustomfield".
    Eg. Bob Marley - 123
- Adds " (deceased)" to the end of a contact `display_name` if contact.is_deceased = 1.
    Eg. Bob Marley - 123 (deceased)

The same rules are applied for the relationship tab and "view relationship" even though they are using contact `sort_name`.

