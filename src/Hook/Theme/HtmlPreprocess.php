<?php

declare(strict_types=1);

namespace Drupal\jsld\Hook\Theme;

use Drupal\Component\Serialization\Json;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Path\CurrentPathStack;
use Drupal\Core\Path\PathMatcherInterface;
use Drupal\jsld\Enum\PathMatchType;
use Drupal\jsld\Plugin\JsldPluginManager;
use Drupal\path_alias\AliasManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides hook preprocess for html theme.
 *
 * @see \jsld_preprocess_html()
 */
final readonly class HtmlPreprocess implements ContainerInjectionInterface {

  /**
   * Constructs a new HtmlPreprocess object.
   */
  public function __construct(
    protected JsldPluginManager $entityPathPluginManager,
    protected PathMatcherInterface $pathMatcher,
    protected CurrentPathStack $currentPath,
    protected AliasManagerInterface $aliasManager,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('plugin.manager.jsld.path'),
      $container->get('path.matcher'),
      $container->get('path.current'),
      $container->get('path_alias.manager'),
    );
  }

  /**
   * Implements hook_preprocess_HOOK() for html.
   */
  public function __invoke(array &$variables): void {
    $current_path = $this->currentPath->getPath();
    $current_path_alias = $this->aliasManager->getAliasByPath($current_path);

    foreach ($this->entityPathPluginManager->getDefinitions() as $plugin_id => $plugin) {
      $match_path = $plugin['match_path'];
      $match_type = $plugin['match_type'] ?? PathMatchType::Listed;

      if (\is_string($match_type)) {
        $match_type = PathMatchType::from($match_type);
      }

      $pattern = \implode(\PHP_EOL, $match_path);
      $is_match_path = $this->pathMatcher->matchPath($current_path_alias, $pattern) || $this->pathMatcher->matchPath($current_path, $pattern);

      if ($is_match_path && $match_type === PathMatchType::Unlisted) {
        continue;
      }

      if (!$is_match_path && $match_type === PathMatchType::Listed) {
        continue;
      }

      $instance = $this->entityPathPluginManager->createInstance($plugin_id);

      if (!$instance->isEnabled()) {
        continue;
      }

      $variables['#attached']['html_head'][] = [
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

}
