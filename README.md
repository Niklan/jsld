# JSLD module for Drupal

JSLD is simple API for add Json-LD support to your site.

Module doesn't do nothing without you, it's just help you to organize your Json-LD data on site.

For more information you can check **jsld.api.php** file.

## Define your Json-LD info.

~~~php
/**
 * Implements hook_jsld_info().
 */
function MYMODULE_jsld_info() {
  $items['news'] = array(
    'callback' => 'MYMODULE_jsld_news',
  );
  return $items;
}

/**
 * Json-LD definition for news.
 */
function MYMODULE_jsld_news() {
  $result = array();
  if ($node = menu_get_object() && $node->type == 'news') {
    $result[] = array(
      '@context' => 'http://schema.org',
      '@type' => 'NewsArticle',
      'dateCreated' => date('c', $node->created),
      'dateModified' =>  date('c', $node->changed),
    );
  }

  return $result;
}
~~~

This simple code define 'news' info hook for current module with callback function 'MYMODULE_ksld_news' which will be called during page generation. Here you can add all JSON-LD information what you want.

### Tip 1

You also can define custom file and file path which will be loaded for using. This can help you orginize your code for different files. @see jsld.api.php

### Tip 2

You can create **MYMODULE.jsld.inc** file in the root of your module, and place hooks here. This file will load automatically when it needed.

## Alter info hooks

Provide tools to alter info hooks.

~~~php
/**
 * Implements hook_js_info_alter().
 */
function hook_jsld_info_alter(&$info) {
  $info['mymodule']['article']['path'] = drupal_get_path('module', 'jslc') . "/includes/jsld";
}
~~~


## Alter final data.

This can help you to midfy ready to render data. This  called just before `json_encode` and putting this on page.

~~~php
/**
 * Implements hook_jsld_alter().
 */
function hook_jsld_alter(&$jsld) {
  $jsld['@context'] = 'http://schema.org';
}
~~~

## Copyright

Created by Niklan. This module is custom and have no project on drupal.org. So for all updates and info go to [Github project page](https://github.com/Niklan/jsld).
