<?php

/**
 * @file
 * Contains \Drupal\phonebook\PhoneBookPhoneAccessControlHandler.
 */

namespace Drupal\phonebook;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Phonebook Phone entity.
 *
 * @see \Drupal\phonebook\Entity\PhoneBookPhone.
 */
class PhoneBookPhoneAccessControlHandler extends EntityAccessControlHandler {
  /**
   * {@inheritdoc}
   */
  protected function checkAccess(PhoneBookPhoneInterface $entity, $operation, AccountInterface $account) {
    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view phonebook phone entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit phonebook phone entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete phonebook phone entities');
    }

    return AccessResult::allowed();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add phonebook phone entities');
  }

}
