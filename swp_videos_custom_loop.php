<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// include query file
include_once( 'swp_wp_query_posts.php' );

class SWPCustomVideosLoop {

	// main function
	public function swp_video_loop_display_func( $params = array() ) {

		extract(shortcode_atts(array(
			'post_type' 		=> 'post_type',
			'posts_per_page' 	=> 'posts_per_page',
			'orderby'			=> 'orderby',
			'order'				=> 'order',
		), $params));

		global $post;

		// check posts per page value
		if( is_numeric( $posts_per_page ) ) {
			$posts_per_page_count = $posts_per_page;
		} else {
			$posts_per_page_count = -1;
		}

		global $wp_query;

		$swp_new_query = new SWPWPQueryPosts();
		$paged2 = isset( $_GET['paged2'] ) ? (int) $_GET['paged2'] : 1;
		// 			$swp_new_query->swp_query_archive_posts( $post_type, $num_of_posts, $paged, $orderby, $order )
		$wp_query = $swp_new_query->swp_query_archive_posts( $post_type, $posts_per_page_count, NULL, $orderby, $order );

		if ( have_posts() ) : 

			// LOOP
			while ( have_posts() ) : the_post(); 

				// Get Video URL
				$swp_video_link = get_post_meta( get_the_ID(), 'video', TRUE );

				// Get Video Clip ID
				$videoclipid = $this->swp_get_video_clip_id( $swp_video_link );

				// remove www. and .com
				$parse = str_ireplace( 'www.', '', str_ireplace( '.com', '', parse_url( $swp_video_link ) ) );
				if( $parse[ 'host' ] == 'dailymotion' ) {

					// set variables
					$swp_target_dir = 'dailymotionthumbs';
					$swp_source_dir = 'https://www.dailymotion.com/thumbnail/video/'.$videoclipid;
					//https://www.dailymotion.com/thumbnail/video/{video_id}

				} else {

					// set variables
					$swp_target_dir = 'youtubethumbs';
					$swp_source_dir = 'https://img.youtube.com/vi/'.$videoclipid.'/0.jpg';

				}

				// download thumbnail
    			if( $this->spk_download_video_thumb( $videoclipid, $swp_target_dir, $swp_source_dir, '0/' ) ) {

				    // NOTE: browser caching retains the same image even after replacement
				    //$ytthumb_w_ver = plugins_url( "images/".$swp_target_dir."/0/".$videoclipid.".jpg", __FILE__ ); //."?".date( 'YmdHis', filemtime( plugin_dir_path( __FILE__ )."../images/youtubethumbs/0/".$videoclipid.".jpg" ) );
				    /*$output .= '<div class="module-video" id="'.$videoclipid.'"><div class="module-wrap" id="'.$videoclipid.'-wrap">
				    				<div class="item-play" id="video_play_'.$videoclipid.'"></div>
				                    <div class="item-pic '.$swp_target_dir.'" id="video_image_'.$videoclipid.'">
				                        <img src="'.plugins_url( "images/".$swp_target_dir."/0/".$videoclipid.".jpg", __FILE__ ).'" class="thumbnail" id="thumbnail_'.$videoclipid.'" />
				                    </div>
				                </div></div>';*/
				    /*
						vs Gonzales: https://www.youtube.com/embed/zE-4r6D0NL4
						vs Jamie Conlan: https://www.youtube.com/embed/P0vZ7d1q9fw

				    */
				    $output .= '<div class="module-video"><div class="module-wrap">
				    				'.do_shortcode( "[swp_lightbox src='".$swp_video_link."']
					    				<div class='item-play'</div>
					    				<div class='item-pic'>
					                        <img src='".plugins_url( 'images/'.$swp_target_dir.'/0/'.$videoclipid.'.jpg', __FILE__ )."' class='thumbnail' />
					                    </div>
					                    [/swp_lightbox]" ).'
				    			</div></div>';

				}

			endwhile;

			/* Pagination with Alternative Prev/Next Text
			 * -------------- */
			// do_action( 'genesis_after_endwhile' );
			/*echo get_the_posts_pagination( array(
			    'mid_size' => 2,
			    'prev_text' => __( '<<', 'textdomain' ),
			    'next_text' => __( '>>', 'textdomain' ),
			) );*/

			// DIV CONTAINER
			return $output;

		endif;

		// Restore original Post Data
		//wp_reset_query();
		wp_reset_postdata();

	}

