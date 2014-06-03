<?php
/**
 * Template Name: Standard Portfolio
 */

// Force layout to full-width-content
add_filter('genesis_pre_get_option_site_layout', 'themedy_portfolio_layout');
function themedy_portfolio_layout($layout) {
    $layout = 'full-width-content';
    return $layout;
}

// Add .portfolio-teaser class to every post
add_filter('post_class', 'portfolio_post_class');
function portfolio_post_class( $classes ) {
	global $loop_counter;
    
    $classes[] = 'portfolio-teaser one-third';
	if ( $loop_counter == 0 ) {
		$classes[] .= ' first';
    }
	if ( $loop_counter == 2 ) {
        $loop_counter = -1;
    }
	
    return $classes;
}

// Remove Breadcrumbs
remove_action('genesis_before_loop', 'genesis_do_breadcrumbs');

// Remove post info and meta info
remove_action('genesis_after_post_content', 'genesis_post_meta');
remove_action('genesis_before_post_content', 'genesis_post_info');

// Remove default content for this Page Template
remove_action('genesis_before_post_title', 'genesis_do_post_image');
remove_action('genesis_post_content', 'genesis_do_post_content');
remove_action('genesis_post_content', 'the_excerpt');

// Add Featured Image for the portfolio posts in this Page Template
add_action('genesis_post_content', 'themedy_portfolio_do_post_image');
function themedy_portfolio_do_post_image() {
	if (genesis_get_image()) {
		$img = genesis_get_image( array( 'format' => 'html', 'size' => 'portfolio-thumbnail', 'attr' => array( 'class' => 'alignnone' ) ) );
	} else {
		$img = '<img src="'.CHILD_URL.'/images/noimage265x200.png" alt="" />';
	}
    printf( '<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute('echo=0'), $img );
}

// Remove title
remove_action('genesis_post_title', 'genesis_do_post_title');

// New Excerpt Length
add_filter('excerpt_length', 'new_excerpt_length');
function new_excerpt_length($length) {
	return 20;
}

// New Excerpt More
add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more($more) {
	return '...';
}


// Add Content for the Portfolio posts in this Page Template
add_action('genesis_post_content', 'themedy_portfolio_do_post_content');
function themedy_portfolio_do_post_content() { ?> 
    <h2 class="entry-title portfolio-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" ><?php the_title(); ?></a></h2>
    <div class="excerpt"><?php the_excerpt(); ?></div>
<?php
} 

// Clear float using genesis_custom_loop() $loop_counter variable
// Outputs clearing div after every 3 posts
// $loop_counter is incremented after this function is run
add_action('genesis_after_post', 'portfolio_after_post');
function portfolio_after_post() {
    global $loop_counter;
    
    if ( $loop_counter == 2 ) {
        $loop_counter = -1;
        echo '<div class="clear"></div>';
    }
}

// Remove standard loop
remove_action('genesis_loop', 'genesis_do_loop');

// Add custom loop
add_action('genesis_loop', 'portfolio_loop');
function portfolio_loop() {
	global $post;
	$portfolio_category = get_post_meta($post->ID, 'portfolio_category', true);
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        
    $args = array('post_type' => 'portfolio', 'showposts' => 12, 'paged' => $paged, 'portfolio-category' => $portfolio_category);
    $query_args = wp_parse_args($cf, $args);
    
    genesis_custom_loop( $query_args );
}

genesis();