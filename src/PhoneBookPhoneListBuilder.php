<?php

/**
 * @file
 * Contains \Drupal\phonebook\PhoneBookPhoneListBuilder.
 */

namespace Drupal\phonebook;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Phonebook Phone entities.
 *
 * @ingroup phonebook
 */
class PhoneBookPhoneListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Phonebook Phone ID');
    $header['phone'] = $this->t('Phone');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\phonebook\Entity\PhoneBookPhone */
    $row['id'] = $entity->id();
    $row['phone'] = Link::createFromRoute(
      $entity->label(),
      'entity.phonebook_phone.edit_form',
      ['phonebook_phone' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
