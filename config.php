<?php

$config = array(
  'author_name' => 'John Doe',
  'base_url' => empty($_ENV['TOTORO_ENV']) ? "http://localhost/totoro" : "http://your-production-url.com",
  'blog_title' => "My Blog",
  'blog_description' => "This is a brand new Totoro Blog.",
  'theme' => 'default',
  'posts_dir' => './posts',
  'pages_dir' => './pages',
  'cache_dir' => './cache',
  'max' => 150,
  'posts_per_page' => 2,
  'date.timezone' => 'America/Montreal', // see: http://www.php.net/manual/fr/timezones.php
  // 'disqus_shortname' => '', // subscribe to disqus.com to get your shortname
);
