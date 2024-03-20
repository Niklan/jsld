<?php

declare(strict_types=1);

namespace Drupal\jsld\Plugin\jsld;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines jsld plugin.
 */
interface JsldPluginInterface extends PluginInspectionInterface {

  /**
   * Return plugin ID.
   */
  public function getId(): string;

  /**
   * Plugin status.
   *
   * @return bool
   *   Plugin status. By default, all plugin are enabled, but some can be
   *   disabled for many reasons.
   */
  public function isEnabled(): bool;

  /**
   * Build result array with structured data.
   *
   * @return array
   *   An array with JSON-LD structured data.
   */
  public function build(): array;

  /**
   * Returns array with configurations.
   *
   * @return array
   *   An array with plugin configs.
   */
  public function getConfiguration(): array;

}
