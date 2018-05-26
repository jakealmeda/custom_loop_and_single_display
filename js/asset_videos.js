/* --------------------------------------------------------------------------------------------
 * | YOUTUBE EMBEDS
 * ----------------------------------------------------------------------------------------- */
jQuery( 'div.module-video' ).each( function() {
    
    var yt_id = this.id;

    /* ------------------------
     * | PLAY BUTTON
     * --------------------- */
    jQuery( '#video_play_' + yt_id ).on( 'click', function() {

        // hide play button and thumbnail div
        HideThisDiv( '#video_image_' + yt_id );
        
        // append video
        AppendVideo( yt_id );

    });
    
    /* ------------------------
     * | THUMBNAIL
     * --------------------- */
    jQuery( '#thumbnail_' + yt_id ).on( 'click', function() {
        
        if( jQuery( '#video_image_' + yt_id ).hasClass( "dailymotionthumbs" ) ) {

            // append video
            AppendVideo( yt_id, "dailymotionthumbs" );

        }

        if( jQuery( '#video_image_' + yt_id ).hasClass( "youtubethumbs" ) ) {

            // append video
            AppendVideo( yt_id, "youtubethumbs" );

        }

        // hide play button and thumbnail div
        HideThisDiv( '#video_image_' + yt_id );


    
    });
    
});

/* Hide Element */
function HideThisDiv( ThisElement ) {

    jQuery( ThisElement ).hide();

}

/* Append Video to DIV */
function AppendVideo( yt_ids, video_company ) {
    
    var CloseThisVideo = '<div class="item-unplay" id="unplay">Unplay</div>';

    if( video_company == 'youtubethumbs' ) {
        // '<iframe width="420" height="315" id="video_iframe" src="https://www.youtube.com/embed/' + yt_ids + '?autoplay=1" frameborder="0" allowfullscreen></iframe>' +
        // '<iframe width="600" height="400" src="https://www.youtube.com/embed/' + yt_ids + '?autohide=2&amp;autoplay=1&amp;controls=1&amp;fs=1&amp;loop=0&amp;modestbranding=0&amp;playlist=&amp;rel=0&amp;showinfo=1&amp;theme=dark&amp;wmode=&amp;playsinline=0" frameborder="0" allowfullscreen="true"></iframe>''
        jQuery( 'div#' + yt_ids + '-wrap' ).append( '<div class="item-video su-youtube su-responsive-media-yes"><iframe width="600" height="400" src="https://www.youtube.com/embed/' + yt_ids + '?autohide=2&amp;autoplay=1&amp;controls=1&amp;fs=1&amp;loop=0&amp;modestbranding=0&amp;playlist=&amp;rel=0&amp;showinfo=1&amp;theme=dark&amp;wmode=&amp;playsinline=0" frameborder="0" allowfullscreen="true"></iframe></div>' + CloseThisVideo );
    } else {
        // http://www.dailymotion.com/embed/video/x5sbjqo
        // <iframe width="420" height="315" id="video_iframe" src="http://www.dailymotion.com/embed/video/' + yt_ids + '?autoplay=1" frameborder="0" allowfullscreen></iframe>
        // <iframe width="600" height="400" src="http://www.dailymotion.com/embed/video/' + yt_ids + '?autoplay=1&amp;background=FFC300&amp;foreground=F7FFFD&amp;highlight=171D1B&amp;logo=1&amp;quality=240&amp;related=0&amp;info=1" frameborder="0" allowfullscreen="true"></iframe>
        jQuery( 'div#' + yt_ids + '-wrap' ).append( '<div class="item-video su-youtube su-responsive-media-yes"><iframe width="600" height="400" src="http://www.dailymotion.com/embed/video/' + yt_ids + '?autoplay=1&amp;background=FFC300&amp;foreground=F7FFFD&amp;highlight=171D1B&amp;logo=1&amp;quality=240&amp;related=0&amp;info=1" frameborder="0" allowfullscreen="true"></iframe></div>' + CloseThisVideo );
    }

    jQuery( 'div#' + yt_ids ).addClass( 'playing' );

}