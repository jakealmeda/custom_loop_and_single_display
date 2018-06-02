<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class SWPWPQueryPosts {
	
	public function swp_query_archive_posts( $post_type, $num_of_posts, $paged, $orderby, $order ) {

		// sort
		if( is_null( $orderby ) ) {
			$orderby = 'date';
			$order = 'DESC';
		}

		// pagination
		if( $paged ) {
			$paged = $paged;
		} else {
			$paged = get_query_var( 'paged' );
		}

		// check posts per page value
		if( is_numeric( $num_of_posts ) ) {
			$num_of_posts = $num_of_posts;
		} else {
			$num_of_posts = -1;
		}

		$args = array(
			'post_type' 		=> $post_type,
			'post_status'    	=> 'publish',
			'posts_per_page' 	=> $num_of_posts,
			'paged' 			=> $paged,
			'orderby'			=> $orderby,
			'order'				=> $order,
		);

		return new WP_Query( $args );

	}

}