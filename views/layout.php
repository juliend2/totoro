<html>
<head>
  <title><?php echo $config['blog_title'] ?></title>
  <link href="styles.css" type="text/stylesheet" />
</head>
<body>

<header>
  <h1><?php echo $config['blog_title'] ?></h1>
  <p class="description"><?php echo $config['blog_description'] ?></p>
</header>

<section class="main">
  <?php include $view ?>
</section>

<section class="sidebar">
</section>

<footer>
</footer>

</body>
</html>

