<?php

declare(strict_types=1);

namespace Drupal\jsld\Enum;

/**
 * Provides path matcher type.
 */
enum PathMatchType: string {

  /* Match passed paths. */
  case Listed = 'listed';

  /* Shows only if path not in match path. */
  case Unlisted = 'unlisted';

}
