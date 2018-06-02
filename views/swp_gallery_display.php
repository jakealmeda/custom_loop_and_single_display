<?php
// template for displaying gallery post format

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

?>

<div class="module module-gallery">
	<div class="item-title"><?php echo get_the_title(); ?></div>
	<div class="item-gallery"><?php echo do_shortcode( get_the_content() ); ?></div>
</div>