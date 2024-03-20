# Entity Plugin

Entity plugins is attached for specific entity type and their bundle\view-mode
combinations.

It's used when you need to add JSON-LD on pages where specific entity is
presented.

**Annotation example**

```php
use Drupal\jsld\Attribute\JsldEntity;

#[JsldEntity(
  id: "node_news",
  entity_type: "node",
  entity_limit: ["news|*", "page|full"],
)]
```

- id: Machine name for plugin.
- entity_type: Entity type ID on which this plugin is fired.
- entity_limit: An array of limitation inside entity type. Have structure
`BUNDLE|VIEW_MODE`. Supports for wildcard `*` in both parts. If you set `*|*`,
that plugin will be attached to all entities of this type, on every view mode.

These plugins are stored in `/src/Plugin/jsld/entity/` path.

## Example of plugin

```php
<?php

declare(strict_types=1);

namespace Drupal\MODULENAME\Plugin\jsld\entity;

use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\image\Entity\ImageStyle;
use Drupal\jsld\Attribute\JsldEntity;
use Drupal\jsld\Enum\PathMatchType;
use Drupal\jsld\Plugin\jsld\JsldEntityPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

#[JsldEntity(
  id: "node_news",
  entity_type: "node",
  entity_limit: ["news|*"],
)]
final class NodeNews extends JsldEntityPluginBase implements ContainerFactoryPluginInterface {

  /**
   * The request stack.
   */
  protected RequestStack $requestStack;

  /**
   * The config factory.
   */
  protected ConfigFactoryInterface $configFactory;

  /**
   * The date formatter service.
   */
  protected DateFormatterInterface $dateFormatter;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): self {
    $instance = new self($configuration, $plugin_id, $plugin_definition);
    $instance->requestStack = $container->get(RequestStack::class);
    $instance->configFactory = $container->get(ConfigFactoryInterface::class);
    $instance->dateFormatter = $container->get(DateFormatterInterface::class);

    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $host = $this->requestStack->getCurrentRequest()->getSchemeAndHttpHost();
    $config_system_site = $this->configFactory->get('system.site');

    $result = [
      '@context' => 'https://schema.org',
      '@type' => 'Article',
      'name' => $this->getEntity()->label(),
      'headline' => $this->getEntity()->label(),
      'url' => $this->getEntity()->toUrl('canonical', ['absolute' => TRUE]),
      'mainEntityOfPage' => $this->getEntity()->toUrl('canonical', ['absolute' => TRUE]),
      'datePublished' => $this->dateFormatter->format($this->getEntity()->created->value),
      'dateModified' => $this->dateFormatter->format($this->getEntity()->changed->value),
      'author' => [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $config_system_site->get('name'),
        'sameAs' => $host,
        'url' => $host,
      ],
      'publisher' => [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $config_system_site->get('name'),
        'sameAs' => $host,
        'url' => $host,
      ],
    ];

    if ($this->getEntity()->get('field_news_promo')->isEmpty()) {
      return $result;
    }

    $image = $this->getEntity()->get('field_news_promo')->first()->getEntity();

    if (!isset($image)) {
      return $result;
    }

    $image_url = ImageStyle::load('medium')->buildUrl($image->get('uri')->first()->getValue());
    // This helps to use URL without query parameters.
    $url_parts = (new UrlHelper())->parse($image_url);

    $result['image'] = [
      '@type' => 'ImageObject',
      'url' => $url_parts['path'],
    ];

    return $result;
  }

}
```
