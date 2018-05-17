<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class SWPWPQueryPosts {
	
	public function swp_query_archive_posts( $post_type, $num_of_posts ) {

		$args = array(
			'post_type' 		=> $post_type,
			'post_status'    	=> 'publish',
			'posts_per_page' 	=> $num_of_posts,
			'paged' 			=> get_query_var( 'paged' ),
		);

		return new WP_Query( $args );

	}

}