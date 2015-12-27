<?php

/**
 * @file
 * Contains \Drupal\phonebook\Entity\PhoneBookContact.
 */

namespace Drupal\phonebook\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\phonebook\PhoneBookContactInterface;

/**
 * Defines a Phone Book Contact entity class.
 *
 * @ContentEntityType(
 *   id = "phonebook_contact",
 *   label = @Translation("Phone Book Contact"),
 *   handlers = {
 *     "storage" = "Drupal\phonebook\PhoneBookContactStorage",
 *     "list_builder" = "Drupal\phonebook\PhoneBookContactListBuilder",
 *     "views_data" = "Drupal\phonebook\PhoneBookContactViewsData",
 *     "form" = {
 *       "default" = "Drupal\phonebook\PhoneBookContactForm",
 *       "add" = "Drupal\phonebook\PhoneBookContactForm",
 *       "edit" = "Drupal\phonebook\PhoneBookContactForm",
 *       "delete" = "Drupal\phonebook\Form\PhoneBookContactDeleteForm"
 *     }
 *   },
 *   base_table = "phonebook_contact",
 *   translatable = FALSE,
 *   admin_permission = "administer phone book contact",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "label" = "phone",
 *     "langcode" = "langcode",
 *   },
 *   field_ui_base_route = "entity.phonebook_contact.collection",
 *   links = {
 *     "canonical" = "/phonebook/contact/{phonebook_contact}",
 *     "delete-form" = "/phonebook/contact/{phonebook_contact}/delete",
 *     "edit-form" = "/phonebook/contact/{phonebook_contact}/edit"
 *   }
 * )
 */
class PhoneBookContact extends ContentEntityBase implements PhoneBookContactInterface {

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
      ->setDescription(t('The ID of the phone book contact.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the phone book contact.'))
      ->setReadOnly(TRUE);

    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language'))
      ->setDescription(t('The language code of the phone book contact.'))
      ->setDisplayOptions('view', array(
        'type' => 'hidden',
      ))
      ->setDisplayOptions('form', array(
        'type' => 'language_select',
        'weight' => 2,
      ));

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the phone book contact was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the phone book contact was last edited.'));

    $fields['phone'] = BaseFieldDefinition::create('telephone')
      ->setLabel(t('Phone number'))
      ->setDescription(t('The full phone number.'))
      ->setRequired(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'string',
        'weight' => 1,
      ))
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayOptions('form', array(
        'type' => 'telephone_default',
        'weight' => 1,
        'settings' => array(
          'size' => 40,
        ),
      ))
      ->setDisplayConfigurable('form', TRUE);

    // @todo fix this with valid form and display options!
    $fields['phone_e164'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Phone number in E.164 format'))
      ->setDescription(t('The full phone number in E.164 (@url) format.', ['@url' => 'https://en.wikipedia.org/wiki/E.164']))
      ->setRequired(TRUE);

    $fields['source'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Source'))
      ->setDescription(t('The phone book contact source.'))
      ->setRequired(FALSE)
      ->setSetting('max_length', 32)
      ->setDisplayOptions('view', array(
        'label' => 'inline',
        'type' => 'string',
        'weight' => 1,
      ))
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => 1,
        'settings' => array(
          'size' => 32,
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setPropertyConstraints('value', array('Length' => array('max' => 32)));

    // @todo fix this with valid form and display options!
    $fields['delta'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Delta'))
      ->setDescription(t('The phone book contact delta in this source.'))
      ->setRequired(TRUE)
      ->setDefaultValue(0);

    $fields['type'] = BaseFieldDefinition::create('list_integer')
      ->setLabel(t('Contact type'))
      ->setDescription(t('The phone book contact type.'))
      ->setRequired(TRUE)
      ->setDefaultValue(self::TYPE_UNDEFINED)
      ->setSetting('allowed_values', static::getPhoneBookContactTypes())
      ->setDisplayOptions('view', array(
        'label' => 'inline',
        'type' => 'list_default',
        'weight' => 5,
      ))
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayOptions('form', array(
        'type' => 'options_select',
        'weight' => 5,
      ))
      ->setDisplayConfigurable('form', TRUE);

    // @todo fix this with valid form and display options!
    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Phone book contact status'))
      ->setDescription(t('Whether the phone book contact is active or blocked.'))
      ->setDefaultValue(FALSE);


    // @todo: add fields: address, person, city, street, house, comment, rawdata
    // @todo: add fields; fias_city_guid, fias_street_guid, fias_house_guid

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public static function getPhoneBookContactTypes() {
    return [
      static::TYPE_UNDEFINED => t('Undefined'),
      static::TYPE_INDIVIDUAL => t('Individual'),
      static::TYPE_LEGAL_ENTITY => t('Legal entity'),
    ];
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
  public function isBlocked() {
    return $this->get('status')->value == 0;
  }

}
