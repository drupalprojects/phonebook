<?php

/**
 * @file
 * Contains \Drupal\phonebook\Entity\PhoneBookPhone.
 */

namespace Drupal\phonebook\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\phonebook\PhoneBookPhoneInterface;

/**
 * Defines a Phonebook Phone entity class.
 *
 * @ContentEntityType(
 *   id = "phonebook_phone",
 *   label = @Translation("Phonebook Phone"),
 *   handlers = {
 *     "storage" = "Drupal\phonebook\PhoneBookPhoneStorage",
 *     "storage_schema" = "Drupal\phonebook\PhoneBookPhoneStorageSchema",
 *     "access" = "Drupal\phonebook\PhoneBookPhoneAccessControlHandler",
 *     "list_builder" = "Drupal\phonebook\PhoneBookPhoneListBuilder",
 *     "form" = {
 *       "default" = "Drupal\phonebook\PhoneBookPhoneForm",
 *       "add" = "Drupal\phonebook\PhoneBookPhoneForm",
 *       "edit" = "Drupal\phonebook\PhoneBookPhoneForm",
 *       "delete" = "Drupal\phonebook\Form\PhoneBookPhoneDeleteForm"
 *     }
 *   },
 *   base_table = "phonebook_phone",
 *   translatable = FALSE,
 *   admin_permission = "administer phonebook phone entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "phone",
 *     "status" = "status",
 *   },
 *   field_ui_base_route = "entity.phonebook_phone.collection",
 *   links = {
 *     "canonical" = "/phonebook/phone/{phonebook_phone}",
 *     "delete-form" = "/phonebook/phone/{phonebook_phone}/delete",
 *     "edit-form" = "/phonebook/phone/{phonebook_phone}/edit"
 *   }
 * )
 */
class PhoneBookPhone extends ContentEntityBase implements PhoneBookPhoneInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public function getChangedTime() {
    return $this->get('changed')->value;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the phonebook phone.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    // @todo add constraints!
    $fields['phone'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Phone number in E.164 format'))
      ->setDescription(t('The full phone number in E.164 (@url) format.', ['@url' => 'https://en.wikipedia.org/wiki/E.164']))
      ->setRequired(TRUE)
      ->setSetting('unsigned', TRUE)
      ->setSetting('size', 'big') // mysql maximum value is 18446744073709551615, see http://dev.mysql.com/doc/refman/5.5/en/integer-types.html
      ->setDisplayOptions('view', [
        'type' => 'number_integer',
      ])
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'number',
        'settings' => array(
          'size' => 15, // 15 chars maximum for phone number in E.164
        ),
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the phonebook phone was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the phonebook phone was last edited.'));

    $fields['contacted'] = BaseFieldDefinition::create('timestamp')
      ->setLabel(t('Contacted'))
      ->setDescription(t('The time that the phonebook phone was last contacted (called, smsed, etc.)'))
      ->setDefaultValue(0)
      ->setDisplayOptions('view', [
        'type' => 'timestamp',
      ])
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Phone book phone status'))
      ->setDescription(t('Whether the phonebook phone is active or blocked.'))
      ->setDefaultValue(PhoneBookPhoneInterface::STATUS_ACTIVE)
      ->setDisplayOptions('view', [
        'type' => 'boolean',
      ])
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['last_contact_status'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Last contact status'))
      ->setDescription(t('The phonebook phone last contact status.'))
      ->setSetting('max_length', 32)
      ->setDisplayOptions('view', array(
        'type' => 'string',
      ))
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'settings' => array(
          'size' => 32,
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setPropertyConstraints('value', array('Length' => array('max' => 32)));

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function isActive() {
    return $this->get('status')->value == 1;
  }

  /**
   * {@inheritdoc}
   */
  public function isInactive() {
    return $this->get('status')->value == 0;
  }

}
