<?php

/**
 * @file
 * Contains \Drupal\phonebook\PhoneBookPhoneInterface.
 */

namespace Drupal\phonebook;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;

interface PhoneBookPhoneInterface extends ContentEntityInterface, EntityChangedInterface {

  /**
   * Indicates the phone book phone status is inactive.
   */
  const STATUS_INACTIVE = 0;

  /**
   * Indicates the phone book phone status is active.
   */
  const STATUS_ACTIVE = 1;

  /**
   * Returns TRUE if the phone book phone is active.
   *
   * @return bool
   *   TRUE if the phone book phone is active, FALSE otherwise.
   */
  public function isActive();

  /**
   * Returns TRUE if the phone book phone is inactive.
   *
   * @return bool
   *   TRUE if the phone book phone is blocked, FALSE otherwise.
   */
  public function isInactive();

}
