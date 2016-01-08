<?php

/**
 * @file
 * Contains \Drupal\phonebook\PhoneBookPhoneStorage.
 */

namespace Drupal\phonebook;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;

/**
 * This extends the base storage class, adding required special handling for
 * phonebook phone entities.
 */
class PhoneBookPhoneStorage extends SqlContentEntityStorage {

}
