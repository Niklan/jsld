<?php

namespace Drupal\jsld;

/**
 * {@inheritdoc}
 */
class JsldHelper {

  /**
   * {@inheritdoc}
   */
  protected $jsld;

  /**
   * JsldHelper constructor.
   */
  public function __construct() {
    global $jsld;
    $this->jsld = $jsld;
  }

  /**
   * Used for initialization of global $jsld variable.
   *
   * @see \Drupal\jsld\EventSubscriber\JsldSubscriber::jsldInit().
   */
  public function init() {
    $this->jsld = [];
  }

  /**
   * Return current value for global $jsld.
   *
   * @return array
   */
  public function getJsld() {
    return $this->jsld;
  }

}
