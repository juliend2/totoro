<?php
$page_posts = array_chunk($posts, $config['posts_per_page']);
$index = isset($_GET['page']) ? $_GET['page'] : 1;
?>

<?php foreach($page_posts[$index-1] as $post):?>
  <h2><a href="<?php echo post_url($post) ?>"><?php echo $post['title'] ?></a></h2>
  <h3 class="date"><?php echo strftime('%B %e, %Y', strtotime($post['year'].'-'.$post['month'].'-'.$post['day'])) ?></h3>
  <?php echo excerpt($post['content']) ?> 
<?php endforeach ?>

<?php if (count($page_posts) > 0): ?>
<ul>
  <?php for ($i=0; $i<count($page_posts); $i++): ?>
    <li <?php echo $index==$i+1?'class="current"':''; ?>><a href="?page=<?php echo $i+1 ?>"><?php echo $i+1 ?></a></li>
  <?php endfor ?>
</ul>
<?php endif ?>


