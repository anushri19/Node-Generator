<?php

/**
 * @file
 * Contains \Drupal\mymodule\Form\MyModuleExample.
 */

namespace Drupal\Node_Generator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\Core\Messenger\MessengerTrait;

class NodeBodyGeneratorForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'NodeGeneratorForm';
  }

  /**
   * {@inheritdoc}
   */


//creating form to store user choices to create nodes
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
    $form['title'] = array(
      '#type' => 'textfield',
      '#title' => t('Title:'),
      '#required' => TRUE,
    );
    $form['body'] = array(
      '#type' => 'textfield',
      '#title' => t('Body:'),
      '#required' => TRUE,
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Create node'),
    );

    return $form;
  }

// validation for number of nodes to be created

   public function validateForm(array &$form, FormStateInterface $form_state) {
      if ($form_state->getValue('node_count') > 5) {
        $form_state->setErrorByName('node_count', $this->t('Node count should not exceed the limit 5.'));
      }
      
    }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  $type=$form_state->getValue('content_type');
  $count=$form_state->getValue('node_count');
  $title=$form_state->getValue('title');
  $body=$form_state->getValue('body');

  //creating node
  for($i=0; $i<$count; $i++){
       $node = Node::create(array(
      'nid' => NULL,
      'type' => $type,
      'title' => $title,
      'body' =>$body,

      'uid' => i,
      'status' => TRUE,
    ));
    $node->save();
}
   $this->messenger()->addMessage('Nodes created');
  }

}

?>