<?php

declare(strict_types=1);

namespace Drupal\jsld\Hook\Entity;

use Drupal\Component\Serialization\Json;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\jsld\Plugin\JsldPluginManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides hook entity view preprocess.
 *
 * @see \jsld_entity_view()
 */
final readonly class EntityView implements ContainerInjectionInterface {

  /**
   * Constructs a new EntityView object.
   */
  public function __construct(
    protected JsldPluginManager $entityJsldPluginManager,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('plugin.manager.jsld.entity'),
    );
  }

  /**
   * Implements hook_entity_view().
   */
  public function __invoke(array &$build, EntityInterface $entity, EntityViewDisplayInterface $display, string $view_mode): void {
    if (!$entity->getEntityTypeId()) {
      return;
    }

    foreach ($this->entityJsldPluginManager->getDefinitions() as $plugin_id => $plugin) {
      if ($plugin['entity_type'] !== $entity->getEntityTypeId()) {
        continue;
      }

      if (!$this->entityLimit($entity, $view_mode, $plugin['entity_limit'])) {
        continue;
      }

      $instance = $this->entityJsldPluginManager->createInstance($plugin_id, [
        'entity' => $entity,
        'view_mode' => $view_mode,
      ]);

      if (!$instance->isEnabled()) {
        continue;
      }

      $build['#attached']['html_head'][] = [
        [
          '#type' => 'html_tag',
          '#tag' => 'script',
          '#attributes' => [
            'type' => 'application/ld+json',
          ],
          '#value' => Json::encode($instance->build()),
        ],
        'jsld_' . $plugin_id,
      ];
    }
  }

  /**
   * Checks if this display is included in the limit.
   */
  private function entityLimit(EntityInterface $entity, string $view_mode, array $limits = []): bool {
    foreach ($limits as $limit) {
      // Every limit must contain separator.
      if (!\str_contains($limit, '|')) {
        continue;
      }

      [$limit_bundle, $limit_view_mode] = \explode('|', $limit);

      $bundle_match = $entity->bundle() === $limit_bundle || $limit_bundle === '*';
      $view_mode_match = $view_mode === $limit_view_mode || $limit_view_mode === '*';

      if ($bundle_match && $view_mode_match) {
        return TRUE;
      }
    }

    return FALSE;
  }

}
