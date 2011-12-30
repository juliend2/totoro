<?php
include 'lib/bato.php';

$post_files = glob(POSTS_DIR."/*.*");
$current_post = array();
$posts = grab_posts($post_files);


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
  } elseif ($_GET['uri'] == '/rss') {
    include "./views/rss.php";
  } else {
    header("HTTP/1.0 404 Not Found");
  }
}

