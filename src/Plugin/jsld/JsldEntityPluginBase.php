<?php declare(strict_types=1);

namespace Drupal\jsld\Plugin\jsld;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Core\Entity\EntityInterface;

/**
 * The abstract base class for entity jsld plugin.
 */
abstract class JsldEntityPluginBase extends PluginBase implements JsldPluginInterface {

  /**
   * An object of current entity.
   */
  protected EntityInterface $entity;

  /**
   * JsldEntityPluginBase constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(array $configuration, string $plugin_id, mixed $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entity = $this->configuration['entity'];
  }

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

  /**
   * Gets entity object.
   *
   * @return \Drupal\Core\Entity\EntityInterface
   *    The current entity object.
   */
  public function getEntity(): EntityInterface {
    return $this->entity;
  }

  /**
   * Gets view mode context.
   *
   * @return string
   *   View mode of entity requested JSON-LD.
   */
  public function getViewMode(): string {
    return $this->configuration['view_mode'];
  }

}
