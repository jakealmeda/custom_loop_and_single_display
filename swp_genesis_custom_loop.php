<?php
/**
 * Plugin Name: SWP - Genesis Custom Posts Loop
 * Description: Override the default Genesis Framework's post loop.
 * Version: 1.0
 * Author: Jake Almeda
 * Author URI: http://smarterwebpackages.com/
 * Network: true
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

//INCLUDE OTHER PLUGIN FILES
require_once( 'swp_wp_query_posts.php' );
require_once( 'swp_videos_custom_loop.php' );
require_once( 'swp_timeline_external_posts.php' );

class SWPGenesisCustomPostLoop extends SWPWPQueryPosts {

	// MAIN FUNCTION
	public function swp_my_custom_loop() {

		// First pagination
		//$paged1 = isset( $_GET['paged1'] ) ? (int) $_GET['paged1'] : 1;

		// 			 $this->swp_query_archive_posts( $post_type, $num_of_posts, $paged, $orderby, $order )
		$the_query = $this->swp_query_archive_posts( 'post', get_option('posts_per_page'), NULL, NULL, NULL );
		
		// The Loop
		if ( $the_query->have_posts() ) {

			// SET COUNTER
			$a = 1;

			?><section class="area-home"><div class="section-wrap"><?php

				// SECTION-POSTS (INTERNAL) CONTAINER - OPEN
				?><section class="area-post"><div class="area-wrap"><?php

				while ( $the_query->have_posts() ) {

					$the_query->the_post();

					$swp_video_link = get_post_meta( get_the_ID(), 'video_link', TRUE );

					// MAIN STORY - FEATURED
					if( $a == 1 ) {

						// FILTER POST FORMAT
						if( get_post_format() == "video" ) {

							?><div class="module-post post-video highlight"><div class="module-wrap"><?php

							if( $swp_video_link ) {

								include( 'views/swp_video_display.php' );

							} else {

								?><div class="item-title">Video link missing.</div><?php

							}

							?></div></div><?php

						} elseif( get_post_format() == "gallery" ) {

							?><div class="module-post post-gallery highlight"><div class="module-wrap"><?php

							include( 'views/swp_gallery_display.php' );

							?></div></div><?php

						} else {

							?><div class="module-post highlight"><div class="module-wrap"><?php

								include( 'views/swp_article_large_display.php' );

							// POST CONTAINER - CLOSE
							?></div></div><?php

						}

					} else {

						// FILTER POST FORMAT
						if( get_post_format() == "video" ) {

							?><div class="module-post post-video"><div class="module-wrap"><?php

							if( $swp_video_link ) {

								include( 'views/swp_video_display.php' );

							} else {

								?><div class="item-title">Video link missing.</div><?php

							}

							?></div></div><?php

						} elseif( get_post_format() == "gallery" ) {

							?><div class="module-post post-gallery"><div class="module-wrap"><?php

							include( 'views/swp_gallery_display.php' );

							?></div></div><?php

						}  else {

							// POST CONTAINER - OPEN
							?><div class="module-post"><div class="module-wrap"><?php
							
								include( 'views/swp_article_small_display.php' );

							// POST CONTAINER - CLOSE
							?></div></div><?php

						}

					}

					// VALIDATE COUNTER
					if( $a == 3 ) {
						// REVERT VALUE
						$a = 1;
					} else {
						// INCREMENT COUNTER
						$a++;
					}
				}

				/* PAGINATION
				 * ---------------------------------------------------------------------------- */
					/* With previous and next pages
					 * -------------- */
					//previous_posts_link(); next_posts_link();

					/* Without previous and next pages
					 * -------------- */
					//the_posts_pagination( array( 'mid_size'  => 2 ) );

					/* Pagination with Alternative Prev/Next Text
					 * -------------- */
					echo get_the_posts_pagination( array(
					    'mid_size' => 2,
					    'prev_text' => __( '<<', 'textdomain' ),
					    'next_text' => __( '>>', 'textdomain' ),
					) );
				/* PAGINATION END
				 * ---------------------------------------------------------------------------- */

				// SECTION-POSTS (INTERNAL) CONTAINER - CLOSE
				?></div></section>

				<?php
				/* Restore original Post Data */
				wp_reset_postdata();
				?>

				<?php // EXTERNAL POSTS CONTAINER - OPEN ?>
				<section class="area-timeline"><div class="area-wrap">
					<?php 
						//echo do_s hortcode( '[pods name="external_post" orderby="date_posted desc" limit="10" template="External Posts"]' );
						echo do_shortcode( '[swp_timelinestories_display post_type="external_post" posts_per_page="20" orderby="date_posted" order="desc"][/swp_timelinestories_display]' );
					?>

				<?php // EXTERNAL POSTS CONTAINER - CLOSE ?>
				</div></section>

				<?php // VIDEOS CONTAINER - OPEN ?>
				<section class="area-videos"><div class="area-wrap">

					<?php echo do_shortcode( '[swp_video_loop_display post_type="matches" posts_per_page="-1" orderby="post_date" order="desc"][/swp_video_loop_display]' ); ?>

				<?php // VIDEOS POSTS CONTAINER - CLOSE ?>
				</div></section>


			</div></section><?php

		} else {
			// no posts found
			echo 'No posts found';
		}

	}

	// USING DEFAULT GENESIS LOOP
	public function customize_genesis_loop() {

		if ( ! is_singular( 'post' ) )  return;

		// remove default header information
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		remove_action( 'genesis_entry_header', 'genesis_do_post_image', 8 );

		// add custom header information
		add_action( 'genesis_entry_header', 'swp_genesis_do_post_image', 1 );
		function swp_genesis_do_post_image () {

			$feat_img_cap = wp_get_attachment_caption( get_post_thumbnail_id() );

			if( get_post_thumbnail_id() ) {
				the_post_thumbnail( 'full' );
				/*?>
				<figure class="feature-pic pic-post wp-caption">
					<?php the_post_thumbnail( 'featured-image' ); ?>
					<?php if( $feat_img_cap ) { ?>
						<figcaption class="wp-caption-text"><?php echo $feat_img_cap; ?></figcaption>
					<?php } ?>
				</figure>
				<?php*/
			}
			
		}

		add_action( 'genesis_entry_header', 'swp_genesis_do_post_title', 2 );
		function swp_genesis_do_post_title() {

			echo '<h2><a href="'.get_the_permalink().'">'.get_the_title().'</a></h2>';

		}
		
		add_action( 'genesis_entry_header', 'swp_genesis_post_info', 12 );
		function swp_genesis_post_info() {
			?>By: <?php the_author_posts_link(); ?> on: <?php the_time( 'm/j/y g:i A' ) ?> | <a href="<?php comments_link(); ?>">Comments</a><?php
		}

	}

	public function swp_my_custom_loop_archives() {

		echo 'Jake';

	}

	// REMOVE DEFAULT LOOP
	public function remove_genesis_default_loop() {
		
		if( is_home() || is_front_page() ) {

			// Remove sidebar (force a layout) on homepage
			add_filter( 'genesis_site_layout', array( $this, 'swp_force_genesis_full_width_layout' ) );

			// Remove genesis loop on homepage
			remove_action( 'genesis_loop', 'genesis_do_loop' );

			// Replace the standard loop with our custom loop
			add_action( 'genesis_loop', array( $this, 'swp_my_custom_loop' ) );

		}/* elseif ( is_singular( 'post' ) ) {

			//$this->customize_genesis_loop();

		} else {
			// other archives
			
			// do nothing if a page is being viewed
			if ( is_page() )
				return;

			// Remove genesis loop on homepage
			remove_action( 'genesis_loop', 'genesis_do_loop' );

			// Replace the standard loop with our custom loop
			add_action( 'genesis_loop', array( $this, 'swp_my_custom_loop_archives' ) );
			
		}*/

	}

	// Genesis full width layout
	public function swp_force_genesis_full_width_layout() {
        return 'full-width-content';
	}

	// CONSTRUCT
	public function __construct() {
		
		add_action( 'get_header', array( $this, 'remove_genesis_default_loop' ) );

		//add_shortcode( 'swp_custom_loop', array( $this, 'swp_my_custom_loop' ) );

    }

}

$swpgenesiscustompostloop = new SWPGenesisCustomPostLoop();