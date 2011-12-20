<?php

$config = array(
  'base_url' => empty($_ENV['BATO_ENV']) ? "http://localhost/bato" : "http://batoblog.heroku.com",
  'blog_title' => "My Blog",
  'blog_description' => "This is a brand new Bato Blog.",
  'posts_dir' => './posts',
  'max' => 150,
  'date.timezone' => 'America/Montreal', // see: http://www.php.net/manual/fr/timezones.php
);
