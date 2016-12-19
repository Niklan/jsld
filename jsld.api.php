<?php

/**
 * @file
 *   File with hooks examples.
 */

/**
 * Implements hook_jsld_info().
 */
function hook_jsld_info() {
  $items['news'] = array(
    'callback' => 'mymodule_jsld_news',
  );

  $items['article'] = array(
    'callback' => 'mymodule_jsld_article',
    'file' => 'mymodule.jsld.inc',
  );

  $items['contact'] = array(
    'callback' => 'mymodule_jsld_contact',
    'file' => 'mymodule_contact.inc',
    'path' => drupal_get_path('module', 'jslc') . "/includes/jsld",
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