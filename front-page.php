<?php
/**
 * Controls the homepage output.
 */

add_action( 'wp_enqueue_scripts', 'vtp_enqueue_scripts' );
/**
 * Enqueue Scripts
 */
function vtp_enqueue_scripts() {

	if ( is_active_sidebar( 'home-welcome' ) || is_active_sidebar( 'home-about' ) || is_active_sidebar( 'home-colleges' ) || is_active_sidebar( 'home-services' ) || is_active_sidebar( 'home-news' ) ) {
		wp_enqueue_script( 'scrollTo', get_stylesheet_directory_uri() . '/js/jquery.scrollTo.min.js', array( 'jquery' ), '1.4.5-beta', true );
		wp_enqueue_script( 'localScroll', get_stylesheet_directory_uri() . '/js/jquery.localScroll.min.js', array( 'scrollTo' ), '1.2.8b', true );
		wp_enqueue_script( 'scroll', get_stylesheet_directory_uri() . '/js/scroll.js', array( 'localScroll' ), '', true );
	}
}

add_action( 'genesis_meta', 'vtp_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function vtp_home_genesis_meta() {

	if ( is_active_sidebar( 'home-welcome' ) || is_active_sidebar( 'home-about' ) || is_active_sidebar( 'home-colleges' ) || is_active_sidebar( 'home-services' ) || is_active_sidebar( 'home-info-left' ) || is_active_sidebar( 'home-info-right' ) || is_active_sidebar( 'home-news' ) ) {

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

	genesis_widget_area( 'home-slider', array(
		'before' => '<div id="home-slider">',
		'after'  => '</div>',
	) );
	
	genesis_widget_area( 'home-welcome', array(
		'before' => '<div id="welcome"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-about', array(
		'before' => '<div id="about"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-colleges', array(
		'before' => '<div id="colleges"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-services', array(
		'before' => '<div id="services"><div class="wrap">',
		'after'  => '</div></div>',
	) );
		
	if ( is_active_sidebar( 'home-info-left' ) || is_active_sidebar( 'home-info-right' ) ) {
		echo '<div class="home-info"><div class="wrap">';
		
		   genesis_widget_area( 'home-info-left', array(
		       'before' => '<div class="home-info-left">',
		       'after'  => '</div>',
		   ) );
	
		   genesis_widget_area( 'home-info-right', array(
		       'before' => '<div class="home-info-right">',
		       'after'  => '</div>',
		   ) );
	
		echo '</div><!-- end .wrap --></div><!-- end .sub-footer -->';	
	}

	genesis_widget_area( 'home-news', array(
		'before' => '<div id="news"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

genesis();
