<?php

$plugin = array(
    'single' => TRUE,
    'title' => t('Eric Test'),
    'description' => t('Testing abcd'),
    'required context' => new ctools_context_required(t('Form'), 'node_form'),
    'category' => t('Form'),
);

function guest_post_access_eric_test_content_type_render($subtype, $conf, $panel_args, &$context) {
    $block = new stdClass();
    $block->module = t('guest_post_access');
    if (isset($context->form)) {
        $block->content = t('ABCDEFG');
        //$block->content['eric test']  = $context->form['eric test'];
    } else {
        $block->content = t('Something broke.');
    }

    return $block;
}

function guest_post_access_eric_test_content_type_edit_form($form, &$form_state) {
    return $form;
}

        
