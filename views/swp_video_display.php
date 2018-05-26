<?php
// template for displaying videos

$parse = str_ireplace( 'www.', '', str_ireplace( '.com', '', parse_url( $swp_video_link ) ) );

if( $parse[ 'host' ] == 'dailymotion' ) {
	// Daily Motion
	$swp_video_linked = do_shortcode( '[swp_dailymotion url="'.$swp_video_link.'" width="760" height="580" responsive="yes"][/swp_dailymotion]' );
} else {
	// YouTube
	$swp_video_linked = do_shortcode( '[swp_youtube url="'.$swp_video_link.'" width="760" height="580" responsive="yes"][/swp_youtube]' );
}
?>

<div class="item-video"><?php echo $swp_video_linked; ?></div>
<div class="item-title"><?php echo get_the_title(); ?></div>