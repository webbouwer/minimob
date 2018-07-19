<?php

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
			'uppermenu' => __( 'Upper menu' , 'minimob' ),
			'topmenu' => __( 'Top menu' , 'minimob' ),
			'sidemenu' => __( 'Side menu' , 'minimob' ),
			'footermenu' => __( 'Footer menu' , 'minimob' )
			)
		);
	}
	add_action( 'init', 'minimob_setup_register_menus' );


	/*
	 * Editor style WP THEME STANDARD
	 */
	function minimob_editor_styles() {
		add_editor_style( 'style.css' );
		//add_editor_style( get_theme_mod('onepiece_identity_stylelayout_stylesheet', 'default.css') );
	}
	add_action( 'admin_init', 'minimob_editor_styles' );


	/* JQuery init */
	function minimob_frontend_jquery() {
		wp_enqueue_script('jquery');
	}
	add_action( 'init', 'minimob_frontend_jquery' );

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
		printf( _x( '%s '.__('geleden','minimob'), '%s = human-readable time difference', 'minimob' ), human_time_diff( $t, current_time( 'timestamp' ) ) );
	}
?>
