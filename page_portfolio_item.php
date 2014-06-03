<?php
// Add post class to every portfolio item (for default styling)
add_filter('post_class', 'portfolio_post_class');
function portfolio_post_class( $classes ) {
    $classes[] = 'post';
    return $classes;
}

// Remove Breadcrumbs
remove_action('genesis_before_loop', 'genesis_do_breadcrumbs');

// Remove post info and meta info
remove_action('genesis_after_post_content', 'genesis_post_meta');
remove_action('genesis_before_post_content', 'genesis_post_info');

// Remove default content for this Page Template

genesis();