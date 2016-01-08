<?php

/**
 * @file
 * Contains \Drupal\phonebook\PhoneBookPhoneForm.
 */

namespace Drupal\phonebook;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Phonebook Phone edit forms.
 *
 * @ingroup phonebook
 */
class PhoneBookPhoneForm extends ContentEntityForm {
  
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\phonebook\Entity\PhoneBookPhone */
    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Phonebook Phone.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Phonebook Phone.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.phonebook_phone.edit_form', ['phonebook_phone' => $entity->id()]);
  }

}
