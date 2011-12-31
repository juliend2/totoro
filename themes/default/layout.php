<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title><?php echo $config['blog_title'] ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo theme_url() ?>/css/reset.css"/>
  <link rel="stylesheet/less" type="text/css" href="<?php echo theme_url() ?>/css/styles.less"/>
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
<?php echo $config['author_name'] ?>. [<a href="<?php echo $config['base_url'] ?>/rss">rss</a>]
</footer>

</body>
</html>

