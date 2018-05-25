<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// include query file
include_once( 'swp_wp_query_posts.php' );

class SWPTimeLineStories {

	// main function
	public function swp_timelinestories_display_func( $params = array() ) {

		/*extract(shortcode_atts(array(
			'post_type' 		=> 'post_type',
			'posts_per_page' 	=> 'posts_per_page',
			'orderby'			=> 'orderby',
			'order'				=> 'order',
		), $params));

		//global $post;

		// check posts per page value
		if( is_numeric( $posts_per_page ) ) {
			$posts_per_page_count = $posts_per_page;
		} else {
			$posts_per_page_count = -1;
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