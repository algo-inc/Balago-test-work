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
    wp_enqueue_style('fancybox-style', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css');

    wp_enqueue_script('fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js', true);
    // wp_enqueue_script( 'custom-theme-script', get_template_directory_uri() . '/js/custom-script.js', array(), '1.0', true );

}
add_action( 'wp_enqueue_scripts', 'blago_theme_scripts' );



// Register Post Types
function custom_project_post_type(): void
{
    $args = array(
        'public' => true,
        'label'  => 'Проекти',
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'menu_icon' => 'dashicons-portfolio',
        'menu_position' => 4,
    );
    register_post_type('project', $args);
}
add_action('init', 'custom_project_post_type');


function custom_team_post_type(): void
{
    $args = array(
        'public' => true,
        'label'  => 'Команда',
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'menu_icon' => 'dashicons-groups',
        'menu_position' => 5,
    );
    register_post_type('team', $args);
}
add_action('init', 'custom_team_post_type');


if ( function_exists('acf_add_local_field_group') ):
    acf_add_local_field_group(array(
        'key' => 'group_661515d4641cc',
        'title' => 'Project fields',
        'fields' => array(
            array(
                'key' => 'field_661515d4b4af1',
                'label' => 'Project name',
                'name' => 'project_name',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_66151638b4af2',
                'label' => 'Project description',
                'name' => 'project_description',
                'aria-label' => '',
                'type' => 'textarea',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'rows' => '',
                'placeholder' => '',
                'new_lines' => '',
            ),
            array(
                'key' => 'field_66151658b4af3',
                'label' => 'Start Date',
                'name' => 'start_date',
                'aria-label' => '',
                'type' => 'date_picker',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'display_format' => 'd/m/Y',
                'return_format' => 'd/m/Y',
                'first_day' => 1,
            ),
            array(
                'key' => 'field_6615168db4af4',
                'label' => 'Status',
                'name' => 'status',
                'aria-label' => '',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
                'ui' => 1,
            ),
            array(
                'key' => 'field_66151737b4af5',
                'label' => 'Gallery',
                'name' => 'gallery',
                'aria-label' => '',
                'type' => 'gallery',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'array',
                'library' => 'all',
                'min' => '',
                'max' => '',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
                'insert' => 'append',
                'preview_size' => 'medium',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'project',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
endif;




