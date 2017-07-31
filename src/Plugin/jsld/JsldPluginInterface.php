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
   * @return string
   *   Plugin type name. Can be entity, path, route.
   */
  public function getType();

  /**
   * @see \Drupal\jsld\Plugin\jsld\JsldPluginInterface::getType();
   *
   * @return string
   *   Entity name for restriction current plugin.
   */
  public function getEntity();

  /**
   * @see \Drupal\jsld\Plugin\jsld\JsldPluginInterface::getEntity();
   *
   * @return array
   *   Array of entity bundles and view modes for restricted entity. Allows
   *   plugins to be called only for specific entity bundle and view mode.
   */
  public function getEntityLimit();

  /**
   * @see \Drupal\jsld\Plugin\jsld\JsldPluginInterface::getType();
   *
   * @return array
   *   Array of paths for restriction of plugin.
   */
  public function getMatchPath();

  /**
   * @see \Drupal\jsld\Plugin\jsld\JsldPluginInterface::getMatchPath();
   *
   * @return string
   *   Type for path matching, it can be listed or unlisted.
   */
  public function getMatchType();

  /**
   * @return array
   *   The JSON-LD array.
   */
  public function jsld();

}
