<?php
/*
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC. All rights reserved.                        |
 |                                                                    |
 | This work is published under the GNU AGPLv3 license with some      |
 | permitted exceptions and without any warranty. For full license    |
 | and copyright information, see https://civicrm.org/licensing       |
 +--------------------------------------------------------------------+
 */

use CRM_Mjw2wish_ExtensionUtil as E;

return [
  'mjw2wish_displaynamecustomfield' => [
    'name' => 'mjw2wish_displaynamecustomfield',
    'type' => 'String',
    'html_type' => 'text',
    'default' => '',
    'is_domain' => 1,
    'is_contact' => 0,
    'title' => E::ts('Name of custom field to display as "reference" when showing the contact name'),
    'description' => E::ts('This must be in API4 format. Find by using API4 explorer and doing a Contact.Get with Select=custom.*'),
    'html_attributes' => [],
  ]
];
