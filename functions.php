<?php

    require get_template_directory() . '/assets/menu.php'; // menu options functions
    require get_template_directory() . '/assets/postmetabox.php'; // post/page meta option functions


	/*
	 * Register Theme Support
	 */
	function minimob_setup_theme_global() {
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'big-thumb', 320, 9999 );
		add_image_size( 'medium', 480, 9999 );
		add_image_size( 'normal', 960, 9999 );
		//add_image_size( 'slide', 1800, 640, array( 'center', 'center' ) );
		add_theme_support( 'title-tag' );
		//add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'custom-header' );
		add_theme_support( 'custom-background' );
	}
	add_action( 'after_setup_theme', 'minimob_setup_theme_global' );

	/*
	 * Register menu's
	 */
	function minimob_setup_register_menus() {
		register_nav_menus(
			array(
			'topmenu' => __( 'Top menu' , 'minimob' ),
			'slidemenu' => __( 'Slide menu' , 'minimob' ),
			'sidemenu' => __( 'Side menu' , 'minimob' ),
			'footermenu' => __( 'Footer menu' , 'minimob' )
			)
		);
	}
	add_action( 'init', 'minimob_setup_register_menus' );

	/*
	 * Editor style WP THEME STANDARD
	 */

    // for admin editor
	function minimob_editor_styles() {
		add_editor_style( 'style.css' );
		//add_editor_style( get_theme_mod('onepiece_identity_stylelayout_stylesheet', 'default.css') );
	}
	add_action( 'admin_init', 'minimob_editor_styles' );


	/* JQuery init ! internet */
	/*function minimob_frontend_jquery() {
		wp_enqueue_script('jquery');
	}
	add_action( 'init', 'minimob_frontend_jquery' );
    */

    /* Widgets */
	function minimob_setup_widgets_init() {
		if (function_exists('register_sidebar')) {


			// the default wordpress header widget
			register_sidebar(array(
				'name' => 'Header content (Widgets Default)',
				'id'   => 'widgets-header',
				'description'   => 'This is a standard wordpress widgetized area.',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '<div class="clr"></div></div></div>',
				'before_title'  => '<div class="widget-titlebox"><h3>',
				'after_title'   => '</h3></div><div class="widget-contentbox">'
			));


			// the before content
			register_sidebar(array(
				'name' => 'Before Content',
				'id'   => 'widgets-before-content',
				'description'   => 'Before content widgetized content',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '<div class="clr"></div></div></div>',
				'before_title'  => '<div class="widget-titlebox"><h3>',
				'after_title'   => '</h3></div><div class="widget-contentbox">'
			));

			// the after content
			register_sidebar(array(
				'name' => 'After Content',
				'id'   => 'widgets-after-content',
				'description'   => 'After content widgetized content',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '<div class="clr"></div></div></div>',
				'before_title'  => '<div class="widget-titlebox"><h3>',
				'after_title'   => '</h3></div><div class="widget-contentbox">'
			));

			// the content sidebar widget
			register_sidebar(array(
				'name' => 'Content sidebar 1 (Widgets Default)',
				'id'   => 'sidebar',
				'description'   => 'This is a standard wordpress sidebar widgetized area.',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '<div class="clr"></div></div></div>',
				'before_title'  => '<div class="widget-titlebox"><h3>',
				'after_title'   => '</h3></div><div class="widget-contentbox">'
			));

			// the footer content
			register_sidebar(array(
				'name' => 'Footer Content',
				'id'   => 'widgets-footer',
				'description'   => 'Footer widgetized content',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '<div class="clr"></div></div></div>',
				'before_title'  => '<div class="widget-titlebox"><h3>',
				'after_title'   => '</h3></div><div class="widget-contentbox">'
			));


		}
	}
	add_action( 'widgets_init', 'minimob_setup_widgets_init' );



	/*
	 * Check active widgets
	 */
	function is_sidebar_active( $sidebar_id ){
		$the_sidebars = wp_get_sidebars_widgets();
		if( !isset( $the_sidebars[$sidebar_id] ) )
			return false;
		else
			return count( $the_sidebars[$sidebar_id] );
	}

	/*
	 * Widget empty title content wrapper fix
	*/
	function check_sidebar_params( $params ) {
		global $wp_registered_widgets;

		$settings_getter = $wp_registered_widgets[ $params[0]['widget_id'] ]['callback'][0];
		$settings = $settings_getter->get_settings();
		$settings = $settings[ $params[1]['number'] ];

		if ( $params[0][ 'after_widget' ] == '<div class="clr"></div></div></div>' && isset( $settings[ 'title' ] ) &&  empty( $settings[ 'title' ] ) ){
			$params[0][ 'before_widget' ] .= '<div class="widget-contentbox">';
		}

		return $params;
	}
	add_filter( 'dynamic_sidebar_params', 'check_sidebar_params' );



    /* Theme global functions */
	function check_image_orientation($pid){
		// check oriëntation
			$orient = 'square';
			$image = wp_get_attachment_image_src( get_post_thumbnail_id($pid), '');
			$image_w = $image[1];
			$image_h = $image[2];

			if ($image_w > $image_h) {
				$orient = 'landscape';
			}elseif ($image_w == $image_h) {
				$orient = 'square';
			}else {
				$orient = 'portrait';
			}
			return $orient;
	}


	/*
	 * Time
	 */
	function wp_time_ago( $t ) {
		// https://codex.wordpress.org/Function_Reference/human_time_diff
		//get_the_time( 'U' )
		printf( _x( '%s '.__('ago','minimob'), '%s = human-readable time difference', 'minimob' ), human_time_diff( $t, current_time( 'timestamp' ) ) );
	}


	/*
	 * Adjust excerpt num words max
	 */
	function the_excerpt_length( $words = null, $links = true ) {
		global $_the_excerpt_length_filter;

		if( isset($words) ) {
			$_the_excerpt_length_filter = $words;
		}

		add_filter( 'excerpt_length', '_the_excerpt_length_filter' );
		if( $links == false){
			echo preg_replace('/(?i)<a([^>]+)>(.+?)<\/a>/','', get_the_excerpt() );
		}else{
			the_excerpt();
		}

		remove_filter( 'excerpt_length', '_the_excerpt_length_filter' );

		// reset the global
		$_the_excerpt_length_filter = null;
	}
    // return excerpt
	function _the_excerpt_length_filter( $default ) {
		global $_the_excerpt_length_filter;

		if( isset($_the_excerpt_length_filter) ) {
			return $_the_excerpt_length_filter;
		}

		return $default;
	}
	// the_excerpt_length( 25 );



    /* Performance tweaks */
    /* Remove Emoji junk by Christine Cooper
     * Found on http://wordpress.stackexchange.com/questions/185577/disable-emojicons-introduced-with-wp-4-2
     */
    function disable_wp_emojicons() {
      // all actions related to emojis
      remove_action( 'admin_print_styles', 'print_emoji_styles' );
      remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
      remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
      remove_action( 'wp_print_styles', 'print_emoji_styles' );
      remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
      remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
      remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
      add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' ); // filter to remove TinyMCE emojis
    }
    add_action( 'init', 'disable_wp_emojicons' );
    function disable_emojicons_tinymce( $plugins ) {
      if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
      } else {
        return array();
      }
    }
    /*
     * control (remove) gravatar
     */
    function bp_remove_gravatar ($image, $params, $item_id, $avatar_dir, $css_id, $html_width, $html_height, $avatar_folder_url, $avatar_folder_dir) {
        $default = home_url().'/wp-includes/images/smilies/icon_cool.gif'; // get_stylesheet_directory_uri() .'/images/avatar.png';
        if( $image && strpos( $image, "gravatar.com" ) ){
            return '<img src="' . $default . '" alt="avatar" class="avatar" ' . $html_width . $html_height . ' />';
        } else {
            return $image;
        }
    }
    add_filter('bp_core_fetch_avatar', 'bp_remove_gravatar', 1, 9 );
    function remove_gravatar ($avatar, $id_or_email, $size, $default, $alt) {
        $default = home_url().'/wp-includes/images/smilies/icon_cool.gif'; // get_stylesheet_directory_uri() .'/images/avatar.png';
        return "<img alt='{$alt}' src='{$default}' class='avatar avatar-{$size} photo avatar-default' height='{$size}' width='{$size}' />";
    }
    add_filter('get_avatar', 'remove_gravatar', 1, 5);
    function bp_remove_signup_gravatar ($image) {
        $default = home_url().'/wp-includes/images/smilies/icon_cool.gif'; //get_stylesheet_directory_uri() .'/images/avatar.png';
        if( $image && strpos( $image, "gravatar.com" ) ){
            return '<img src="' . $default . '" alt="avatar" class="avatar" width="60" height="60" />';
        } else {
            return $image;
        }
    }
    add_filter('bp_get_signup_avatar', 'bp_remove_signup_gravatar', 1, 1 );


?>
