<?php
$project_name = get_field('project_name');
$project_description = get_field('project_description');
$start_date = get_field('start_date');
$status = get_field('status');
$gallery = get_field('gallery');
$max_length = 180;
?>
<div class="project-details">
    <a href="<?php the_permalink(); ?>">
        <h2><?= $project_name ?></h2>

        <div class="card-flex-container">
            <?php
            if ($start_date) {

                ?>
                <p class="project-date">Start Date: <?= $start_date ?></p>
                <?php
            }
            ?>
            <span class="indicator"  style="background: <?php echo $status ? 'green' : 'red'; ?>" data-status="<?= $status ?>"> <?php echo $status ? 'Active' : 'Inactive'; ?></span>
        </div>
        <p><?php
            if (strlen($project_description) > $max_length) {
                echo $project_description = substr($project_description, 0, $max_length) . '...';
            }
            ?></p>

    </a>

</div>

