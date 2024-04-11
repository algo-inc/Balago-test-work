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
    if ( is_post_type_archive( 'projects' ) ) {
        wp_enqueue_style( 'archive-projects-style', get_template_directory_uri() . '/style/archive-projects.css' );
    }
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
        'has_archive' => true,
    );
    register_post_type('projects', $args);
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
        'has_archive' => true,
    );
    register_post_type('team', $args);
}
add_action('init', 'custom_team_post_type');


//  ACF Fields
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
                    'value' => 'projects',
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

if ( function_exists('acf_add_local_field_group') ):
    acf_add_local_field_group(array(
        'key' => 'group_66163bb5211fb',
        'title' => 'Team',
        'fields' => array(
            array(
                'key' => 'field_66163bb5cb967',
                'label' => 'Name',
                'name' => 'team-name',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '70',
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
                'key' => 'field_66163bfbcb968',
                'label' => 'Photo',
                'name' => 'photo',
                'aria-label' => '',
                'type' => 'image',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '30',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'url',
                'library' => 'all',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_66164197cb969',
                'label' => 'Position',
                'name' => 'position',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
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
                'key' => 'field_661641abcb96a',
                'label' => 'Linkedin',
                'name' => 'Linkedin',
                'aria-label' => '',
                'type' => 'url',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => 'https://www.linkedin.com/',
                'placeholder' => '',
            ),
            array(
                'key' => 'field_661643cacb96c',
                'label' => 'Email',
                'name' => 'email',
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
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'team',
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


// Create shortcode
function display_projects_shortcode($atts): string
{
    $atts = shortcode_atts( array(
        'block_title' => 'Проекти',
        'projects_count' => -1,
    ), $atts );

    $archive_link = get_post_type_archive_link( 'projects' );
    $projects_query = new WP_Query(array(
        'post_type' => 'projects',
        'posts_per_page' => $atts['projects_count'],
    ));
    ob_start();
    echo '<section class="projects-container">';
    echo  '<div class="flex-container">';
    echo '<h2 class="projects-title">' . esc_html($atts['block_title']) . '</h2>';
    if ( $archive_link ) {
        echo '<a class="archive-link" href="' . esc_url( $archive_link ) . '"> Всі проекти </a>';
    }
    echo '</div>';
    if ($projects_query->have_posts()) {
        echo '<div class="projects">';
        while ($projects_query->have_posts()) {
            $projects_query->the_post();
            get_template_part('template-parts/project-card', 'project-card');
            echo '<script>Fancybox.bind(document.getElementById("gallery-' . get_the_ID() . '"), "[data-fancybox]", {});</script>';
        }
        echo '</div>';


    } else {
        echo '<p>Записів не знайдено.</p>';
    }
    echo '</section>';
    return ob_get_clean();
}
add_shortcode('display_projects', 'display_projects_shortcode');



function display_team_shortcode($atts): string
{
    $atts = shortcode_atts( array(
        'block_title' => 'Команда',
    ), $atts );

    $team_query = new WP_Query(array(
        'post_type' => 'team',
        'posts_per_page' => -1,
    ));

    ob_start();
    echo '<h2 class="team-title">' . esc_html($atts['block_title']) . '</h2>';
    if ($team_query->have_posts()) {
        echo '<div class="team">';
        while ($team_query->have_posts()) {
            $team_query->the_post();
            get_template_part('template-parts/team-member-card', 'team-member-card');
        }
        echo '</div>';
    } else {
        echo '<p>Учасників команди не знайдено.</p>';
    }
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('display_team', 'display_team_shortcode');

require_once get_template_directory() . '/theme-innit.php';



function export_projects_to_json() {
    $args = array(
        'post_type' => 'projects',
        'posts_per_page' => -1, // Вибрати всі проекти
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $projects_data = array();

        while ($query->have_posts()) {
            $query->the_post();

            $project_data = array(
                'title' => get_the_title(),
                'content' => get_the_content(),
                'project_name' => get_post_meta(get_the_ID(), 'project_name', true),
                'project_description' => get_post_meta(get_the_ID(), 'project_description', true),
                'start_date' => get_post_meta(get_the_ID(), 'start_date', true),
                'status' => (bool)get_post_meta(get_the_ID(), 'status', true),
                'gallery' => array()
            );

            $gallery_images = get_post_meta(get_the_ID(), 'gallery', true);
            if ($gallery_images) {
                foreach ($gallery_images as $image_id) {
                    $image = array(
                        'title' => get_the_title($image_id),
                        'filename' => basename(get_attached_file($image_id)),
                        'alt' => get_post_meta($image_id, '_wp_attachment_image_alt', true),
                        'description' => get_post_field('post_content', $image_id),
                        'sizes' => array(
                            'thumbnail' => wp_get_attachment_image_src($image_id, 'thumbnail')[0],
                            'medium' => wp_get_attachment_image_src($image_id, 'medium')[0],
                            'large' => wp_get_attachment_image_src($image_id, 'large')[0]
                        )
                    );
                    $project_data['gallery'][] = $image;
                }
            }

            $projects_data[] = $project_data;
        }

        wp_reset_postdata();

        $json_data = json_encode($projects_data, JSON_PRETTY_PRINT);

        $json_file_path = get_template_directory() . '/projects.json';
        file_put_contents($json_file_path, $json_data);

        echo 'JSON файл успішно створено!';
    }
}
//export_projects_to_json();