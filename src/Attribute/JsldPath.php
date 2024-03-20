<?php

declare(strict_types=1);

namespace Drupal\jsld\Attribute;

use Drupal\Component\Plugin\Attribute\Plugin;
use Drupal\jsld\Enum\PathMatchType;

/**
 * The JsldPath attribute.
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
final class JsldPath extends Plugin {

  /**
   * Constructs a new JsldPath object.
   *
   * @param string $id
   *   The Plugin ID.
   * @param array $match_path
   *   Paths to match.
   * @param \Drupal\jsld\Enum\PathMatchType $match_type
   *   Match type for "path" type plugin restriction.
   * @param bool $enabled
   *   Define is current plugin enabled or not.
   * @param string|null $deriver
   *   The deriver class.
   */
  public function __construct(
    public readonly string $id,
    public readonly array $match_path,
    public readonly PathMatchType $match_type = PathMatchType::Listed,
    public readonly bool $enabled = TRUE,
    public readonly ?string $deriver = NULL,
  ) {}

}
