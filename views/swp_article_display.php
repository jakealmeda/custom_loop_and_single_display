<?php
// template for displaying post entries
?>

<div class="item-pic">
	<?php echo '<a href="'.get_the_permalink().'">'.get_the_post_thumbnail( get_the_ID(), 'featured-image' ).'</a>'; ?>
</div>
<div class="item-title">
	<?php echo '<a href="'.get_the_permalink().'">'.get_the_title().'</a>'; ?>
</div>
<div class="item-author">
	<?php the_author_posts_link(); ?>
</div>
<div class="item-date">
	<?php echo get_the_date(); ?>
</div>
<div class="item-summary">
	<?php echo wp_trim_words( get_the_content(), $num_words = 25, $more = ' <a href="'.get_the_permalink().'">[..]</a>' ); ?>
</div>
