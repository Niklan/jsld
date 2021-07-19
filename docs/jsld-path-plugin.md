# Path Plugin

Path plugins is attached for specific pages applies on URL paths.

It's used when you need to add JSON-LD on pages with specific paths.

**Annotation example**

```php
/**
 * @JsldPath(
 *   id = "organization",
 *   match_type = "listed",
 *   match_path = {"/about", "<front>", "/info", "/info/*"}
 * )
 */
```

- id: Machine name for plugin.
- match_Type: (listed, unlisted) The way how paths logic will be used. If set to listed, than this JSON-LD will be applied only on listed pages from `match_path`, for unlisted otherwise, on all pages, except listed.
- match_path: An array of paths. Supports for wildcard `*` and `<front>`. If you set `*`, that plugin will be attached to all pages. Paths must have leading `/`.

This plugins is stored in `/src/Plugin/jsld/path/` path.

## Generate plugin

```sh
drush generate plugin-jsld-path
```

## Example of plugin

```php
<?php

namespace Drupal\MODULENAME\Plugin\jsld\path;

use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\jsld\Plugin\jsld\JsldPathPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @JsldPath(
 *   id = "organization",
 *   match_type = "listed",
 *   match_path = {"*"}
 * )
 */
class Organization extends JsldPathPluginBase implements ContainerFactoryPluginInterface {

   /**
   * The current request.
   */
  protected Request $request;

  /**
   * The config system site.
   */
  protected ImmutableConfig $configSystemSite;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container,array $configuration,$plugin_id,$plugin_definition){
    $instance = new static($configuration, $plugin_id, $plugin_definition);
    $instance->request = $container->get('request_stack')->getCurrentRequest();
    $instance->configSystemSite = $container->get('config.factory')->get('system.site');

    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $host = $this->request->getSchemeAndHttpHost();
    return [
      '@context' => 'https://schema.org',
      '@type' => 'Organization',
      'name' => $this->configSystemSite->get('name'),
      'sameAs' => $host,
      'url' => $host,
    ];
  }

}
```
