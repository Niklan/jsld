<?php

namespace Drupal\jsld\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * @Annotation
 */
class JsldPath extends Plugin {

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
   * Array with paths to limit execution. Works with "match_type" and depends on
   * it's value. Can contain wildcard ("*") and Drupal placeholders ("<front>").
   */
  public $match_path;

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
