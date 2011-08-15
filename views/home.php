<?php foreach($posts as $post):?>
  <h2><?php echo $post['title'] ?></h2>
  <?php echo textile($post['content']) ?>
<?php endforeach ?>
