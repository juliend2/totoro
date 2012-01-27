<?php
include 'lib/totoro.php';

// posts variables:
$post_files = glob(POSTS_DIR."/*.*");
$current_post = array();
$posts = grab_posts($post_files);

// caching variables:
$index_file = 'index:'.implode('&', hash_map($_GET, f('$k,$v','return $k."=".$v;')));
$cachename = has_uri() ? strtr($_GET['uri'], '/', ':') : $index_file;
$cachefilename = $config['cache_dir'] .'/'. $cachename . ".html";

// display cache if the file exists:
// TODO: automatically expire the cache after a certain time
if (file_exists($cachefilename) && !empty($_ENV['TOTORO_ENV']) && $_ENV['TOTORO_ENV'] == 'production') { 
  include $cachefilename;
  exit;
}

ob_start(); // START output buffer (for caching) 

$section_name = 'blog';

// Basic URL Routing:
if (!has_uri()) {
  // home
  $view = theme_file("home.php"); 
  include theme_file("layout.php");
} else {
  // posts
  if (preg_match('/^\/(\d{4})\/(\d{2})\/(\d{2})\/([^\.\/]+)/i', $_GET['uri'], $matches)) {
    $post = get_post($matches[1],$matches[2],$matches[3],$matches[4]);
    if ($post) {
      $view = theme_file("post.php"); 
      include theme_file("layout.php");
    }
    else {
      header("HTTP/1.0 404 Not Found");
    }
  // pages
  } elseif (preg_match('/^\/([^\.\/]+)/i', $_GET['uri'], $matches) && file_exists('pages/'.$matches[1].'.md')) {
    $section_name = $matches[1];
    $page_file = 'pages/'.$matches[1].'.md';
    if (file_exists($page_file)) {
      $page_content = get_html(@file_get_contents($page_file), 'md');
      $view = "./themes/{$config['theme']}/page.php";
      include "./themes/{$config['theme']}/layout.php";
    } else {
      header("HTTP/1.0 404 Not Found");
    }
  // rss
  } elseif ($_GET['uri'] == '/rss') {
    header("Content-Type: application/rss+xml; charset=utf-8");
    include theme_file("rss.php");
  } else {
    header("HTTP/1.0 404 Not Found");
  }
}

// save output buffer to cache:
$fp = fopen($cachefilename, 'w'); 
fwrite($fp, ob_get_contents());
fclose($fp);
ob_end_flush(); // END output buffer


