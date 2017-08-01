<?php

namespace Drupal\jsld\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class JsldSubscriber implements EventSubscriberInterface {

  /**
   * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
   */
  public function jsldInit(GetResponseEvent $event) {
    \Drupal::service('jsld.global')->init();
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = ['jsldInit'];
    return $events;
  }

}