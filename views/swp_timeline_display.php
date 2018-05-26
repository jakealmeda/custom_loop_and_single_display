<?php
// template for displaying post in timeline
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
<<<<<<< HEAD
?>

<div class="module module-external">
	<div class="item-dateposted"><h6><?php echo date( 'j M y', strtotime( get_the_date() ) ); ?><br /><?php echo date( 'g:i a', strtotime( get_the_date() ) ); ?></h6></div>
	<div class="item-title"><a href="<?php echo get_post_field( 'link_to_post', get_the_ID(), $context ); ?>" target="_blank"><h5><?php echo get_the_title(); ?></h5></a></div>
=======

var_dump( get_the_terms( get_the_ID(), 'source_site' )[0] );
$get_the_term_id = get_the_terms( get_the_ID(), 'source_site' )[0]->term_id;
var_dump( get_post_field( 'source_url', $get_the_term_id, $context ) );

//$source_site = "<a href='".get_the_terms( get_the_ID(), 'source_site' )[0]->name."'>".get_the_terms( get_the_ID(), 'source_site' )[0]->name."</a>";
?>

<div class="module module-external">
	<div class="item-dateposted"><h4><?php echo get_the_date(); ?></h4></div>
	<div class="item-title"><a href="<?php echo get_post_field( 'link_to_post', get_the_ID(), $context ); ?>" target="_blank"><h4><?php echo get_the_title(); ?></h4></a></div>
>>>>>>> 7d3392cbc2d8bddc8ac66aa08e384458e9e34a1a
	<div class="item-author"><h6><?php echo $source_site.' | '.get_the_terms( get_the_ID(), 'external_writer' )[0]->name; ?></h6></div>
	<div class="item-pic"><a href="<?php echo get_post_field( 'link_to_post', get_the_ID(), $context ); ?>" target="_blank"><img src="<?php echo get_post_field( 'featured_image', get_the_ID(), $context ); ?>" width="100%" height="auto" /></a></div>
</div>