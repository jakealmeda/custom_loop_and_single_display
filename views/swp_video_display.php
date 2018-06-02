<?php
// template for displaying videos

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$swp_video_linked = do_shortcode( '[swp_su_video url="'.$swp_video_link.'"][/swp_su_video]' );
?>

<div class="item-video"><?php echo $swp_video_linked; ?></div>
<div class="item-title"><?php echo get_the_title(); ?></div>