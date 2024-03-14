# Path Plugin

Path plugins is attached for specific pages applies on URL paths.

It's used when you need to add JSON-LD on pages with specific paths.

**Annotation example**

```php
use Drupal\jsld\Attribute\JsldPath;
use Drupal\jsld\Enum\PathMatchType;

#[JsldPath(
  id: "organization",
  match_path: ["/about", "<front>", "/info", "/info/*"],
  match_type: PathMatchType::Listed,
)]
```

- id: Machine name for plugin.
- match_Type: (listed, unlisted) The way how paths logic will be used. If set to
listed, than this JSON-LD will be applied only on listed pages from
`match_path`, for unlisted otherwise, on all pages, except listed.
- match_path: An array of paths. Supports for wildcard `*` and `<front>`. If you
set `*`, that plugin will be attached to all pages. Paths must have leading `/`.

This plugins is stored in `/src/Plugin/jsld/path/` path.

## Example of plugin

```php
<?php

namespace Drupal\MODULENAME\Plugin\jsld\path;

use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\jsld\Attribute\JsldPath;
use Drupal\jsld\Enum\PathMatchType;
use Drupal\jsld\Plugin\jsld\JsldPathPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

#[JsldPath(
  id: "organization",
  match_path: ["*"],
  match_type: PathMatchType::Listed,
)]
final class Organization extends JsldPathPluginBase implements ContainerFactoryPluginInterface {

  /**
   * The request stack.
   */
  protected RequestStack $requestStack;

  /**
   * The config factory.
   */
  protected ConfigFactoryInterface $configFactory;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): self {
    $instance = new self($configuration, $plugin_id, $plugin_definition);
    $instance->requestStack = $container->get(RequestStack::class);
    $instance->configFactory = $container->get(ConfigFactoryInterface::class);

    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $host = $this->requestStack->getCurrentRequest()->getSchemeAndHttpHost();
    $config_system_site = $this->configFactory->get('system.site');

    return [
      '@context' => 'https://schema.org',
      '@type' => 'Organization',
      'name' => $config_system_site->get('name'),
      'sameAs' => $host,
      'url' => $host,
    ];
  }

}
```
