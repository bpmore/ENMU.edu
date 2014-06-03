<?php
/**
 * Template Name: News
 */

//* Reposition the primary navigation menu
//remove_action( 'genesis_after_header', 'genesis_do_nav' );
//add_action( 'genesis_before_header', 'genesis_do_nav' );

//* Unregister secondary navigation menu
//add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'genesis' ) ) );

//* Unregister primary navigation menu
add_theme_support( 'genesis-menus', array( 'secondary' => __( 'Secondary Navigation Menu', 'genesis' ) ) );

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'prefix_do_loop' );

//* Wrap .nav-primary in a custom div
//add_filter( 'genesis_do_nav', 'genesis_child_nav', 10, 3 );
//function genesis_child_nav($nav_output, $nav, $args) {
//
//	return '<div class="nav-primary-wrapper">' . $nav_output . '</div>';
//
//}
//
//* Wrap .nav-secondary in a custom div
//add_filter( 'genesis_do_subnav', 'genesis_child_subnav', 10, 3 );
//function genesis_child_subnav($subnav_output, $subnav, $args) {
//
//	return '<div class="nav-secondary-wrapper">' . $subnav_output . '</div>';
//
//}

function prefix_do_loop() {

	global $paged;

	// accepts any wp_query args
	$args = (array(
		'post_type'      => '',
		'category_name'  => 'news', // use category slug
		'order'          => 'ASC',
		'orderby'       => 'title',
	 	'paged'          => $paged,
	 	'posts_per_page' => 5
	));

	genesis_custom_loop( $args );
}

//* Remove Post Meta from Entry Footer
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

//* Run the Genesis loop
genesis();
