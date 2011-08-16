<?php

include 'config.php';
include 'lib/classTextile.php';

define('POSTS_DIR', './posts');

$posts = array();
$post_files = glob(POSTS_DIR."/*.textile");
$current_post = array();


// -------------------------------------------------
// Functions
//

function textile($input) {
  $textile = new Textile();
  return $textile->textileThis($input);
}

function pr($var) {
  echo '<pre>';
  print_r($var);
  echo '</pre>';
}

function post_url($post) {
  global $config;
  return "{$config['base_url']}/{$post['year']}/{$post['month']}/{$post['day']}/{$post['slug']}";
}

function get_post_settings($post_header) {
  $lines = explode("\n", $post_header);
  $settings = array();
  foreach ($lines as $line) {
    $split_line = explode(":", $line, 2);
    if (count($split_line) == 2) {
      $settings[$split_line[0]] = $split_line[1];
    }
  }
  return $settings;
}

function get_post($year, $month, $day, $slug) {
  $file = file_get_contents(POSTS_DIR."/$year-$month-$day-$slug.textile");
  $split_post_file = explode("\n\n", $file, 2);
  if (count($split_post_file) != 2) return false;
  $post_settings = get_post_settings($split_post_file[0]);
  if (!isset($post_settings['title'])) return false;
  $post = array(
    'year' => $year,
    'month' => $month,
    'day' => $day,
    'slug' => $slug,
    'title' => $post_settings['title'],
    'content' => textile($split_post_file[1]),
  );
  return $post;
}

// -------------------------------------------------
// Grab all the post files
//

foreach($post_files as $p) {
  if (preg_match('/^\.\/posts\/(\d{4})-(\d{2})-(\d{2})-([^\.\/]+)\.textile$/i', $p, $matches)) {
    $post = get_post($matches[1],$matches[2],$matches[3],$matches[4]);
    $posts[] = $post;
  }
}


// -------------------------------------------------
// Basic URL Routing
//

if (!isset($_GET['uri'])) {
  // home
  $view = './views/home.php'; 
  include "./views/layout.php";
} else {
  if (preg_match('/^\/(\d{4})\/(\d{2})\/(\d{2})\/([^\.\/]+)/i', $_GET['uri'], $matches)) {
    $post_file = get_post($matches[1],$matches[2],$matches[3],$matches[4]);
    if ($post_file) {
      $view = './views/post.php'; 
      include "./views/layout.php";
    }
    else {
      // 404 error
    }
  } 
  else {
    // 404 error
  }
}

