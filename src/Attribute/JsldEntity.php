<?php declare(strict_types=1);

namespace Drupal\jsld\Attribute;

use Drupal\Component\Plugin\Attribute\Plugin;

/**
 * The JsldEntity attribute.
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
final class JsldEntity extends Plugin {

  /**
   * Constructs a new JsldEntity object.
   *
   * @param string $id
   *   The Plugin ID.
   * @param string $entity_type
   *   Entity type to execute this plugin for.
   * @param array $entity_limit
   *   Entity limitation. E.g. {"news|teaser", "review|*"}.
   * @param bool $enabled
   * *   Define is current plugin enabled or not.
   * * @param string|null $deriver
   * *   The deriver class.
   */
  public function __construct(
    public readonly string $id,
    public readonly string $entity_type,
    public readonly array $entity_limit = [],
    public readonly bool $enabled = TRUE,
    public readonly ?string $deriver = NULL,
  ) {}

}
