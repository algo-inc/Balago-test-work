<?php
get_header()
?>
    <div class="container">
        <?php
        $project_name = get_field('project_name');
        $project_description = get_field('project_description');
        $start_date = get_field('start_date');
        $status = get_field('status');
        $gallery = get_field('gallery');
        $max_length = 180;
        ?>
        <div class="project-details">

            <h2><?= $project_name ?></h2>
            <div class="card-flex-container">
                <?php
                if ($start_date) {
                    ?>
                    <p class="project-date">Start Date: <?= $start_date ?></p>
                    <?php
                }
                ?>
                <span class="indicator"
                      style="background: <?php echo $status ? 'green' : 'red'; ?>"> <?php echo $status ? 'Виконано' : 'В Процесі'; ?></span>
            </div>
            <?php
            if ($project_description) {
                ?>
                <p><?= $project_description ?></p>
                <?php
            }
            ?>
            <?php
            if ($gallery):
                ?>
            <?php
            endif;
            ?>
        </div>
        <div class="gallery" id="gallery-<?= the_ID(); ?>">
            <?php foreach ($gallery as $image) : ?>
                <?php
                $image_medium = wp_get_attachment_image_src($image['ID'], 'medium')[0];
                $image_large = wp_get_attachment_image_src($image['ID'], 'large')[0];
                ?>
                <a href="<?php echo esc_url($image_large); ?>" class="fancybox" data-fancybox="gallery"
                   data-caption="<?= $image['alt'] ?>">
                    <img class="fancybox" src="<?= $image_large ?>" alt="<?= $image['alt'] ?>">
                </a>
            <?php endforeach; ?>
        </div>

    </div>
    <script>
        Fancybox.bind('[data-fancybox="gallery"]', {});
    </script>

<?php
get_footer()
?>