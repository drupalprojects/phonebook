<?php

/**
 * @file
 * Contains \Drupal\phonebook\PhoneBookContactInterface.
 */

namespace Drupal\phonebook;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;

interface PhoneBookContactInterface extends ContentEntityInterface, EntityChangedInterface {

  /**
   * Indicates the phone book contact type is undefined.
   */
  const TYPE_UNDEFINED = 0;

  /**
   * Indicates the phone book contact type is individual.
   */
  const TYPE_INDIVIDUAL = 1;

  /**
   * Indicates the phone book contact type is legal entity.
   */
  const TYPE_LEGAL_ENTITY = 2;

  /**
   * Return array of phone book contact possible types.
   *
   * @return array
   *   An array of phone book contact types.
   */
  public static function getPhoneBookContactTypes();

  /**
   * Returns TRUE if the phone book contact is active.
   *
   * @return bool
   *   TRUE if the phone book contact is active, false otherwise.
   */
  public function isActive();

  /**
   * Returns TRUE if the phone book contact is blocked.
   *
   * @return bool
   *   TRUE if the phone book contact is blocked, false otherwise.
   */
  public function isBlocked();

}
