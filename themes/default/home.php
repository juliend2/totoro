<?php
$page_posts = array_chunk($posts, $config['posts_per_page']);
$index = isset($_GET['page']) ? $_GET['page'] : 1;
?>

<?php foreach($page_posts[$index-1] as $post):?>
  <h2><a href="<?php echo post_url($post) ?>"><?php echo $post['title'] ?></a></h2>
  <h3 class="date"><?php echo strftime('%B %e, %Y', strtotime($post['year'].'-'.$post['month'].'-'.$post['day'])) ?></h3>
  <?php echo excerpt($post['content']) ?> 
<?php endforeach ?>

</section>

<!-- Pagination: -->
<?php if (count($page_posts) > 1): ?>
<ul class="pagination">
  <?php for ($i=1; $i-1<count($page_posts); $i++): ?>
    <li <?php echo $index==$i?'class="current"':''; ?>>
      <?php if ($index==$i): ?>
        <span><?php echo $i ?></span>
      <?php else: ?>
        <a href="?page=<?php echo $i ?>"><?php echo $i ?></a>
      <?php endif ?>
    </li>
  <?php endfor ?>
</ul>
<?php endif ?>
<!-- /Pagination -->

