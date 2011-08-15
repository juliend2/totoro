<?php

include 'config.php';
include 'lib/classTextile.php';

define('POSTS_DIR', './posts');

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

function get_post($year, $month, $day, $slug) {
  return file_get_contents(POSTS_DIR."/$year-$month-$day-$slug.textile");
}

// -------------------------------------------------
// Grab all the post files
//

$posts = array();
$post_files = glob(POSTS_DIR."/*.textile");
$current_post = array();

foreach($post_files as $p) {
  if (preg_match('/^\.\/posts\/(\d{4})-(\d{2})-(\d{2})-([^\.\/]+)\.textile$/i', $p, $matches)) {
    $post = array(
      'year' => $matches[1],
      'month' => $matches[2],
      'day' => $matches[3],
      'slug' => $matches[4],
      'filename' => $matches[0],
    );
    $posts[] = $post;
  }
}


// -------------------------------------------------
// Basic URL Routing
//

if (!isset($_GET['uri'])) {
  // index
  $view = './views/home.php'; 
  include "./views/layout.php";
} else {
  if (preg_match('/^\/(\d{4})\/(\d{2})\/(\d{2})\/([^\.\/]+)/i', $_GET['uri'], $matches)) {
    $post_content = get_post($matches[1],$matches[2],$matches[3],$matches[4]);
    if ($post_content) {
      $post = array(
        'year' => $matches[1],
        'month' => $matches[2],
        'day' => $matches[3],
        'slug' => $matches[4],
        'content' => $post_content,
      );
      // render the post
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

