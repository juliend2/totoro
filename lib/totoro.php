<?php
include 'config.php';
include 'lib/classTextile.php';
include 'lib/php-markdown/markdown.php';

define('POSTS_DIR', $config['posts_dir']);
ini_set('date.timezone', $config['date.timezone']);

// get the post's URL
function post_url($post) {
  global $config;
  return "{$config['base_url']}/{$post['year']}/{$post['month']}/{$post['day']}/{$post['slug']}";
}

// get the post's settings from it's file header
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
  } elseif (file_exists(POSTS_DIR."/$basename.html")) {
    return 'html';
  } else { // file not found
    return false;
  }
}

// get a post by it's year, month, day, slug and (optionally) file extension
function get_post($year, $month, $day, $slug, $ext='textile') {
  $ext = get_extension("$year-$month-$day-$slug");
  $file = @file_get_contents(POSTS_DIR."/$year-$month-$day-$slug.$ext");
  if (!$file) return false;
  $split_post_file = explode("\n\n", $file, 2);
  if (count($split_post_file) != 2) return false;
  $post_settings = get_post_settings($split_post_file[0]);
  if (!isset($post_settings['title'])) return false;

  return array(
    'year' => $year,
    'month' => $month,
    'day' => $day,
    'slug' => $slug,
    'title' => trim($post_settings['title']),
    'content' => get_html($split_post_file[1], $ext)
  );
}

// get html from (markdown|textile|html) string
function get_html($string, $ext) {
  // set function to be called to compile in HTML:
  if ($ext == 'md' || $ext == 'markdown') { $func = 'Markdown'; }
  elseif ($ext == 'textile') { $func = $ext; }
  return isset($func) ? $func($string) : $string;
}

// Grab all the post files
function grab_posts($post_files) {
  $posts = array();
  foreach($post_files as $p) {
    if (preg_match('/^\.\/posts\/(\d{4})-(\d{2})-(\d{2})-([^\.\/]+)\.(textile|md|markdown|html|htm)$/i', 
        $p, $matches)) {
      $posts[] = get_post($matches[1],$matches[2],$matches[3],$matches[4], $matches[5]);
    }
  }
  return array_reverse($posts);
}

// Helper functions

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

// get the excerpt of a post's content
function excerpt($content) {
  global $config;
  return truncate_html(strip_tags($content, '<p><br>'), $config['max']);
}

