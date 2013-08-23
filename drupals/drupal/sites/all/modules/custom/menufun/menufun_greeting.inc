<?php
/**
 * @file
 *
 * page callback in other files
 */

function menufun_greeting( $first_name = '', $last_name = '', $from_first_name = '', $from_last_name = '') {
  return t('Hello @first_name @last_name form @from_first_name @from_last_name',
            array(
              '@first_name' => $first_name,
              '@last_name' => $last_name,
              '@from_last_name' => $from_last_name,
              '@from_first_name' => $from_first_name,
            )
          );
}

function menufun_farewell() {
  return t('Goodbye!');
}

function title_dynamic() {
  drupal_set_title('This is set table');
  $now = format_date(time());

  return t('It is now @time', array('@time' => $now));
}
