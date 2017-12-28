<?php

namespace Drupal\jsld\Service;

/**
 * {@inheritdoc}
 *
 * @todo maybe refactor it to JsldGlobal.
 */
class JsldGlobal {

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
  public function get() {
    return $this->jsld;
  }

  /**
   * Add array to global $jsld.
   *
   * @return array
   */
  public function add($element = []) {
    $this->jsld[] = $element;
  }

}