<?php

/**
 * @file
 *   File with hooks examples.
 */

/**
 * Implements hook_jsld_info().
 */
function hook_jsld_info() {
  $items['example1'] = array(
    'callback' => 'mymodule_jsld_example1',
  );

  $items['example2'] = array(
    'callback' => 'mymodule_jsld_example2',
    'file' => 'mymodule.example2.inc',
  );

  $items['example3'] = array(
    'callback' => 'mymodule_jsld_example3',
    'file' => 'mymodule_example3.inc',
    'path' => drupal_get_path('module', 'MYMODULE') . "/includes/jsld",
  );

  $items['example4'] = array(
    'callback' => 'mymodule_jsld_example3',
    'entity' => 'node',
  );

  $items['example5'] = array(
    'callback' => 'mymodule_jsld_example5',
    'entity' => 'node',
    'entity_limit' => array('news|teaser', 'article|full', 'page|*'),
  );

  return $items;
}

/**
 * Implements hook_js_info_alter().
 */
function hook_jsld_info_alter(&$info) {
  $info['mymodule']['article']['path'] = drupal_get_path('module', 'jslc') . "/includes/jsld";
}

/**
 * Implements hook_jsld_alter().
 */
function hook_jsld_alter(&$jsld) {
  $jsld['@context'] = 'http://schema.org';
}
