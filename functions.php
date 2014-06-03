<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'vtp', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'vtp' ) );


//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Victory Pro Theme', 'vtp' ) );
define( 'CHILD_THEME_URL', 'http://enmu.edu/' );
define( 'CHILD_THEME_VERSION', '2.0.0' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue Lato and Merriweather Google fonts
add_action( 'wp_enqueue_scripts', 'vtp_google_fonts' );
function vtp_google_fonts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400|Merriweather:400,300|Ubuntu:300,400,700|Oswald:300,400|Oxygen:300,400|Source+Sans+Pro:300,400,700', array(), CHILD_THEME_VERSION );
	
}

//* Enqueue Responsive Menu Script
add_action( 'wp_enqueue_scripts', 'vtp_enqueue_responsive_script' );
function vtp_enqueue_responsive_script() {

	wp_enqueue_script( 'vtp-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );

}

//* Add new image sizes
add_image_size( 'news', 340, 140, TRUE );
add_image_size( 'colleges', 340, 230, TRUE );
add_image_size( 'slider', 1024, 512, TRUE );
add_image_size( 'news-featured-image', 750, 340, true );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'header_image'    => '',
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 72,
	'width'           => 300,
) );

//* Add support for additional color style options
add_theme_support( 'genesis-style-selector', array(
	'victory-pro-green'   => __( 'Green Header', 'vtp' ),
	'victory-pro-green-white' => __( 'Green Header - White Text', 'vtp' ),
	'victory-pro-red'    => __( 'Victory Pro Red', 'vtp' ),
	'victory-pro-purple' => __( 'Victory Pro Purple', 'vtp' ),
) );

//* Add Featured Image to Page and Post Below Title
add_action( 'genesis_entry_header', 'single_post_featured_image', 15 );

function single_post_featured_image() {
	
	if ( ! is_singular( 'post' ) )
		return;
	
	$img = genesis_get_image( array( 'format' => 'html', 'size' => genesis_get_option( 'image_size' ), 'attr' => array( 'class' => 'post-image' ) ) );
	printf( '<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), $img );
	
}

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Add metabox for site initial option
add_action( 'genesis_theme_settings_metaboxes', 'vtp_theme_settings_metaboxes', 10, 1 );
function vtp_theme_settings_metaboxes( $pagehook ) {

    add_meta_box( 'vtp-custom-initial', __( 'Victory - Site initial', 'vtp' ), 'vtp_custom_initial_metabox', $pagehook, 'main', 'high' );

}

//* Content for the site initial metabox
function vtp_custom_initial_metabox() {

    $val = ( $opt = genesis_get_option( 'vtp_custom_initial' ) ) ? $opt[0] : '';

    printf( '<p><label for="%s[%s]" />' . __( 'Enter custom site initial:', 'vtp') . '<br />', GENESIS_SETTINGS_FIELD, 'vtp_custom_initial' );
    printf( '<input type="text" name="%1$s[%2$s]" id="%1$s[%1$s]" size="6" value="%3$s" /></p>', GENESIS_SETTINGS_FIELD, 'vtp_custom_initial', $val );
    printf( '<p><span class="description">' . __( 'This will be displayed beside the site title and is limited to 1 character', 'vtp') . '</span></p>' );

}

//* Add custom site initial CSS
add_action( 'wp_enqueue_scripts', 'victory_set_icon' );
function victory_set_icon() {

    $handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

    $icon = genesis_get_option( 'vtp_custom_initial' );

    if( empty( $icon ) || get_header_image() )
        return;

    $css = sprintf( '.site-title a::before{ content: \'%s\'; }', $icon[0] );

    wp_add_inline_style( $handle, $css );

}

//* Hook after post widget after the entry content
add_action( 'genesis_after_entry', 'vtp_after_entry', 5 );
function vtp_after_entry() {

	if ( is_singular( 'post' ) )
		genesis_widget_area( 'after-entry', array(
			'before' => '<div class="after-entry widget-area">',
			'after'  => '</div>',
		) );

}

//* Modify the size of the Gravatar in author box
add_filter( 'genesis_author_box_gravatar_size', 'vtp_author_box_gravatar_size' );
function vtp_author_box_gravatar_size( $size ) {

	return 80;
	
}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'vtp_remove_comment_form_allowed_tags' );
function vtp_remove_comment_form_allowed_tags( $defaults ) {
	
	$defaults['comment_notes_after'] = '';
	return $defaults;

}

add_filter( 'genesis_post_info', 'remove_post_info_exclude_news_category' );
/**
* @author Brad Dalton
* @link http://wpsites.net/web-design/modify-post-info-genesis
*/
function remove_post_info_exclude_news_category($post_info) {
if ( in_category('news') ) { 
	$post_info = '[post_date] by [post_author_posts_link] [post_comments] [post_edit]';
	return $post_info;
}
   }
   
