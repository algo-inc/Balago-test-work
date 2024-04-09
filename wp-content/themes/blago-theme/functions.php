<?php
function blago_theme_setup(): void
{
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'custom-theme' ),
        'footer' => esc_html__( 'Footer Menu', 'custom-theme' )
    ) );
}
add_action( 'after_setup_theme', 'blago_theme_setup' );

function blago_theme_scripts(): void
{
    wp_enqueue_style( 'blago-theme-style', get_stylesheet_uri() );

    // wp_enqueue_script( 'custom-theme-script', get_template_directory_uri() . '/js/custom-script.js', array(), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'blago_theme_scripts' );


