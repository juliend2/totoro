<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title><?php echo $config['blog_title'] ?></title>
  <base href="<?php echo $config['base_url'] ?>/" />
  <meta name="description" content="<?php echo $config['blog_description'] ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo theme_url() ?>/css/reset.css"/>
  <link rel="stylesheet/less" type="text/css" href="<?php echo theme_url() ?>/css/styles.less"/>
  <link rel="alternate" type="application/rss+xml" title="<?php echo $config['blog_title'] ?>" href="<?php echo $config['base_url'] ?>/rss" />
  <script src="<?php echo theme_url() ?>/js/less-1.1.5.min.js" type="text/javascript"></script>
</head>
<body>

<header>
  <h1><a href="<?php echo $config['base_url'] ?>"><?php echo $config['blog_title'] ?></a></h1>
  <p class="description"><?php echo $config['blog_description'] ?></p>
</header>

<section class="main">
  <?php include $view ?>
</section>

<footer>
  &copy; <?php echo date('Y') ?> <?php echo $config['author_name'] ?>. <br/>Powered by <a href="https://github.com/juliend2/bato">Bato</a>.
</footer>

</body>
</html>

