<?php
/**
 * Template Name: News Alt
 */
 
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
/**
 * Rearranges layout of Posts in Posts page
 *
 * @author Sridhar Katakam
 * @link   http://sridharkatakam.com/fastcompany-com-inspired-layout-posts-page-genesis/
 */

//* Remove Featured image from Entry Content
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

//* Show Featured image above Entry Header
add_action( 'genesis_entry_header', 'sk_do_post_image', 4 );
function sk_do_post_image() {
	$image_args = array(
		'size' => 'news-featured-image'
	);

	echo '<div class="news-featured-image"><a href="' . get_permalink() . '">' . genesis_get_image( $image_args ) . '</a></div>';

}

//* Show Post Meta above Entry Header
//add_action( 'genesis_entry_header', 'genesis_post_meta', 4 );

//* Customize Post Meta
//add_filter( 'genesis_post_meta', 'sp1_post_meta_filter' );
//function sp1_post_meta_filter($post_meta) {
//	$post_meta = '[post_categories before="Filed Under: "] [post_tags before="| Tagged With: "]';
//	return $post_meta;
//}

//* Remove Post Info from Entry Header. Appears below Post Title
//remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

//* Add 'one-half' class to Entry Header so that Post Title appears left
add_filter( 'genesis_attr_entry-header', 'sk_genesis_attributes_entry_header' );
/**
 * Add attributes for entry header element.
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function sk_genesis_attributes_entry_header( $attributes ) {

	$attributes['class'] = 'entry-header one-half first';

	return $attributes;

}

//* Add 'one-half' class to Entry Content so that Excerpt appears right
add_filter( 'genesis_attr_entry-content', 'sk_genesis_attributes_entry_content' );
/**
 * Add attributes for entry content element.
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function sk_genesis_attributes_entry_content( $attributes ) {

	$attributes['class'] = 'entry-content one-half';

	return $attributes;

}

//* Force excerpt
add_filter( 'genesis_pre_get_option_content_archive', 'sk_show_excerpts' );
function sk_show_excerpts() {
	return 'excerpts';
}

//* Remove Post Meta from Entry Footer
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

//* Show Post Info in Entry Footer in left half
//add_action( 'genesis_entry_footer', 'sk_post_info' );
//function sk_post_info() {
//	echo '<div class="one-half first">';
//		genesis_post_info();
//	echo '</div>';
//}

//* Remove Jetpack sharing buttons from below excerpts
remove_filter( 'the_excerpt', 'sharing_display', 19 );

//* Show Jetpack sharing buttons in Entry Footer in right half
add_action( 'genesis_entry_footer', 'sk_social_sharing_buttons' );
function sk_social_sharing_buttons() {
	if ( function_exists( 'sharing_display' ) ) {
		echo '<div class="one-half">'. sharing_display() . '</div>';
	}
}

//* Modify the Excerpt read more link
add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more($more) {
	return '<p><a class="more-link" href="' . get_permalink() . '">Read More »</a></p>';
}

genesis();