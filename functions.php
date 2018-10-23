<?php

function vwsg_styles()
{
    wp_enqueue_style('fontawesome', 'https://use.fontawesome.com/releases/v5.4.1/css/all.css');
    wp_enqueue_style('fonts', 'https://fonts.googleapis.com/css?family=Julius+Sans+One|Open+Sans:300,400,700', []);
    wp_enqueue_style('bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', [], '3.3.7');
    wp_enqueue_style('vwsg-style', get_stylesheet_uri(), ['bootstrap-css', 'fonts', 'fontawesome'], '1.0.0');
}

function vwsg_scripts()
{
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.3.1.min.js', [], '3.3.1');
}

add_action('wp_enqueue_scripts', 'vwsg_styles');
add_action('wp_enqueue_scripts', 'vwsg_scripts');

function vwsg_setup()
{
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    add_theme_support('title-tag');

    register_nav_menu('top-menu', __('Top Menu'));
}

add_action('after_setup_theme', 'vwsg_setup');

// Remove wordpress generator meta
add_filter('the_generator', function() { return ''; });
remove_action('wp_head', 'wp_generator');

function add_categories_for_attachments() {
    register_taxonomy_for_object_type( 'category', 'attachment' );
}
add_action( 'init' , 'add_categories_for_attachments' );

// add tags for attachments
function add_tags_for_attachments() {
    register_taxonomy_for_object_type( 'post_tag', 'attachment' );
}
add_action( 'init' , 'add_tags_for_attachments' );