<?php

declare(strict_types=1);

namespace Drupal\jsld\Plugin\jsld;

use Drupal\Component\Plugin\PluginBase;

/**
 * The abstract base class for path jsld plugin.
 */
abstract class JsldPathPluginBase extends PluginBase implements JsldPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function getId(): string {
    return $this->pluginDefinition['id'];
  }

  /**
   * {@inheritdoc}
   */
  public function getConfiguration(): array {
    return $this->configuration;
  }

  /**
   * {@inheritdoc}
   */
  public function isEnabled(): bool {
    return $this->pluginDefinition['enabled'] ?? TRUE;
  }

}
