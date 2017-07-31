<?php

namespace Drupal\jsld\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * @Annotation
 */
class JsldEntity extends Plugin {

  /**
   * Plugin ID.
   */
  public $id;

  /**
   * Define is current plugin enabled or not. By default all plugins enabled,
   * this is needed when some plugins want's to be disabled for some reasons.
   */
  public $enabled;

  /**
   * Entity type to execute this plugin. Allow to set single entity type.
   *
   * @see $type.
   */
  public $entity;

  /**
   * Entity limitations. If set entity type, this option can help to restrict
   * entity type by bundle and view mode.
   *
   * Array with "$bundle|$view_mode" for each limitation. Supports for wildcard
   * "*" and can be set by multiple bundles and view modes in single plugin.
   *
   * @see $type.
   */
  public $entity_limit;

}
