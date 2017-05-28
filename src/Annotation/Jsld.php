<?php

namespace Drupal\jsld\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * @Annotation
 */
class PluginMessages extends Plugin {

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
   * The type of plugin execution. Available values:
   * - "entity": restrict this plugin to be called only for specific entity
   *   type.
   * - "path": restrict plugin execution by path.
   */
  public $type;

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

  /**
   * Array with paths to limit execution. Works with "match_type" and depends on
   * it's value. Can contain wildcard ("*") and Drupal placeholders ("<front>").
   */
  public $math_path;

  /**
   * Match type for "path" type plugin restriction.
   *
   * Can be set as:
   * - "listed": (default) show only on pages which listed in array.
   * - "unlisted": for all pages which do'nt match defined in "match_path".
   *
   * @see $type.
   */
  public $match_type;

}
