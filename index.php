<?php
// index.php
echo '<!DOCTYPE HTML>';
echo '<html ';
language_attributes();
echo '><head>';

echo '<meta http-equiv="Content-Type" content="text/html; charset='.get_bloginfo( 'charset' ).'" />';

echo //'<link rel="canonical" href="'.home_url(add_query_arg(array(),$wp->request)).'">'
	//.'<link rel="pingback" href="'.get_bloginfo( 'pingback_url' ).'" />'
	'<link rel="shortcut icon" href="images/favicon.ico" />'
	// tell devices wich screen size to use by default
	.'<meta name="viewport" content="initial-scale=1.0, width=device-width" />'
	.'<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';

//wp_head();
echo '<script type="text/javascript" src="'.get_site_url().'/wp-includes/js/jquery/jquery.js?ver=1.4.1"></script>';
echo '<script type="text/javascript" src="'.get_site_url().'/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.4.1"></script>';
echo '<link type="text/css" rel="stylesheet" href="'.get_template_directory_uri(). '/assets/menu.css" />';
echo '<link type="text/css" rel="stylesheet" href="'.get_template_directory_uri() . '/style.css" />';
if ( ! isset( $content_width ) ) $content_width = 360; // mobile first
?>
<script>
jQuery( function($){

    $('#slidemenu').css({ 'z-index' : '980'  });

    $('#slidemenu').after('<div id="slidemenutoggle">menu</div>');

    $('#slidemenu').prepend( $('#site-titlebox').clone() );

    $('#slidemenu').animate({ opacity : 0 }, 'fast', function() {
                $('#slidemenu ul li').hide();
                $('#slidemenutoggle').html('menu');
                //$('#slidemenu').css({ 'bottom' : '-100%'  });
                $('#slidemenu').css({ 'top' : '-100%'  });
    });
    $('#slidemenu').on('click', function(){

        setTimeout(function(){
        $('#slidemenutoggle').click();
        }, 200);
    });

    $('#slidemenutoggle').toggle(
        function() {

            //$('#slidemenu').css({ 'bottom' : '0px'  });
            $('#slidemenu').css({ 'top' : '0'  });
            var c = 0;
            //$('.mejs-container').fadeOut(100);
            $('#slidemenu ul li').each( function( idx,obj ){
                c++;
                setTimeout(function(){
                    $(obj).fadeIn(600);
                }, c * 100);
            });

            $('#slidemenu').animate({ opacity: 1 }, 300, function() {
                $('#slidemenutoggle').html('close');
            });
        },
        function() {

            $('#slidemenu').css({ 'bottom' : '0px'  });
            var c = 0;
            $('#slidemenu ul li').each( function( idx,obj ){
                c++;
                setTimeout(function(){
                    $(obj).fadeOut(300);
                }, 300 / c);
            });
            setTimeout(function(){
                $('#slidemenu').animate({ opacity: 0 }, 300, function() {
                    $('#slidemenutoggle').html('menu');
                    //$('#slidemenu').css({ 'bottom' : '-100%'  });
                    $('#slidemenu').css({ 'top' : '-100%'  });
                    //$('.mejs-container').fadeIn(200);
                });
            }, 600 );
        }
    );

    $(document).ready( function(){

    });
});
</script>
<?
// https://css-tricks.com/perfect-full-page-background-image/

$bgposition = get_theme_mod('background_position', 'bottom center');
$bgattacht = get_theme_mod('background_attachment', 'fixed');
$bgrepeat = get_theme_mod('background_repeat', 'no-repeat');
$bgsize = get_theme_mod('background_size', 'cover');
$headerbgstyle = ' style="background-image:url('.esc_url( get_background_image() ).');background-position:'.$bgposition.';background-attachment:'.$bgattacht.';background-size:'.$bgsize.';background-repeat:'.$bgrepeat.';"';

