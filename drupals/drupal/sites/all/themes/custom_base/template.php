<?php
// Footheme by Adaptivethemes.com, a starter sub-sub-theme.

/**
 * Rename each function and instance of "footheme" to match
 * your subthemes name, e.g. if you name your theme "footheme" then the function
 * name will be "footheme_preprocess_hook". Tip - you can search/replace
 * on "footheme".
 */

/**
 * Override or insert variables into the html templates.
 * Replace 'footheme' with your themes name, i.e. mytheme_preprocess_html()
 */
function custom_base_preprocess_html(&$vars) {

  // Load the media queries styles
  // If you change the names of these files they must match here - these files are
  // in the /css/ directory of your subtheme - the names must be identical!
  $media_queries_css = array(
    'custom_base.responsive.style.css',
    'custom_base.responsive.gpanels.css'
  );
  // load_subtheme_media_queries($media_queries_css, 'footheme'); // Replace 'footheme' with your themes name

 /**
  * Load IE specific stylesheets
  * AT automates adding IE stylesheets, simply add to the array using
  * the conditional comment as the key and the stylesheet name as the value.
  *
  * See our online help: http://adaptivethemes.com/documentation/working-with-internet-explorer
  *
  * For example to add a stylesheet for IE8 only use:
  *
  *  'IE 8' => 'ie-8.css',
  *
  * Your IE CSS file must be in the /css/ directory in your subtheme.
  */
  /* -- Delete this line to add a conditional stylesheet for IE 7 or less.
  $ie_files = array(
    'lte IE 7' => 'ie-lte-7.css',
  );
  load_subtheme_ie_styles($ie_files, 'footheme'); // Replace 'footheme' with your themes name
  // */

}


function custom_base_preprocess_panels_pane(&$vars) {
    if ($vars['pane']->type === 'node_author') {
        $node =& $vars['display']->context[$vars['pane']->configuration['context']]->data;
        $author = user_load($node->uid);
        $render['link'] = array(
            '#type' => 'link',
            '#title' => $author->name,
            '#href' => privatemsg_get_link($author, NULL, sprintf('Question about %s', $node->title)),
        );

        $vars['title_attributes_array']['class'][] = 'inline';
        $vars['title_attributes_array']['style'][] = 'padding-right: 20px;';
        $vars['content'] = drupal_render($render);
    }
}


