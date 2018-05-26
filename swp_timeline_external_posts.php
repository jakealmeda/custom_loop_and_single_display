<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// include query file
include_once( 'swp_wp_query_posts.php' );

class SWPTimeLineStories {

	// main function
	public function swp_timelinestories_display_func( $params = array() ) {

<<<<<<< HEAD
		extract(shortcode_atts(array(
=======
		/*extract(shortcode_atts(array(
>>>>>>> 7d3392cbc2d8bddc8ac66aa08e384458e9e34a1a
			'post_type' 		=> 'post_type',
			'posts_per_page' 	=> 'posts_per_page',
			'orderby'			=> 'orderby',
			'order'				=> 'order',
		), $params));

<<<<<<< HEAD
=======
		//global $post;

>>>>>>> 7d3392cbc2d8bddc8ac66aa08e384458e9e34a1a
		// check posts per page value
		if( is_numeric( $posts_per_page ) ) {
			$posts_per_page_count = $posts_per_page;
		} else {
			$posts_per_page_count = -1;
<<<<<<< HEAD
		}
// ----------------------------------------------
	$query = new WP_Query( array( 'posts_per_page' => $posts_per_page_count, 'post_type' => $post_type, 'orderby' => $orderby, 'order' => $order ) );

	while ($query->have_posts()) : $query->the_post();

		// prepare the featured image
		$get_the_term_id = get_the_terms( get_the_ID(), 'source_site' )[0]->term_id;
		$source_site = "<a href='".get_term_meta( $get_the_term_id, 'source_url', TRUE )."'>
							".get_the_terms( get_the_ID(), 'source_site' )[0]->name."
						</a>";

		// images sub directory
		$image_sub_dir = "external_posts";
		
		// images sub directory's sub directory
		$image_sub_dir_sub = "";

		// sanitize filename
		$filename = str_replace( " ", "_", preg_replace("~[^a-z0-9:]~i", " ", strtolower( get_the_title() ) ) );

		// download external images first
		$featured_image = get_post_field( 'featured_image', get_the_ID(), $context );
		if( $featured_image ) {

			$download_featured_image = new SWPCustomVideosLoop();
			$new_dir = $download_featured_image->spk_download_video_thumb( $filename, $image_sub_dir, get_term_meta( $get_the_term_id, 'source_url', TRUE ), $image_sub_dir_sub );

		} else {
			// featured image on the article host was removed; use local copy

		}

		// use this featured image
		$featured_image = plugin_dir_url( __FILE__ ).'images/'.$image_sub_dir.'/'.$image_sub_dir_sub.$filename.'.jpg';

		include( 'views/swp_timeline_display.php' );

	endwhile;

	// ADD PAGINATION HERE!!!!!!!!!
	/*echo get_the_posts_pagination( array(
	    'mid_size' => 2,
	    'prev_text' => __( '<<', 'textdomain' ),
	    'next_text' => __( '>>', 'textdomain' ),
	) );*/
=======
		}*/
// ----------------------------------------------
	/*$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$query = new WP_Query( array( 'posts_per_page' => 2, 'post_type' => 'post', 'paged' => $paged, ) );

	while ($query->have_posts()) : $query->the_post(); ?>
	   <article>
	      <h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
	   <article>
	<?php endwhile; ?>

	<div class="nav-previous alignleft"><?php next_posts_link( 'Older posts' ); ?></div>
	<div class="nav-next alignright"><?php previous_posts_link( 'Newer posts' ); ?></div>
	<?php*/



	$temp = $wp_query; 
	$wp_query = null; 
	$wp_query = new WP_Query(); 
	$wp_query->query('showposts=2&post_type=post'.'&paged='.get_query_var( 'paged' )); 

	while ($wp_query->have_posts()) : $wp_query->the_post(); 

		echo the_title().'<br />';

	endwhile; ?>

	<nav>
	<?php previous_posts_link('&laquo; Newer') ?>
	<?php next_posts_link('Older &raquo;') ?>
	</nav>

	<?php 
	$wp_query = null; 
	$wp_query = $temp;  // Reset
>>>>>>> 7d3392cbc2d8bddc8ac66aa08e384458e9e34a1a

// ----------------------------------------------
		wp_reset_postdata();

	}

	// CONSTRUCT
	public function __construct() {
		
		add_shortcode( 'swp_timelinestories_display', array( $this, 'swp_timelinestories_display_func' ) );

		//add_action( 'wp_enqueue_scripts', array( $this, 'swp_enqueue_scripts' ) );

    }

}

$swptimelinestories = new SWPTimeLineStories();