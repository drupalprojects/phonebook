<?php

/**
 * @file
 * Contains \Drupal\phonebook\PhoneBookPhoneStorageSchema.
 */

namespace Drupal\phonebook;

use Drupal\Core\Entity\ContentEntityTypeInterface;
use Drupal\Core\Entity\Sql\SqlContentEntityStorageSchema;

/**
 * Defines the phonebook phone schema handler.
 */
class PhoneBookPhoneStorageSchema extends SqlContentEntityStorageSchema {

  /**
   * {@inheritdoc}
   */
  protected function getEntitySchema(ContentEntityTypeInterface $entity_type, $reset = FALSE) {
    $schema = parent::getEntitySchema($entity_type, $reset);

    // @todo add extrafield table generator here.

    return $schema;
  }

}
