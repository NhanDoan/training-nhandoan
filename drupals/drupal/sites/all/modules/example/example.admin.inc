<?php
/**
 *  @file
 *
 *  Administration page callback for the example module
 */

/**
 * Form builder
 *
 */

/**
 * Implements hook_form().
 */


function example_admin_settings() {

  $types = node_type_get_types();

  foreach ($types as $note_type) {

    $option[$note_type->type] = $note_type->name;
  }

  $form['example_node_types'] = array(
    '#type' => 'checkboxes',
    '#title' => t('Users maybe annotate these content types'),
    '#options' => $option,
    '#default_value' => variable_get('example_node_types', array('page')),
    '#description' => t('A text field will be available on these content types to make user-specific note.')
  );

  $form['example_deletion'] = array(
    '#type' => 'radios',
    '#title' => t('Annotation will be deteted'),
    '#description' => t('Select a method for deteting annotations'),
    '#options' => array(
      t('Never'),
      t('Randomly'),
      t('After 30 days')
    ),
    '#default_value' => variable_get('example_deletion', 0)
  );

  $form['example_limit_per_node'] = array(
    '#type' => 'textfield',
    '#title' => t('Annotation per node'),
    '#description' => t('Enter the maximum number of annotation allowed per node ( 0 for no limit)'),
    '#default_value' => variable_get('example_limit_per_node', 1),
    '#size' => 3
  );

  $form['#submit'][] = 'example_admin_settings_submit';

  return system_settings_form($form);
}

/**
 * Implements hook_node_submit().
 */
function example_admin_settings_submit($form, $form_state) {
  // Decompose the selected menu parent option into 'menu_name' and 'plid', if
  // the form used the default parent selection widget.
  /*
   *if (!empty($form_state['values']['menu']['parent'])) {
   *  list($node->menu['menu_name'], $node->menu['plid']) = explode(':', $form_state['values']['menu']['parent']);
   *}
   */

  foreach ($form_state['values']['example_node_types'] as $key => $value) {

    if (!$value) {
        $instance = field_info_instance('node', 'annotation', $key);
      if (!empty($instance)) {

        field_delete_instance($instance);
        watchdog('Example', 'Delete annotation field from content type:%key', array('$key'=>$key));
      }

    } else {

        $instance = field_info_instance('node', 'annotation', $key);

        if (empty($instance)) {

          $instance = array(
            'field_name' => 'annotation',
            'entity_type' => 'node',
            'bundle' => $key,
            'label' => t('Annotation'),
            'widget_type' => 'text_textarea_with_summary',
            'settings' => array('display_summary' => TRUE),
            'display' => array(
              'default' => array(
                'type' => 'text_default'
              ),
              'teaser' => array(
                'type' =>'text_summary_or_trimed'
              ),
            ),
          );

          $instance = field_create_instance($instance);
          watchdog('example', 'Add annotation field to content type: %key', array('%key' => $key));
        }
    }
  } // End foreach loop
}

/**
 * Implements hook_validate().
 */
function example_admin_settings_validate($form, &$form_state) {
  /*
   *if (isset($node->end) && isset($node->start)) {
   *  if ($node->start > $node->end) {
   *    form_set_error('time', t('An event may not end before it starts.'));
   *  }
   *}
   */
  /* Your code here */

  $limit = $form_state['values']['example_limit_per_node'];
  if(!is_numeric($limit))
  {
    form_set_error('example_limit_per_node', t('Please enter numbel'));
  }
}
