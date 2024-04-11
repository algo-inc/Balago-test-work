<?php
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');


function moveToTmp($file)
{
    $tmp_folder = sys_get_temp_dir();
    $destination_file = $tmp_folder . DIRECTORY_SEPARATOR . wp_basename($file);
    copy($file, $destination_file);
    return basename($file);
}

function add_image_to_media_library($filename)
{
    $contents = file_get_contents($filename);

    $upload = wp_upload_bits(basename($filename), null, $contents);
    $type = '';
    if (!empty($upload['type'])) {
        $type = $upload['type'];
    } else {
        $mime = wp_check_filetype($upload['file']);
        if ($mime)
            $type = $mime['type'];
    }

    $attachment = array(
        'post_title' => basename($upload['file']),
        'post_content' => '',
        'post_type' => 'attachment',
        'post_parent' => 0,
        'post_mime_type' => $type,
        'guid' => $upload['url'],
    );

    // Save the data
    $id = wp_insert_attachment($attachment, $upload['file'], 0);
    wp_update_attachment_metadata($id, wp_generate_attachment_metadata($id, $upload['file']));

    return $id;

}




function handle_user_choice(): void
{
    if (isset($_POST['create_posts_yes'])) {
        create_projects_from_json();
//        create_team_from_json();
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
function show_create_posts_notice(): void
{
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


function create_projects_from_json(): void
{
    $json_file_path = get_template_directory() . '/projects.json';
    $json_data = file_get_contents($json_file_path);
    $projects_data = json_decode($json_data, true);

    $base_url = home_url();


    if ($projects_data) {
        foreach ($projects_data as $project) {
            $post_data = [
                'post_title' => $project['title'],
                'post_content' => $project['content'],
                'post_status' => 'publish',
                'post_type' => 'projects',
                'meta_input' => [
                    'project_name' => $project['project_name'],
                    'project_description' => $project['project_description'],
                    'start_date' => $project['start_date'],
                    'status' => $project['status'],
                    'gallery' => $project['gallery'],
                ],
            ];

            $galleryIds = [];
            foreach ($project['gallery'] as $galleryItem) {
                $path = __DIR__ . '/content/gallery/' . $galleryItem['filename'];

                $galleryIds[] = add_image_to_media_library($path);

            }
            $post_id = wp_insert_post($post_data);

            update_field('gallery', $galleryIds, $post_id);
            break;
        }
    }
}


function create_team_from_json(): void
{
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





