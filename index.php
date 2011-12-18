<?php

include 'config.php';
include 'lib/classTextile.php';
include 'lib/php-markdown/markdown.php';

define('POSTS_DIR', $config['posts_dir']);

$posts = array();
$post_files = glob(POSTS_DIR."/*.*");
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

// takes a file's basename and return it's extension if it exists
function get_extension($basename) {
  if       (file_exists(POSTS_DIR."/$basename.textile")) {
    return 'textile';
  } elseif (file_exists(POSTS_DIR."/$basename.md")) {
    return 'md';
  } elseif (file_exists(POSTS_DIR."/$basename.markdown")) {
    return 'markdown';
  } else { // file not found
    return false;
  }
}

function get_post($year, $month, $day, $slug, $ext='textile') {
  $ext = get_extension("$year-$month-$day-$slug");
  $file = @file_get_contents(POSTS_DIR."/$year-$month-$day-$slug.$ext");
  if (!$file) return false;
  $split_post_file = explode("\n\n", $file, 2);
  if (count($split_post_file) != 2) return false;
  $post_settings = get_post_settings($split_post_file[0]);
  if (!isset($post_settings['title'])) return false;
  // set function to be called to compile in HTML:
  if ($ext == 'md' || $ext == 'markdown') { $func = 'Markdown'; }
  elseif ($ext == 'textile') { $func = $ext; }

  return array(
    'year' => $year,
    'month' => $month,
    'day' => $day,
    'slug' => $slug,
    'title' => $post_settings['title'],
    'content' => isset($func) ? $func($split_post_file[1]) : $split_post_file[1]
  );
}

// -------------------------------------------------
// Grab all the post files
//

foreach($post_files as $p) {
  if (preg_match('/^\.\/posts\/(\d{4})-(\d{2})-(\d{2})-([^\.\/]+)\.(textile|md|markdown)$/i', $p, $matches)) {
    $posts[] = get_post($matches[1],$matches[2],$matches[3],$matches[4], $matches[5]);
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
  // posts
  if (preg_match('/^\/(\d{4})\/(\d{2})\/(\d{2})\/([^\.\/]+)/i', $_GET['uri'], $matches)) {
    $post = get_post($matches[1],$matches[2],$matches[3],$matches[4]);
    if ($post) {
      $view = './views/post.php'; 
      include "./views/layout.php";
    }
    else {
      header("HTTP/1.0 404 Not Found");
    }
  } 
  else {
    header("HTTP/1.0 404 Not Found");
  }
}