//* Customize the entry meta in the entry footer
add_filter( 'genesis_post_meta', 'sp_post_meta_filter' );
function sp_post_meta_filter($post_meta) {
	$post_meta = '[post_categories before="Filed Under: "] [post_tags before="Tagged: "]';
	return $post_meta;
}

//* Add walker class that displays menu item descriptions
// class Menu_With_Description extends Walker_Nav_Menu {
// 	function start_el(&$output, $item, $depth, $args) {
// 		global $wp_query;
// 		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
//  
// 		$class_names = $value = '';
//  
// 		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
//  
// 		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', // array_filter( $classes ), $item ) );
// 		$class_names = ' class="' . esc_attr( $class_names ) . '"';
//  
// 		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
//  
// 		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
// 		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
// 		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
// 		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';
//  
// 		$item_output = $args->before;
// 		$item_output .= '<a'. $attributes .'>';
// 		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
// 		$item_output .= '<br /><span class="sub">' . $item->description . '</span>';
// 		$item_output .= '</a>';
// 		$item_output .= $args->after;
//  
// 		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
// 	}
// }
//  
//* Pass custom walker that includes menu descriptions
// function sk_primary_menu_args( $args ) {
//  
// 	if( 'primary' == $args['theme_location'] ) {
// 		$walker = new Menu_With_Description;
// 		$args['walker'] = $walker;
// 	}
//  
// 	return $args;
//  
// }
// add_filter( 'wp_nav_menu_args', 'sk_primary_menu_args' );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-slider',
	'name'        => __( 'Home - Slider','vtp' ),
	'description' => __( 'This is the slider section of the homepage.','vtp' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-welcome',
	'name'        => __( 'Home - Welcome','vtp' ),
	'description' => __( 'This is the welcome section of the homepage.','vtp' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-about',
	'name'        => __( 'Home - About','vtp' ),
	'description' => __( 'This is the about section of the homepage.','vtp' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-top-news',
	'name'        => __( 'Home Top (News Row)', 'vtp' ),
	'description' => __( 'Widget area for the Home Top (News) row.', 'vtp' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-colleges',
	'name'        => __( 'Home - Colleges','vtp' ),
	'description' => __( 'This is the colleges section of the homepage.','vtp' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-services',
	'name'        => __( 'Home - Services','vtp' ),
	'description' => __( 'This is the Services section of the homepage.','vtp' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-news',
	'name'        => __( 'Home - News','vtp' ),
	'description' => __( 'This is the News section of the homepage.','vtp' ),
) );
genesis_register_sidebar( array(
	'id'          => 'after-entry',
	'name'        => __( 'After Entry', 'vtp' ),
	'description' => __( 'This is the after entry widget area.', 'vtp' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-info-left',
	'name'        => __( 'Home Info - Left', 'vtp' ),
	'description' => __( 'This is the left section of the info area.', 'vtp' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-info-right',
	'name'        => __( 'Home Info - Right', 'vtp' ),
	'description' => __( 'This is the right section of the info area.', 'vtp' ),
) );
genesis_register_sidebar( array(
	'id'          => 'news-menu',
	'name'        => __( 'News - Menu','vtp' ),
	'description' => __( 'This is the menu section for the News template.','vtp' ),
) );
genesis_register_sidebar( array(
	'id' => 'sales-cta-overlay',
	'name' => __( 'Promo Page CTA', 'cegg' ),
	'description'	=> __( 'Widgets placed here will appear on top of promo page background image.', 'cegg' ),
) );
genesis_register_sidebar( array(
	'id'          => 'sub-home-slider',
	'name'        => __( 'Sub Home Slider','vtp' ),
	'description' => __( 'This is the slider section of the alternative homepage template.','vtp' ),
) );
genesis_register_sidebar( array(
	'id'          => 'sub-home-colleges',
	'name'        => __( 'Sub Home Main','vtp' ),
	'description' => __( 'This is the main widget area for the alternative homepage template.','vtp' ),
) );
genesis_register_sidebar( array(
	'id'          => 'sub-info-upper-left',
	'name'        => __( 'Sub Info Upper - Left', 'vtp' ),
	'description' => __( 'This is the upper left (news) section of the alternative homepage template.', 'vtp' ),
) );
genesis_register_sidebar( array(
	'id'          => 'sub-info-upper-right',
	'name'        => __( 'Sub Info Upper - Right', 'vtp' ),
	'description' => __( 'This is the upper right (calendar) section of the alternative homepage template.', 'vtp' ),
) );
genesis_register_sidebar( array(
	'id'          => 'sub-info-lower-left',
	'name'        => __( 'Sub Info Lower - Left', 'vtp' ),
	'description' => __( 'This is the lower left (news) section of the alternative homepage template.', 'vtp' ),
) );
genesis_register_sidebar( array(
	'id'          => 'sub-info-lower-right',
	'name'        => __( 'Sub Info Lower - Right', 'vtp' ),
	'description' => __( 'This is the lower right (calendar) section of the alternative homepage template.', 'vtp' ),
) );