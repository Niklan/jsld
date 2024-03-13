<?php declare(strict_types = 1);

namespace Drupal\jsld\Enum;

/**
 * Provides path matcher type.
 */
enum PathMatchType: string {

  case Listed = 'listed';

  case Unlisted = 'unlisted';
}
