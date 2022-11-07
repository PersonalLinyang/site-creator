<?php
get_header();

?>

<section>
  <?php var_dump($post->ID); ?>
  <?php var_dump(get_field('post_parent')); ?>
</section>

<?php
get_footer();