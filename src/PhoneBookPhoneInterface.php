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
   * Indicates the phonebook phone status is inactive.
   */
  const STATUS_INACTIVE = FALSE;

  /**
   * Indicates the phonebook phone status is active.
   */
  const STATUS_ACTIVE = TRUE;

  /**
   * Returns TRUE if the phonebook phone is active.
   *
   * @return bool
   *   TRUE if the phonebook phone is active, FALSE otherwise.
   */
  public function isActive();

  /**
   * Returns TRUE if the phonebook phone is inactive.
   *
   * @return bool
   *   TRUE if the phonebook phone is blocked, FALSE otherwise.
   */
  public function isInactive();

}
