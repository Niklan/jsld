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
    return $this->pluginDefinition['enabled'];
  }

  /**
   * {@inheritdoc}
   */
  public function getType() {
    return $this->pluginDefinition['type'];
  }

  /**
   * {@inheritdoc}
   */
  public function getEntity() {
    return $this->pluginDefinition['entity'];
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityLimit() {
    return $this->pluginDefinition['entity_limit'];
  }

  /**
   * {@inheritdoc}
   */
  public function getMatchPath() {
    return $this->pluginDefinition['match_path'];
  }

  /**
   * {@inheritdoc}
   */
  public function getMatchType() {
    return $this->pluginDefinition['match_type'];
  }

  /**
   * @return array
   *   The JsonLD array.
   */
  public function jsld() {
    return [];
  }

}
