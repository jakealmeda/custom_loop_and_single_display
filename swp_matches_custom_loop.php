<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class SWPCustomMatchesLoop {

	public function swp_matches_custom_loop_func() {

		global $post;
		// arguments, adjust as needed
		$args = array(
			'post_type'      	=> 'matches',
			'posts_per_page' 	=> -1,
			'post_status'    	=> 'publish',
			'paged'          	=> get_query_var( 'paged' ),
		);
		/* 
		Overwrite $wp_query with our new query.
		The only reason we're doing this is so the pagination functions work,
		since they use $wp_query. If pagination wasn't an issue, 
		use: https://gist.github.com/3218106
		*/
		global $wp_query;

		$wp_query = new WP_Query( $args );

		if ( have_posts() ) : 

			// LOOP
			while ( have_posts() ) : the_post(); 

				$swp_video_link = get_post_meta( get_the_ID(), 'video', TRUE );

				// remove www. and .com
				$parse = str_ireplace( 'www.', '', str_ireplace( '.com', '', parse_url( $swp_video_link ) ) );
				if( $parse[ 'host' ] == 'dailymotion' ) {
					// autoplay="no" background="#FFC300" foreground="#F7FFFD" highlight="#171D1B" logo="yes" quality="380" related="yes" info="yes" class=""
					$swp_video_linked = do_shortcode( '[swp_dailymotion url="'.$swp_video_link.'" width="760" height="580" responsive="yes"][/swp_dailymotion]' );
				} else {
					$swp_video_linked = do_shortcode( '[swp_youtube url="'.$swp_video_link.'" width="760" height="580" responsive="yes"][/swp_youtube]' );
				}
				// <iframe width="760" height="580" src="'.$swp_video_link.'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
				$output .= '<div class="module module-matches">
						<div class="item-video">'.$swp_video_linked.'</div>
						<div class="item-title">'.get_the_title().'</div>
						<div class="item-content-matchdate">When: '.get_post_meta( get_the_ID(), "schedule", TRUE ).'</div>
						<div class="item-content-matchlocation">Venue: '.get_post_meta( get_the_ID(), "location", TRUE).'</div>
					</div>';

			endwhile;
			
			// DIV CONTAINER
			return '<div class="section-matches"><div class="section-wrap">'.$output.'</div></div>';

			// CONTAINS PAGINATION
			do_action( 'genesis_after_endwhile' );

		endif;

		// Restore original Post Data
		wp_reset_query();

	}

	// CONSTRUCT
	public function __construct() {
		
		add_shortcode( 'swp_matches_custom_loop', array( $this, 'swp_matches_custom_loop_func' ) );

    }

}

$swpcustommatchesloop = new SWPCustomMatchesLoop();