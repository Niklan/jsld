<?php

namespace Drupal\jsld\Plugin\jsld;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * {@inheritdoc}
 */
interface JsldPluginInterface extends PluginInspectionInterface {

  /**
   * {@inheritdoc}
   */
  public function getId();

  /**
   * @return bool
   *   Plugin status. By default all plugin are enabled, but some can be
   *   disabled for many reasons.
   */
  public function isEnabled();

  /**
   * @return array
   *   The JSON-LD array.
   */
  public function build();

}
