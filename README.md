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
  // Without any additional data, this callback will be called on every page
  // load during preprocessing html. You can access $variables data from argument.
  $items['news'] = array(
    'callback' => 'MYMODULE_jsld_news',
  );

  return $items;
}

/**
 * Json-LD definition for news.
 */
function MYMODULE_jsld_news(&$vars) {
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

This simple code define 'news' info hook for current module with callback function 'MYMODULE_jsld_news' which will be called during page generation. Here you can add all JSON-LD information what you want.

~~~php
/**
 * Implements hook_jsld_info().
 */
function MYMODULE_jsld_info() {
  // This hook will be called only for entity type of node during entity view
  // preparation. It's called on every page where this entity appears.
  $items['news'] = array(
    'callback' => 'MYMODULE_jsld_news',
    'entity' => 'node',
  );

  return $items;
}

function MYMODULE_jsld_news($jsld) {}
~~~

~~~php
/**
 * Implements hook_jsld_info().
 */
function MYMODULE_jsld_info() {
  // This hook will be called only for entity type of node and bundle news.
  // Also it will be called just for teaser view mode of entity. You
  // can set multiple variations and user * for wildcard.
  // F.e. array('news|*', '*|full')
  $items['news'] = array(
    'callback' => 'MYMODULE_jsld_news',
    'entity' => 'node',
    'entity_limit' => array('news|teaser'),
  );

  return $items;
}

function MYMODULE_jsld_news($jsld) {}
~~~

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

## Add data from anywhere.

You can easily add data from every place you like. Use `jsld_push_data()` for this.

F.e. add Review schema.org for entity type `node` and bundle `testimonial`.

~~~php
/**
 * Implements hook_entity_view().
 */
function germes_entity_view($entity, $type, $view_mode, $langcode) {
  global $base_url;

  if ($type == 'node' && $entity->type == 'testimonial') {
    $wrapper = entity_metadata_wrapper('node', $entity);
    $nid = $wrapper->getIdentifier();
    $body = $wrapper->body->value();

    dpm($wrapper->getPropertyInfo());
    $jsld = array(
      '@context' => 'http://schema.org',
      '@type' => 'Review',
      'author' => array(
        '@type' => 'Person',
        'name' => $wrapper->field_testimonial_name->value(),
      ),
      'url' => "$base_url/testimonials#testimonial-$nid",
      'datePublished' => date('c', $entity->created),
      'description' => $body['safe_value'],
      'inLanguage' => $langcode,
      'itemReviewed' => array(
        '@type' => 'Organization',
        'name' => variable_get('site_name', ''),
        'sameAs' => $base_url,
        'url' => $base_url,

      ),
      'reviewRating' =>  array(
        '@type' => 'Rating',
        'worstRating' => 1,
        'bestRating' => 5,
        'ratingValue' => 5,
      ),
    );

    // And finally push data.
    jsld_push_data($jsld);
  }
}
~~~

The same code above but using hook.

~~~php
/**
 * Implements hook_jsld_info().
 */
function MYMODULE_jsld_info() {
  $items['testimonial_teaser'] = array(
    'callback' => 'MYMODULE_jsld_testimonial_teaser',
    'entity' => 'node',
    'entity_limit' => array('testimonial|teaser'),
  );

  return $items;
}

/**
 * Testimonial teaser.
 */
function MYMODULE_jsld_testimonial_teaser($jsld) {
  global $base_url;
  $wrapper = entity_metadata_wrapper('node', $jsld['entity']);
  $nid = $wrapper->getIdentifier();
  $body = $wrapper->body->value();

  $jsld = array(
    '@context' => 'http://schema.org',
    '@type' => 'Review',
    'author' => array(
      '@type' => 'Person',
      'name' => $wrapper->field_testimonial_name->value(),
    ),
    'url' => "$base_url/testimonials#testimonial-$nid",
    'datePublished' => date('c', $wrapper->created->value()),
    'description' => $body['safe_value'],
    'inLanguage' => $jsld['langcode'],
    'itemReviewed' => array(
      '@type' => 'Organization',
      'name' => variable_get('site_name', ''),
      'sameAs' => $base_url,
      'url' => $base_url,

    ),
    'reviewRating' =>  array(
      '@type' => 'Rating',
      'worstRating' => 1,
      'bestRating' => 5,
      'ratingValue' => 5,
    ),
  );

  return $jsld;
}
~~~

## Copyright

Created by Niklan. This module is custom and have no project on drupal.org. So for all updates and info go to [Github project page](https://github.com/Niklan/jsld).
