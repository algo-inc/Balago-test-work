<?php
$project_name = get_field('project_name');
$project_description = get_field('project_description');
$start_date = get_field('start_date');
$status = get_field('status');
$gallery = get_field('gallery');
echo '<pre>';
print_r($gallery);
echo '</pre>';

$max_length = 180;
?>
<div class="project-details">
    <a href="<?php the_permalink(); ?>">
    <h2><?= $project_name ?></h2>
    <div class="flex-container">
        <?php
        if ($start_date) {
            ?>
            <p class="project-date">Start Date: <?= $start_date ?></p>
            <?php
            }
        ?>
        <span class="indicator" style="background: <?php echo $status ? 'green' : 'red'; ?>"> <?php echo $status ? 'Active' : 'Inactive'; ?></span>
    </div>
    <p><?php
        if (strlen($project_description) > $max_length) {
          echo  $project_description = substr($project_description, 0, $max_length) . '...';
        }
        ?></p>
    <?php
    if ($gallery):
    ?>
    </a>
    <div class="gallery" id="gallery-<?= the_ID(); ?>">
        <?php $counter = 0;
        
        ?>
        
        <?php foreach ($gallery as $image) : ?>
            <?php
            $image_medium = wp_get_attachment_image_src($image['ID'], 'medium')[0];
            $image_large = wp_get_attachment_image_src($image['ID'], 'large')[0];
            ?>
            <a href="<?php echo esc_url($image_large); ?>" class="fancybox" data-fancybox="gallery"
               data-caption="<?= $image['alt'] ?>">
                <img class="fancybox" src="<?= $image_medium ?>" alt="<?= $image['alt'] ?>">
            </a>
            <?php $counter++; ?>
            <?php if ($counter >= 3) break; ?>
        <?php endforeach; ?>
    </div>
    <?php
    endif;
    ?>
</div>

