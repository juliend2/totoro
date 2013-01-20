<?php
include 'lib/totoro.php';

// posts variables:
$post_files = glob(POSTS_DIR."/*.*");
$current_post = array();
$posts = grab_posts($post_files);

$response = new Response(compact('posts', 'config'));

// caching variables:
$index_file = 'index:'.implode('&', hash_map($_GET, f('$k,$v','return $k."=".$v;')));
$cachename = has_uri() ? strtr($_GET['uri'], '/', ':') : $index_file;
$cachefilename = $config['cache_dir'] .'/'. $cachename . ".html";

// display cache if the file exists:
// TODO: automatically expire the cache after a certain time
if (file_exists($cachefilename) && !empty($_ENV['TOTORO_ENV']) && $_ENV['TOTORO_ENV'] == 'production') { 
  echo @file_get_contents($cachefilename);
  exit;
}

ob_start(); // START output buffer (for caching) 

$section_name = 'blog';

// Basic URL Routing:
if (!has_uri()) {
  // home
  $response->set_view(theme_file("home.php"))->send();
} else {
  // posts
  if (preg_match('/^\/(\d{4})\/(\d{2})\/(\d{2})\/([^\.\/]+)/i', $_GET['uri'], $matches)) {
    $post = new Post($matches[1],$matches[2],$matches[3],$matches[4]);
    if ($post) {
      $response->add_vars(compact('post'))
        ->set_view(theme_file('post.php'))
        ->send();
    } else {
      $response->set_status(404)->send();
    }
  // pages
  } elseif (preg_match('/^\/([^\.\/]+)/i', $_GET['uri'], $matches) && 
            (file_exists('pages/'.$matches[1].'.md') || file_exists('pages/'.$matches[1].'.html')) ) {
    $section_name = $matches[1];
    $ext = Post::get_extension($matches[1], true);
    $page_file = 'pages/'.$matches[1].'.'.$ext;
    if (file_exists($page_file)) {
      $page_code = @file_get_contents($page_file);
      $page_content = Post::get_html($page_code, $ext);
      $page_title = get_page_title($page_code, $ext);
      $response->add_vars(compact('page_content', 'page_title'))
        ->set_view(theme_file('page.php'))
        ->send();
    } else {
      $response->set_status(404)->send();
    }
  // rss
  } elseif ($_GET['uri'] == '/rss') {
    $response->set_content_type('application/rss+xml')
       ->set_view(theme_file("rss.php"))
       ->send();
  } else {
    $response->set_status(404)->send();
  }
}

// save output buffer to cache:
$fp = fopen($cachefilename, 'w'); 
fwrite($fp, ob_get_contents());
fclose($fp);
ob_end_flush(); // END output buffer


