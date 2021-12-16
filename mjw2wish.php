<?php

require_once 'mjw2wish.civix.php';
// phpcs:disable
use CRM_Mjw2wish_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function mjw2wish_civicrm_config(&$config) {
  _mjw2wish_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function mjw2wish_civicrm_xmlMenu(&$files) {
  _mjw2wish_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function mjw2wish_civicrm_install() {
  _mjw2wish_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function mjw2wish_civicrm_postInstall() {
  _mjw2wish_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function mjw2wish_civicrm_uninstall() {
  _mjw2wish_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function mjw2wish_civicrm_enable() {
  _mjw2wish_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function mjw2wish_civicrm_disable() {
  _mjw2wish_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function mjw2wish_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _mjw2wish_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function mjw2wish_civicrm_managed(&$entities) {
  _mjw2wish_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function mjw2wish_civicrm_angularModules(&$angularModules) {
  _mjw2wish_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function mjw2wish_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _mjw2wish_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function mjw2wish_civicrm_entityTypes(&$entityTypes) {
  _mjw2wish_civix_civicrm_entityTypes($entityTypes);
}

function mjw2wish_patchwork_apply_patch($original, &$code) {
  switch ($original) {
    case '/CRM/Contact/Page/View/Relationship.php':
      _mjwwish_applypatches($original, $code);
      break;

    case '/CRM/Contact/BAO/Relationship.php':
      _mjwwish_applypatches($original, $code);
      break;

  }
}

function _mjwwish_applypatches($file, &$code) {
  $patchData = _mjw2wish_patchdata();
  if (!isset($patchData[$file])) {
    \Civi::log()->debug('nothing to patch for ' . $file);
  }

  $code = explode("\n", $code);
  foreach ($patchData[$file] as $patch) {
    if (array_key_exists('insertAfter', $patch)) {
      $new_code = [];
      while ($code && $code[0] != $patch['insertAfter']) {
        $new_code[] = array_shift($code);
      }
      if (!$code) {
        Civi::log()->error("Patchwork failed on {$file}", []);
        return FALSE;
      }
      // Ok, we found the line to insert after
      // Add the line we're inserting after
      $new_code[] = array_shift($code);
      // Now insert our patch
      $new_code[] = $patch['code'];
      $new_code = array_merge($new_code, $code);
      $code = $new_code;
    }
    elseif (array_key_exists('insertBefore', $patch)) {
      $new_code = [];
      while ($code && $code[0] != $patch['insertBefore']) {
        $new_code[] = array_shift($code);
      }
      if (!$code) {
        Civi::log()->error("Patchwork failed on {$file}", []);
        return FALSE;
      }
      // Ok, we found the function we need to change.
      $new_code[] = $patch['code'];
      $new_code = array_merge($new_code, $code);
      $code = $new_code;
    }
    Civi::log()->notice("Patch successful on {$file}", []);
  }
  $code = implode("\n", $new_code);
}

function _mjw2wish_patchdata() {
  $data = [
    '/CRM/Contact/Page/View/Relationship.php' => [
      [
        'insertAfter' => <<<'CODE'
    $relationship->id = $viewRelationship[$this->getEntityId()]['id'];
CODE,
        'code' => <<<'CODE'
    $viewRelationship[$this->getEntityId()]['name'] = CRM_Contact_BAO_Relationship::formatContactName([
      'name' => $viewRelationship[$this->getEntityId()]['name'],
      'is_deceased' => \Civi\Api4\Contact::get(FALSE)
        ->addWhere('id', '=', $viewRelationship[$this->getEntityId()]['cid'])
        ->addSelect('is_deceased')
        ->execute()
        ->first()['is_deceased'],
    ]);
CODE,
      ],
    ],
    '/CRM/Contact/BAO/Relationship.php' => [
      [
        'insertAfter' => <<<'CODE'
  private static $columnHeaders;
CODE,
        'code' => <<<'CODE'
  /**
   * Format the contact name to show on the relationship
   * Currently adds "deceased" like on contact summary if applicable.
   *
   * @param array $contact
   *
   * @return string
   */
  public static function formatContactName(array $contact): string {
    $name = $contact['name'];
    if (!empty($contact['is_deceased'])) {
      $name .= ' <span class="crm-contact-deceased">(' . ts('deceased') . ')</span>';
    }
    return $name;
  }
CODE,
      ],
      [
        'insertAfter' => <<<'CODE'
      $displayName = CRM_Contact_BAO_Contact::displayName($params['contact_id']);
CODE,
        'code' => <<<'CODE'
      $relationshipContactIDs = CRM_Utils_Array::collect('cid', $relationships);
      $contactIsDeceased = \Civi\Api4\Contact::get(FALSE)
        ->addWhere('id', 'IN', $relationshipContactIDs)
        ->addSelect('is_deceased')
        ->execute()
        ->indexBy('id');
CODE,
      ],
      [
        'insertBefore' => <<<'CODE'
        $relationship['sort_name'] = $icon . ' ' . CRM_Utils_System::href(
CODE,
        'code' => <<<'CODE'
        $values['name'] = self::formatContactName([
          'name' => $values['name'],
          'is_deceased' => $contactIsDeceased[$values['cid']]['is_deceased'],
        ]);
CODE,
      ],
    ],
  ];
  return $data;
}

