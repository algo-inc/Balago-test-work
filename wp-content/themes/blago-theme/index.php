<?php
get_header();
?>
<main id="primary" class="site-main">

    <?php if (get_the_title()) : ?>
        <div class="container">
            <h1><?php the_title(); ?></h1>
        </div>
    <?php endif; ?>

<!--    --><?php
//    $json_file_path = get_template_directory() . '/content.json';
//    $json_content = file_get_contents($json_file_path);
//    $data = json_decode($json_content, true);
//    echo '<pre>';
//    print_r($data);
//    echo '</pre>';
//    ?>

    <div class="container">
        <?php
        the_content();
        ?>
    </div>
</main>

<?php
get_footer();
?>

