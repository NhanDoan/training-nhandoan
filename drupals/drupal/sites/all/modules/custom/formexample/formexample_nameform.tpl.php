<?php
/**
 * Implements hook_preprocess_HOOK().
 */
function template_preprocess_formexample_nameform(&$variables) {
  $variables['formexample_nameform'] = array();
  $hidden = array();

  foreach (element_children($variables['form']) as $key ) {
    $type = $variables['form'][$key]['#type'];
    if ($type == 'hidden' || $type == 'token') {
      $hidden[] = drupal_render($variables['form'][$key]);
    } else {
      $variables['formexample_nameform'][$key] = drupal_render($variables['form'][$key]);
    }
  }
  $variables['formexample_nameform']['hidden'] = implode($hidden);

  // collect all form element to make it easier to print the whole form
  $variables['formexample_nameform_form'] = implode($variables['formexample_nameform']);

  print '<div id="formexample_nameform">';
  print $variables['formexample_nameform']['color'];
  print $variables['formexample_nameform']['name'];
  print $variables['formexample_nameform']['submit'];
  print $variables['formexample_nameform']['hidden'];
  print '</div>';
}


