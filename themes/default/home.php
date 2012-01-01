<?php foreach($posts as $post):?>
  <h2><a href="<?php echo post_url($post) ?>"><?php echo $post['title'] ?></a></h2>
  <h3 class="date"><?php echo strftime('%B %e, %Y', strtotime($post['year'].'-'.$post['month'].'-'.$post['day'])) ?></h3>
  <?php echo excerpt($post['content']) ?> 
<?php endforeach ?>