	// Extract YouTube video ID
	public function swp_get_video_clip_id( $url ) {

		$vid = explode( "/", $url );
	    $video_id = count($vid) - 1;
	    
	    $exp_vid = explode( "=", $vid[$video_id] );
	    if( count( $exp_vid ) > 1 ) {
	       // not using the embed URL
	       return $exp_vid[count( $exp_vid ) - 1];
	    } else {
	       // using the embed URL
	       return $vid[$video_id];
	    }

	}

	// Download YouTube Thumbnail
	public function spk_download_video_thumb( $videoclipid, $target, $videosource, $sub_folder ) {

		// create images sub directory if not present
		$target_directory = plugin_dir_path( __FILE__ ).'images/'.$target;
		if( !is_dir ( $target_directory ) ) {
			mkdir( $target_directory, 0755 );
		}

		// create image sub directory's sub directory if not present
		$target_directory_sub = plugin_dir_path( __FILE__ ).'images/'.$target.'/'.$sub_folder;
		if( $sub_folder && !is_dir( $target_directory_sub ) ) {
			mkdir( $target_directory_sub, 0755 );
		}

	    $spk_file_dir = plugin_dir_path( __FILE__ ).'images/'.$target.'/'.$sub_folder;
	        
	    // set filename
	    $filename = $spk_file_dir.$videoclipid.'.jpg';

	    // set source
	    $value = $videosource;
	    
	    $key = NULL; // not really required but just good to have in place

	    if( file_exists( $filename ) ) {

	        // validate time stamps
	        $start      = date('Y-m-d H:i:s'); 
	        $end        = date('Y-m-d H:i:s',filemtime( $filename )); 
	        $d_start    = new DateTime($start); 
	        $d_end      = new DateTime($end); 
	        $diff       = $d_start->diff($d_end);

	        $file_age = 14; // days

	        /* $diff->d for days
	         * $diff->h for hours
	         * $diff->i for minutes
	         */
	        if( $diff->d >= $file_age ) {
	            $this->spk_download_external_files_now( $filename, $key, $value );
	        }

	    } else {
	        // file doesn't exists
	        $this->spk_download_external_files_now( $filename, $key, $value );
	    }

	    return true;

	}

	// Downloader Function
	public function spk_download_external_files_now( $filename, $key, $value ) {

	    $value = file_get_contents( $value );

	    // facebook's JS is already minified but they added comments in it caused it to be tagged by Google for minification
	    if( $key == 'fbds' ) {
	        $value = preg_replace( '!/\*.*?\*/!s', '', $value );
	        $value = preg_replace( '/\n\s*\n/', "\n", $value );
	        $value = preg_replace('/^[ \t]*[\r\n]+/m', '', $value);
	    }

	    if( file_put_contents( $filename, $value ) ) {
	        return TRUE;
	    }

	}

	// Enqueue Scripts
	public function swp_enqueue_scripts() {
	    // last arg is true - will be placed before </body>
	    //wp_enqueue_script( 'spk_master_plugins_v1_js', plugins_url( '../js/spk_asset_master_plug_v1_min.js', __FILE__ ), NULL, NULL, true );
	    wp_register_script( 'swp_custom_loop', plugins_url( 'js/asset_videos.js', __FILE__ ), NULL, '1.1.0.0.2', TRUE );
	     
	    // Localize the script with new data
	    /*$translation_array = array(
	        'spk_master_one_ajax' => plugin_dir_url( __FILE__ ).'../ajax/spk_master_plug_v1_ajax.php',
	    );
	    wp_localize_script( 'swp_custom_loop', 'spk_master_one', $translation_array );*/
	     
	    // Enqueued script with localized data.
	    wp_enqueue_script( 'swp_custom_loop' );
	}

	// CONSTRUCT
	public function __construct() {
		
		add_shortcode( 'swp_video_loop_display', array( $this, 'swp_video_loop_display_func' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'swp_enqueue_scripts' ) );

    }

}

$swpcustomvideosloop = new SWPCustomVideosLoop();