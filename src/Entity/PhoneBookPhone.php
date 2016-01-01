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
 * Defines a Phone Book Phone entity class.
 *
 * @ContentEntityType(
 *   id = "phonebook_phone",
 *   label = @Translation("Phone Book Phone"),
 *   handlers = {
 *     "storage" = "Drupal\phonebook\PhoneBookPhoneStorage",
 *     "list_builder" = "Drupal\phonebook\PhoneBookPhoneListBuilder",
 *     "views_data" = "Drupal\phonebook\PhoneBookPhoneViewsData",
 *     "form" = {
 *       "default" = "Drupal\phonebook\PhoneBookPhoneForm",
 *       "add" = "Drupal\phonebook\PhoneBookPhoneForm",
 *       "edit" = "Drupal\phonebook\PhoneBookPhoneForm",
 *       "delete" = "Drupal\phonebook\Form\PhoneBookPhoneDeleteForm"
 *     }
 *   },
 *   base_table = "phonebook_phone",
 *   translatable = FALSE,
 *   admin_permission = "administer phone book phone",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "label" = "phone",
 *     "langcode" = "langcode",
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
      ->setDescription(t('The ID of the phone book phone.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the phone book phone.'))
      ->setReadOnly(TRUE);

    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language'))
      ->setDescription(t('The language code of the phone book phone.'))
      ->setDisplayOptions('view', array(
        'type' => 'hidden',
      ))
      ->setDisplayOptions('form', array(
        'type' => 'language_select',
        'weight' => 2,
      ));

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the phone book phone was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the phone book phone was last edited.'));

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
      ->setDescription(t('The phone book phone source.'))
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
      ->setDescription(t('The phone book phone delta in this source.'))
      ->setRequired(TRUE)
      ->setDefaultValue(0);

    $fields['type'] = BaseFieldDefinition::create('list_integer')
      ->setLabel(t('Contact type'))
      ->setDescription(t('The phone book phone type.'))
      ->setRequired(TRUE)
      ->setDefaultValue(self::TYPE_UNDEFINED)
      ->setSetting('allowed_values', static::getPhoneBookPhoneTypes())
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
      ->setLabel(t('Phone book phone status'))
      ->setDescription(t('Whether the phone book phone is active or blocked.'))
      ->setDefaultValue(FALSE);


    // @todo: add fields: address, person, city, street, house, comment, rawdata
    // @todo: add fields; fias_city_guid, fias_street_guid, fias_house_guid

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public static function getTypes() {
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
  public function isInactive() {
    return $this->get('status')->value == 0;
  }

}
