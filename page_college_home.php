<?php
/**
 * Template Name: College Home
 */

add_action( 'wp_enqueue_scripts', 'vtp_enqueue_scripts' );
/**
 * Enqueue Scripts
 */
function vtp_enqueue_scripts() {

	if ( is_active_sidebar( 'sub-home-welcome' ) || is_active_sidebar( 'sub-home-about' ) || is_active_sidebar( 'sub-home-colleges' ) || is_active_sidebar( 'sub-home-services' ) || is_active_sidebar( 'sub-home-news' ) ) {
		wp_enqueue_script( 'scrollTo', get_stylesheet_directory_uri() . '/js/jquery.scrollTo.min.js', array( 'jquery' ), '1.4.5-beta', true );
		wp_enqueue_script( 'localScroll', get_stylesheet_directory_uri() . '/js/jquery.localScroll.min.js', array( 'scrollTo' ), '1.2.8b', true );
		wp_enqueue_script( 'scroll', get_stylesheet_directory_uri() . '/js/scroll.js', array( 'localScroll' ), '', true );
	}
}

add_action( 'genesis_meta', 'vtp_home_genesis_meta' );

//* Unregister primary navigation menu
//add_theme_support( 'genesis-menus', array( 'secondary' => __( 'Secondary Navigation Menu', 'genesis' ) ) );

//* Wrap .nav-primary in a custom div
add_filter( 'genesis_do_nav', 'genesis_child_nav', 10, 3 );
function genesis_child_nav($nav_output, $nav, $args) {

	return '<div class="nav-brand">' . $nav_output . '</div>';

}

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav' );

/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function vtp_home_genesis_meta() {

	if ( is_active_sidebar( 'sub-home-welcome' ) || is_active_sidebar( 'sub-home-about' ) || is_active_sidebar( 'sub-home-colleges' ) || is_active_sidebar( 'sub-home-services' ) || is_active_sidebar( 'sub-info-left' ) || is_active_sidebar( 'sub-info-right' ) || is_active_sidebar( 'sub-home-news' ) ) {

		// Force content-sidebar layout setting
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		// Add vtp-home body class
		add_filter( 'body_class', 'vtp_body_class' );

		// Remove the navigation menus
		//remove_action( 'genesis_after_header', 'genesis_do_nav' );
		//remove_action( 'genesis_after_header', 'genesis_do_subnav' );

		// Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Add homepage widgets
		add_action( 'genesis_loop', 'vtp_homepage_widgets' );

	}

}

function vtp_body_class( $classes ) {

	$classes[] = 'vtp-home';
	return $classes;
	
}

function vtp_homepage_widgets() {

	genesis_widget_area( 'sub-home-slider', array(
		'before' => '<div id="sub-home-slider">',
		'after'  => '</div>',
	) );
	
	genesis_widget_area( 'sub-home-welcome', array(
		'before' => '<div id="welcome"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'sub-home-colleges', array(
		'before' => '<div id="colleges"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'sub-home-services', array(
		'before' => '<div id="services"><div class="wrap">',
		'after'  => '</div></div>',
	) );
		
	if ( is_active_sidebar( 'sub-info-upper-left' ) || is_active_sidebar( 'sub-info-upper-right' ) ) {
		echo '<div class="sub-info-upper"><div class="wrap">';
		
		   genesis_widget_area( 'sub-info-upper-left', array(
		       'before' => '<div class="sub-info-upper-left">',
		       'after'  => '</div>',
		   ) );
	
		   genesis_widget_area( 'sub-info-upper-right', array(
		       'before' => '<div class="sub-info-upper-right">',
		       'after'  => '</div>',
		   ) );
	
		echo '</div><!-- end .wrap --></div><!-- end .sub-footer -->';	
	}

	if ( is_active_sidebar( 'sub-info-lower-left' ) || is_active_sidebar( 'sub-info-lower-right' ) ) {
		echo '<div class="sub-info-lower"><div class="wrap">';
		
		   genesis_widget_area( 'sub-info-lower-left', array(
		       'before' => '<div class="sub-info-lower-left">',
		       'after'  => '</div>',
		   ) );
	
		   genesis_widget_area( 'sub-info-lower-right', array(
		       'before' => '<div class="sub-info-lower-right">',
		       'after'  => '</div>',
		   ) );
	
		echo '</div><!-- end .wrap --></div><!-- end .sub-footer -->';	
	}
	
	genesis_widget_area( 'sub-home-news', array(
		'before' => '<div id="news"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

genesis();