echo '</head><body '.$headerbgstyle.' ';
body_class();
echo '>';


    echo '<div id="pagecontainer">';

    if( !is_front_page() ){
        echo '<div id="pagebackbutton" onclick="history.go(-1)">back</div>';
    }

    echo '<div id="topbar"><div class="outermargin">';

        // logo / taglines etc
        echo '<div id="site-titlebox"><hgroup><h1 class="site-title"><a href="'.esc_url( home_url( '/' ) ).'" id="site-logo" title="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" rel="home">'.esc_attr( get_bloginfo( 'name', 'display' ) ).'</a></h1>';
        //echo '<h2 class="site-description">'.get_bloginfo( 'description' ).'</h2>';
        echo '</hgroup></div>';

        // topmenu
        if ( has_nav_menu( 'topmenu' ) ){
            echo '<div id="topmenubox"><div id="topmenu" class="pos-default"><nav><div class="innerpadding">';
            wp_nav_menu( array( 'theme_location' => 'topmenu' ) );
            echo '<div class="clr"></div></div></nav></div></div>';
        }



	echo '<div class="clr"></div></div></div>';


    $header_image = get_header_image();
	$headerbgstyle = '';
    if( ! empty( $header_image ) ){
	$headerbgstyle = ' style="min-height:200px; background-image:url('.esc_url( $header_image ).');"';
    }
    echo '<div id="header" '.$headerbgstyle.'><div class="outermargin">';

        if( function_exists('dynamic_sidebar') && function_exists('is_sidebar_active') && is_sidebar_active('widgets-header') ){
			dynamic_sidebar('widgets-header');
		}


	echo '<div class="clr"></div></div></div>';


    echo '<div id="maincontainer"><div class="outermargin">';

    $morestyle = '';
    if( is_category() ){
        $morestyle = 'category';
    }

     echo '<div id="maincontent" class="modal-content '.$morestyle.'">';

            if( function_exists('dynamic_sidebar') && function_exists('is_sidebar_active') && is_sidebar_active('widgets-before-content') ){

            echo '<div id="widgets-before-content">';
            dynamic_sidebar('widgets-before-content');
            echo '<div class="clr"></div></div>';
		}

        if ( have_posts() ) :
        while( have_posts() ) : the_post();

        echo '<div id="post-'.get_the_ID().'"';
        post_class();
        echo '>';

        // image
        $featuredImage = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );

        // define title link
        $custom_metabox_url = get_post_meta( get_the_ID() , 'meta-box-custom-url', true);
        $custom_metabox_useurl = get_post_meta( get_the_ID() , 'meta-box-custom-useurl', true);
        $custom_metabox_urltext = get_post_meta( get_the_ID() , 'meta-box-custom-urltext', true);

        $title_link = '<a href="'.get_the_permalink().'" target="_self" title="'.get_the_title().'">';
        $image_link = '<a class="coverimage" href="'.get_the_permalink().'" target="_self" title="'.get_the_title().'">';
        if( $custom_metabox_url != '' && $custom_metabox_useurl == 'replaceblank'){
            $title_link = '<a href="'.$custom_metabox_url.'" target="_blank" title="'.get_the_title().'">';
            $image_link = '<a class="coverimage" href="'.$custom_metabox_url.'" target="_blank" title="'.get_the_title().'">';
        }elseif( $custom_metabox_url != '' && $custom_metabox_useurl == 'replaceself'){
            $title_link = '<a href="'.$custom_metabox_url.'" target="_self" title="'.get_the_title().'">';
            $image_link = '<a class="coverimage" href="'.$custom_metabox_url.'" target="_blank" title="'.get_the_title().'">';
        }

        if($featuredImage){
            echo $image_link;
            echo '<img class="post-featured-image" src="'.$featuredImage[0].'" />';
            echo '</a>';
        }


        if( $custom_metabox_useurl != 'hide' ){



            $titlesize = 'h2';
            if( is_single() || is_page() ){
                $titlesize = 'h1';
                echo '<div class="post-title">';
            }else{
                echo '<div class="post-title">'. $title_link; // <a class="title-link" href="'.get_the_permalink().'" title="'.get_the_title().'" >';
            }
            echo '<'.$titlesize.'>'.get_the_title().'</'.$titlesize.'>';

            //echo '<span class="post-date time-ago">';
            //wp_time_ago(get_the_time( 'U' ));
            //echo '</span>';
            //echo ' <span class="post-author">'.__('door','minimob').' '.get_the_author().'</span> ';

            if( is_single() || is_page() ){
                echo '<div class="clr"></div></div>';
            }else{
                echo '</a><div class="clr"></div></div>';
            }

        }

        echo '<div class="post-content">';
        if( is_single() || is_page() ){

            echo apply_filters('the_content', get_the_content());

            if( is_single() ){

                //previous_post_link('%link', __('prev: ', 'minimob' ).': %title', false);
                //next_post_link('%link', __('next: ', 'minimob' ).': %title', false);

                // post comments
                if ( comments_open() || get_comments_number() ) {
                comments_template(); // WP THEME STANDARD: comments_template( $file, $separate_comments );
                }
            }

        }else{
            echo the_excerpt_length( 32 ); // echo apply_filters('the_excerpt', get_the_excerpt());
        }


        // define custom link (internal / external)
        if( $custom_metabox_url != '' && ($custom_metabox_useurl == 'external' || $custom_metabox_useurl == 'internal') ){
            $custom_link = '<a href="'.get_the_permalink().'" target="_self" title="'.get_the_title().'">';
            if( $custom_metabox_url != '' && $custom_metabox_useurl == 'external'){
            $custom_link = '<a href="'.$custom_metabox_url.'" target="_blank" title="'.get_the_title().'">';
            }elseif( $custom_metabox_url != '' && $custom_metabox_useurl == 'internal'){
            $custom_link = '<a href="'.$custom_metabox_url.'" target="_self" title="'.get_the_title().'">';
            }
            echo $custom_link.$custom_metabox_urltext.'</a>';
        }




	   echo '<div class="clr"></div></div>';


	   echo '<div class="clr"></div></div>';

        endwhile;
        endif;




        wp_reset_query();


        if( function_exists('dynamic_sidebar') && function_exists('is_sidebar_active') && is_sidebar_active('widgets-after-content') ){

            echo '<div id="widgets-after-content">';
            dynamic_sidebar('widgets-after-content');
            echo '<div class="clr"></div></div>';
		}

	echo '<div class="clr"></div></div>';

	echo '<div id="sidebar">';

        // sidemenu
        if ( has_nav_menu( 'sidemenu' ) ){
            echo '<div id="sidemenubox"><div id="sidemenu" class="pos-default"><nav><div class="innerpadding">';
            wp_nav_menu( array( 'theme_location' => 'sidemenu' ) );
            echo '<div class="clr"></div></div></nav></div></div>';
        }


        dynamic_sidebar('sidebar');

	echo '<div class="clr"></div></div>';

	echo '<div class="clr"></div></div></div>';

    // slidemenu
        echo '<div id="slidemenubox"><div id="slidemenu" class="pos-default"><nav><div class="innerpadding">';

        if ( has_nav_menu( 'slidemenu' ) ){
            wp_nav_menu( array( 'theme_location' => 'slidemenu' ) );
        }else{
            wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) );
        }
        echo '<div class="clr"></div></div></nav></div></div>';


	echo '<div id="footerbar"><div class="outermargin">';

        // topmenu
        if ( has_nav_menu( 'footermenu' ) ){
            echo '<div id="footermenubox"><div id="footermenu" class="pos-default"><nav><div class="innerpadding">';
            wp_nav_menu( array( 'theme_location' => 'footermenu' ) );
            echo '<div class="clr"></div></div></nav></div></div>';
        }

	echo '<div class="clr"></div></div></div>';


	echo '<div class="clr"></div></div>';


wp_footer();

echo '</body></html>';
?>
