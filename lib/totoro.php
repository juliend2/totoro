<?php
include 'config.php';
define('POSTS_DIR', $config['posts_dir']);
define('PAGES_DIR', $config['pages_dir']);
ini_set('date.timezone', $config['date.timezone']);

include 'lib/classTextile.php';
include 'lib/php-markdown/markdown.php';
include 'lib/response.class.php';
include 'lib/post.class.php';

function get_page_title($page_code, $ext='md') {
  if ($ext == 'md' || $ext == 'markdown') {
    preg_match('|^(.*)\n={3,}|m', $page_code, $matches);
  } elseif ($ext == 'html') {
    preg_match('|^<h1>(.*)</h1>|mi', $page_code, $matches);
  }
  return isset($matches[1]) ? trim($matches[1]) : false;
}

// Grab all the post files
function grab_posts($post_files) {
  $posts = array();
  foreach($post_files as $p) {
    if (preg_match('/^\.\/posts\/(\d{4})-(\d{2})-(\d{2})-([^\.\/]+)\.(textile|md|markdown|html|htm)$/i', 
        $p, $matches)) {
      $posts[] = new Post($matches[1],$matches[2],$matches[3],$matches[4], $matches[5]);
    }
  }
  return array_reverse($posts);
}

// Helper functions

function the_title() {
  echo get_the_title();
}

function get_the_title() {
  global $post, $config, $page_title;
  $glue = ' | ';
  $title_elements = array( $config['blog_title'] );
  if (isset($post)) array_unshift($title_elements, $post->title);
  if (isset($page_title)) array_unshift($title_elements, $page_title);
  return implode($glue, $title_elements);
}

// do we have an uri? return false if we're at the root of the domain
function has_uri() {
  return isset($_GET['uri']);
}

// textile formatting. takes a string of textile
function textile($input) {
  $textile = new Textile();
  return $textile->textileThis($input);
}

// debugging helper
function pr($var) {
  echo '<pre>';
  print_r($var);
  echo '</pre>';
}

// get a theme file path. takes a file basename string
function theme_file($file) {
  global $config;
  return "./themes/{$config['theme']}/{$file}";
}

// get the current theme's url
function theme_url() {
  global $config;
  return $config['base_url'] . '/themes/' . $config['theme'];
}

// truncate html string, by closing the tags properly where needed
// taken from: http://snippets.dzone.com/posts/show/7125
function truncate_html($text, $length, $suffix = '&hellip;', $isHTML = true){
  $i = 0;
  $simpleTags=array('br'=>true,'hr'=>true,'input'=>true,'image'=>true,'link'=>true,'meta'=>true);
  $tags = array();
  if($isHTML){
    preg_match_all('/<[^>]+>([^<]*)/', $text, $m, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
    foreach($m as $o){
      if($o[0][1] - $i >= $length)
        break;
      $t = substr(strtok($o[0][0], " \t\n\r\0\x0B>"), 1);
      // test if the tag is unpaired, then we mustn't save them
      if($t[0] != '/' && (!isset($simpleTags[$t])))
        $tags[] = $t;
      elseif(end($tags) == substr($t, 1))
        array_pop($tags);
      $i += $o[1][1] - $o[0][1];
    }
  }
  
  // output without closing tags
  $output = substr($text, 0, $length = min(strlen($text),  $length + $i));
  // closing tags
  $output2 = (count($tags = array_reverse($tags)) ? '</' . implode('></', $tags) . '>' : '');
  
  // Find last space or HTML tag (solving problem with last space in HTML tag eg. <span class="new">)
  $pos = (int)end(end(preg_split('/<.*>| /', $output, -1, PREG_SPLIT_OFFSET_CAPTURE)));
  // Append closing tags to output
  $output.=$output2;

  // Get everything until last space
  $one = substr($output, 0, $pos);
  // Get the rest
  $two = substr($output, $pos, (strlen($output) - $pos));
  // Extract all tags from the last bit
  preg_match_all('/<(.*?)>/s', $two, $tags);
  // Add suffix if needed
  if (strlen($text) > $length) { $one .= $suffix; }
  // Re-attach tags
  $output = $one . implode($tags[0]);
  
  return $output;
}

// shortcut for create_function()
function f($args_string, $func_string) {
  return create_function($args_string, $func_string);
}

// like array_map(), but you can pass an associative array and have 2 arguments in your callback
// ex: hash_map($associative_array, f('$key, $value', 'return $key."=".$value;'));
function hash_map($array, $callback) {
  $keys = array_keys($array);
  $values = array_values($array);
  return array_map($callback, $keys, $values);
}

