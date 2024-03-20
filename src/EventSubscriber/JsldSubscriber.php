<?php

namespace Drupal\jsld\EventSubscriber;

use Drupal\jsld\Service\JsldGlobal;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Event subscriber for initialisation of service.
 *
 * @deprecated since 1.3, since it has issues with caching. Will be removed in
 *    2.0+.
 */
class JsldSubscriber implements EventSubscriberInterface {

  /**
   * The service collect all data during request.
   *
   * @var \Drupal\jsld\Service\JsldGlobal
   */
  protected $jsldGlobal;


  /**
   * JsldSubscriber constructor.
   *
   * @param \Drupal\jsld\Service\JsldGlobal $jsld_global
   *  The service collect all data during request.
   */
  public function __construct(JsldGlobal $jsld_global) {
    $this->jsldGlobal = $jsld_global;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      KernelEvents::REQUEST => 'jsldInit'
    ];
  }

  /**
   * Init global service variable.
   *
   * @param \Symfony\Component\HttpKernel\Event\RequestEvent $event
   *   Response event.
   */
  public function jsldInit(RequestEvent $event) {
    $this->jsldGlobal->init();
  }

}

