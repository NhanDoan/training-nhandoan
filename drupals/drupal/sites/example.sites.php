<?php

/**
 * @file
 * Configuration file for Drupal's multi-site directory aliasing feature.
 *
 * This file allows you to define a set of aliases that map hostnames, ports, and
 * pathnames to configuration directories in the sites directory. These aliases
 * are loaded prior to scanning for directories, and they are exempt from the
 * normal discovery rules. See default.settings.php to view how Drupal discovers
 * the configuration directory when no alias is found.
 *
 * Aliases are useful on development servers, where the domain name may not be
 * the same as the domain of the live server. Since Drupal stores file paths in
 * the database (files, system table, etc.) this will ensure the paths are
 * correct when the site is deployed to a live server.
 *
 * To use this file, copy and rename it such that its path plus filename is
 * 'sites/sites.php'. If you don't need to use multi-site directory aliasing,
 * then you can safely ignore this file, and Drupal will ignore it too.
 *
 * Aliases are defined in an associative array named $sites. The array is
 * written in the format: '<port>.<domain>.<path>' => 'directory'. As an
 * example, to map http://www.drupal.org:8080/mysite/test to the configuration
 * directory sites/example.com, the array should be defined as:
 * @code
 * $sites = array(
 *   '8080.www.drupal.org.mysite.test' => 'example.com',
 * );
 * @endcode
 * The URL, http://www.drupal.org:8080/mysite/test/, could be a symbolic link or
 * an Apache Alias directive that points to the Drupal root containing
 * index.php. An alias could also be created for a subdomain. See the
 * @link http://drupal.org/documentation/install online Drupal installation guide @endlink
 * for more information on setting up domains, subdomains, and subdirectories.
 *
 * The following examples look for a site configuration in sites/example.com:
 * @code
 * URL: http://dev.drupal.org
 * $sites['dev.drupal.org'] = 'example.com';
 *
 * URL: http://localhost/example
 * $sites['localhost.example'] = 'example.com';
 *
 * URL: http://localhost:8080/example
 * $sites['8080.localhost.example'] = 'example.com';
 *
 * URL: http://www.drupal.org:8080/mysite/test/
 * $sites['8080.www.drupal.org.mysite.test'] = 'example.com';
 * @endcode
 *
 * @see default.settings.php
 * @see conf_path()
 * @see http://drupal.org/documentation/install/multi-site
 */

define('DRUPAL_ROOT', $_SERVER['DOCUMENT_ROOT']."/training-nhandoan/drupals/drupal");

require_once(DRUPAL_ROOT."/includes/bootstrap.inc");

drupal_bootstrap(DRUPAL_BOOTSTRAP_SESSION);


// $result = db_query('SELECT title FROM {node}');

// $num_updated = db_update('joke')
// ->fields(array(
// 'punchline' => 'Take my wife please!',
// ))
// ->condition('nid', 3, '>=')
// ->execute();

// $result = db_query("SELECT name FROM {role} WHERE rid > :rid AND rid < :max_rid", array(':rid' => 0,':max_rid' => 3));
// var_dump($result); exit;
// foreach ($result as $name) {

//   // echo " Example get name form table role $name </br>";
// }
$type = 'page';
$status = 1;
$result = db_query("SELECT nid, title FROM {node} WHERE type = :type AND status = :status",
array(
':type' => $type, ':status' => 1,
));
foreach ($result as $row) {
echo $row->title."<br/>";
}


$query = db_select('node', 'n')->extend('PagerDefault');
$query->condition('type', 'page')
      ->fields('n', array('title'))
      ->limit(2);
$result = $query->execute();
$output = '';
foreach ($result as $row) {
 echo $output .= $row->title."<br/>";
}

