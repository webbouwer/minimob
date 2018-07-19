<?php
// index.php
echo '<!DOCTYPE HTML>';
echo '<html ';
language_attributes();
echo '><head>';

echo '<meta http-equiv="Content-Type" content="text/html; charset='.get_bloginfo( 'charset' ).'" />';

echo '<link rel="canonical" href="'.home_url(add_query_arg(array(),$wp->request)).'">'
	.'<link rel="pingback" href="'.get_bloginfo( 'pingback_url' ).'" />'
	.'<link rel="shortcut icon" href="images/favicon.ico" />'
	// tell devices wich screen size to use by default
	.'<meta name="viewport" content="initial-scale=1.0, width=device-width" />'
	.'<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';

if ( ! isset( $content_width ) ) $content_width = 360; // mobile first

echo '</head><body ';
body_class();
echo '>';


    // sidemenu
	if ( has_nav_menu( 'sidemenu' ) ){
		echo '<div id="sidemenubox"><div id="sidemenu" class="pos-default"><nav><div class="innerpadding">';
		wp_nav_menu( array( 'theme_location' => 'sidemenu', 'fallback_cb' => true ) );
		echo '<div class="clr"></div></div></nav></div></div>';
	}

	dynamic_sidebar('sidebar');




    if ( have_posts() ) :
	while( have_posts() ) : the_post();

    $featuredImage = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); //wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
    if($featuredImage){
        echo '<img src="'.$featuredImage[0].'" />';
    }
	echo get_the_title();


    endwhile;
	endif;
	wp_reset_query();



wp_footer();

echo '</body></html>';
?>
