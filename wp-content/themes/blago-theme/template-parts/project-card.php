<?php
$project_name = get_field('project_name');
$project_description = get_field('project_description');
$start_date = get_field('start_date');
$status = get_field('status');
$gallery = get_field('gallery');
?>
<div class="project-details" >
    <h2><?= $project_name ?></h2>
    <p><?= $project_description ?></p>
    <p>Start Date: <?= $start_date ?></p>
    <p>Status: <?php echo $status ? 'Active' : 'Inactive'; ?></p>
    <div  class="gallery" id="gallery-<?=the_ID();?>">
        <?php foreach ($gallery as $image) : ?>
            <?php
            $image_medium = wp_get_attachment_image_src($image['ID'], 'medium')[0];
            $image_large = wp_get_attachment_image_src($image['ID'], 'large')[0];
            ?>
            <a href="<?php echo esc_url($image_large); ?>" class="fancybox" data-fancybox="gallery" data-caption="<?php echo esc_attr($image['alt']); ?>">
                <img class="fancybox" src="<?= $image_medium ?>" alt="<?php echo esc_attr($image['alt']); ?>">
            </a>
        <?php endforeach; ?>
    </div>
</div>

