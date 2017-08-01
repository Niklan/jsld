<?php

namespace Drupal\jsld\Plugin\jsld;

/**
 * Class JsldEntityPluginBase
 */
abstract class JsldEntityPluginBase extends JsldPluginBase implements JsldPluginInterface {

  /**
   * @var
   */
  public $entity;

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getConfiguration() {
    return $this->configuration;
  }

  /**
   * Gets the current entity.
   *
   * @return \Drupal\Core\Entity\EntityInterface
   *   The current entity.
   */
  public function entity() {
    return $this->configuration['entity'];
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityTypeId() {
    if (isset($this->configuration['entity_type'])) {
      return $this->configuration['entity_type'];
    }
    elseif ($entity = $this->entity()) {
      return $entity->getEntityTypeId();
    }
    else {
      return '';
    }
  }

  /**
   * {@inheritdoc}
   */
  public function bundle() {
    return $this->configuration['bundle'];
  }

  /**
   * {@inheritdoc}
   */
  public function viewMode() {
    return $this->configuration['view_mode'];
  }

}