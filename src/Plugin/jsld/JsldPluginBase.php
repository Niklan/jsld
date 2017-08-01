<?php

namespace Drupal\jsld\Plugin\jsld;

use Drupal\Component\Plugin\PluginBase;

/**
 * {@inheritdoc}
 */
abstract class JsldPluginBase extends PluginBase implements JsldPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public function getId() {
    return $this->pluginDefinition['id'];
  }

  /**
   * {@inheritdoc}
   */
  public function isEnabled() {
    if (isset($this->pluginDefinition['enabled'])) {
      return $this->pluginDefinition['enabled'];
    }
    else {
      return TRUE;
    }
  }

  /**
   * @return array
   *   The JsonLD array.
   */
  public function build() {
    return [];
  }

}
