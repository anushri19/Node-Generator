<?php

/**
 * @file
 * Contains \Drupal\node_generator\Form\NodeGeneratorForm.
 */

namespace Drupal\Node_Generator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\Core\Messenger\MessengerTrait;

class NodeGeneratorForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'NodeGeneratorForm';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    
    $form['content_type'] = array(
      '#type' => 'select',
      '#title' => t('Content Type'),
      '#required' => TRUE,
      '#options' => array(
        'article' => t('Article'),
        'page' => t('Basic Page'),
        
      ),
    );

      $form['node_count'] = array(
      '#type' => 'textfield',
      '#title' => t('Number of nodes to generate:'),
      '#required' => TRUE,
    );
    
    


    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Create node'),
    );

    return $form;
  }


//creating form to store user choices to create nodes

   public function validateForm(array &$form, FormStateInterface $form_state) {
      if ($form_state->getValue('node_count') > 10) {
        $form_state->setErrorByName('node_count', $this->t('Node count can not exceed limit 10.'));
      }
      else if ($form_state->getValue('node_count') <2) {
        $form_state->setErrorByName('node_count', $this->t('Node count can not be less than 2.'));
      }
    }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    // Code for creating a node goes here.

  $type=$form_state->getValue('content_type');
  $count=$form_state->getValue('node_count');
  for($i=0; $i<$count; $i++){
       $node = Node::create(array(
      'nid' => NULL,
      'type' => $type,
      'title' => 'test nodes',
      'uid' => i,
      'status' => TRUE,
    ));
    $node->save();
}
   $this->messenger()->addMessage('Nodes created');
  }

}

?>