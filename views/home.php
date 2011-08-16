<?php foreach($posts as $post):?>
  <h2><a href="<?php echo post_url($post) ?>"><?php echo $post['title'] ?></a></h2>
  <?php echo $post['content'] ?>
<?php endforeach ?>
