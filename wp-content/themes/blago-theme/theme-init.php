<?php
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once ABSPATH . 'wp-admin/includes/plugin.php';
require_once ABSPATH . 'wp-admin/includes/misc.php';
require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
require_once __DIR__ . '/class-tgm-plugin-activation.php';


add_action('tgmpa_register', 'blago_register_required_plugins');

/**
 * Register the required plugins for this theme.
 *
 *  <snip />
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function blago_register_required_plugins()
{

    $plugins = array(
        array(
            'name' => 'ACF Pro', // The plugin name.
            'slug' => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name).
            'source' => __DIR__ . '/plugins/advanced-custom-fields-pro.zip', // The plugin source.
            'required' => true, // If false, the plugin is only 'recommended' instead of required.
            'version' => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation' => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url' => '', // If set, overrides default API URL and points to an external URL.
            'is_callable' => '',
        ),
    );

    $config = array(
        'id' => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu' => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug' => 'themes.php',            // Parent menu slug.
        'capability' => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices' => true,                    // Show admin notices or not.
        'dismissable' => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg' => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message' => '',                      // Message to output right before the plugins table.
        /*
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'theme-slug' ),
            'menu_title'                      => __( 'Install Plugins', 'theme-slug' ),
            // <snip>...</snip>
            'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
        */
    );

    tgmpa($plugins, $config);

}


function add_image_to_media_library($filename): int
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
    $id = wp_insert_attachment($attachment, $upload['file'], 0);
    wp_update_attachment_metadata($id, wp_generate_attachment_metadata($id, $upload['file']));
    return $id;
}


function handle_user_choice(): void
{
    if (isset($_POST['create_posts_yes'])) {
        create_home_page_from_json();
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
function show_create_posts_notice(): void
{
    if (get_option('user_choice_made') === 'yes' || !is_plugin_active('advanced-custom-fields-pro/acf.php')) {
        return;
    }
    echo '<div class="notice notice-success is-dismissible" style="padding: 10px">';
    echo '<p><strong>' . __('Створити публікації для презентації?', 'text_domain') . '</strong></p>';
    echo '<p>' . __('Це допоможе вам почати роботу з вашим проектом швидше.', 'text_domain') . '</p>';
    echo '<form method="post" action="/wp-admin/index.php" style="display: flex; gap: 20px;">';
    echo '<input type="submit" class="button button-primary" name="create_posts_yes" value="' . __('Так', 'text_domain') . '">';
    echo '<input type="submit" class="button" name="create_posts_no" value="' . __('Ні', 'text_domain') . '">';
    echo '</form>';
    echo '</div>';
}
add_action('admin_notices', 'show_create_posts_notice');


function create_projects_from_json(): void
{
    $json_file_path = get_template_directory() . '/projects.json';
    $json_data = file_get_contents($json_file_path);
    $projects_data = json_decode($json_data, true);

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

            if (!empty($galleryIds[0])) {
                set_post_thumbnail($post_id, $galleryIds[0]);
            }
            update_field('gallery', $galleryIds, $post_id);
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
            $image_url_parts = explode('/', $member['photo']);
            $image_file_name = end($image_url_parts);

            $photo_id = add_image_to_media_library(__DIR__ . '/content/team/' . $image_file_name);

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
            if (!empty($photo_id)) {
                set_post_thumbnail($post_id, $photo_id);
            }
            update_field('photo', $photo_id, $post_id);
        }
    }
}


function create_home_page_from_json(): void
{
    $json_file_path = get_template_directory() . '/home.json';
    $json_data = file_get_contents($json_file_path);
    $home_data = json_decode($json_data, true);
    if ($home_data) {
        $page_data = $home_data[0];
        $post_data = [
            'ID' => $page_data['ID'],
            'post_title' => $page_data['post_title'],
            'post_content' => $page_data['post_content'],
            'post_status' => 'publish',
            'post_type' => 'page',
            'page_template' => 'front-page.php',
        ];
        $post_id = wp_insert_post($post_data);
        update_option('page_on_front', $post_id);
        update_option('show_on_front', 'page');
    } else {
        echo 'Не вдалося декодувати JSON-файл.';
    }
}
