<?php declare(strict_types=1);

namespace Drupal\jsld\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Annotation for JSON-LD Path Plugin.
 *
 * @Annotation
 */
class JsldPath extends Plugin {

  /**
   * Plugin ID.
   *
   * @var string
   */
  public string $id;

  /**
   * Define is current plugin enabled or not.
   *
   * By default, all plugins enabled, this is needed when some plugins want's to
   * be disabled for some reason.
   *
   * TRUE - enabled.
   * FALSE - disabled.
   *
   * @var bool
   */
  public bool $enabled;

  /**
   * Paths to match.
   *
   * Array with paths to limit execution. Works with "match_type" and depends on
   * its value. Can contain wildcard ("*") and Drupal placeholders ("<front>").
   *
   * E.g. {"<front>", "/node/*", "/news/*"}
   *
   * @var array
   */
  public array $match_path;

  /**
   * Match type for "path" type plugin restriction.
   *
   * Can be set as:
   * - "listed": (default) show only on pages which listed in array.
   * - "unlisted": for all pages which don't match defined in "match_path".
   *
   * @var string.
   */
  public string $match_type;

}
