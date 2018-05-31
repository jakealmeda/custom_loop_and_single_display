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