<?php
// template for displaying post in timeline

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

?>

<div class="module module-external">
	<div class="item-dateposted"><h6><?php echo date( 'j M y', strtotime( get_the_date() ) ); ?><br /><?php echo date( 'g:i a', strtotime( get_the_date() ) ); ?></h6></div>
	<div class="item-title"><a href="<?php echo get_post_field( 'link_to_post', get_the_ID(), $context ); ?>" target="_blank"><h5><?php echo get_the_title(); ?></h5></a></div>
	<div class="item-author"><h6><?php echo $source_site.' | '.get_the_terms( get_the_ID(), 'external_writer' )[0]->name; ?></h6></div>
	<div class="item-pic"><a href="<?php echo get_post_field( 'link_to_post', get_the_ID(), $context ); ?>" target="_blank"><img src="<?php echo $featured_image_local; ?>" width="100%" height="auto" /></a></div>
</div>