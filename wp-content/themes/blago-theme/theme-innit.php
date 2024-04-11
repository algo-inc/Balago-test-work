<?php
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');




function upload_images_to_media_library(): void {

    $upload_dir = wp_upload_dir();
    $upload_path = $upload_dir['basedir'];
    $images_folder_path = get_template_directory() . '/content/images/';

    $image_files = glob($images_folder_path . '*.{jpg,jpeg,png,webp}', GLOB_BRACE);

    $image_ids = [];

    foreach ($image_files as $image_file) {
        $image_file_name = basename($image_file);
        $image_file_path = $upload_path . '/content/' . $image_file_name;
        if (file_exists($image_file_path)) {
            continue;
        }
        $temp_image = tempnam(sys_get_temp_dir(), 'img_');
        copy($image_file, $temp_image);

        $file_array = [
            'name' => basename($image_file),
            'tmp_name' => $temp_image,
        ];
        $attachment_id = media_handle_sideload($file_array, 0);
        if (!is_wp_error($attachment_id)) {
            $image_ids[] = $attachment_id;
        }
    }

    if (!empty($image_ids)) {
        update_option('theme_image_ids', $image_ids);
    }
}



function handle_user_choice() {
    if (isset($_POST['create_posts_yes'])) {
        upload_images_to_media_library();
        create_projects_from_json();
        create_team_from_json();

        update_option('user_choice_made', 'yes');
    } elseif (isset($_POST['create_posts_no'])) {
        update_option('user_choice_made', 'yes');
    }
}
add_action('admin_init', 'handle_user_choice');

function reset_option_on_switch_theme(): void
{
    update_option('user_choice_made', 'no');
}



add_action('switch_theme', 'reset_option_on_switch_theme');
add_action('after_switch_theme', 'reset_option_on_switch_theme');
function show_create_posts_notice() {
    if (get_option('user_choice_made') === 'yes') {
        return;
    }
    echo '<div class="notice notice-success is-dismissible">';
    echo '<p>' . __('Would you like to create posts from the JSON file?', 'text_domain') . '</p>';
    echo '<form method="post">';
    echo '<input type="submit" class="button button-primary" name="create_posts_yes" value="' . __('Yes', 'text_domain') . '">';
    echo '<input type="submit" class="button" name="create_posts_no" value="' . __('No', 'text_domain') . '">';
    echo '</form>';
    echo '</div>';
}
add_action('admin_notices', 'show_create_posts_notice');




function create_projects_from_json(): void {
    $image_ids = get_option('theme_image_ids');
    if (empty($image_ids)) {
        return;
    }

    $json_file_path = get_template_directory() . '/projects.json';
    $json_data = file_get_contents($json_file_path);
    $projects_data = json_decode($json_data, true);

    if ($projects_data) {
        foreach ($projects_data as $project) {
            $post_data = [
                'post_title'    => $project['title'],
                'post_content'  => $project['content'],
                'post_status'   => 'publish',
                'post_type'     => 'projects',
                'meta_input'    => [
                    'project_name' => $project['project_name'],
                    'project_description' => $project['project_description'],
                    'start_date' => $project['start_date'],
                    'status' => $project['status'],

                ],
            ];
            $post_id = wp_insert_post($post_data);
            $random_image_id = $image_ids[array_rand($image_ids)];
            set_post_thumbnail($post_id, $random_image_id);
        }
    }
}


function create_team_from_json(): void {
    $json_file_path = get_template_directory() . '/team.json';
    $json_data = file_get_contents($json_file_path);
    $team_data = json_decode($json_data, true);
    if ($team_data) {
        foreach ($team_data as $member) {
            $post_data = [
                'post_title' => $member['name'],
                'post_content' => $member['content'],
                'post_status' => 'publish',
                'post_type' => 'team',
                'meta_input' => [
                    'team-name' => $member['name'],
                    'photo' => $member['photo'],
                    'position' => $member['position'],
                    'linkedin' => $member['linkedin'],
                    'email' => $member['email'],
                ],
            ];
            $post_id = wp_insert_post($post_data);
            if (!empty($member['photo'])) {
                // Ви можете використовувати функцію додавання зображень до постів
                // Наприклад, set_post_thumbnail($post_id, $image_id);
            }
        }
    }
}





