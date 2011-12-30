<?php
include 'lib/bato.php';

$post_files = glob(POSTS_DIR."/*.*");
$current_post = array();
$posts = grab_posts($post_files);


// -------------------------------------------------
// Basic URL Routing
//


ob_start(); // START output buffer (for caching) 

if (!isset($_GET['uri'])) {
  $cachefile = "index";
  // home
  $view = './views/home.php'; 
  include "./views/layout.php";
} else {
  $cachefile = strtr($_GET['uri'], '/', ':');
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
  } elseif ($_GET['uri'] == '/rss') {
    include "./views/rss.php";
  } else {
    header("HTTP/1.0 404 Not Found");
  }
}
// save output buffer to cache:
$cachefile = "cache/{$cachefile}.html";
$fp = fopen($cachefile, 'w'); 
fwrite($fp, ob_get_contents());
fclose($fp);
ob_end_flush(); 
// END output buffer
