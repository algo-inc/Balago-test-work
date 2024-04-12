<?php
get_header();
?>
<main id="primary" class="site-main">
    <?php if (get_the_title()) : ?>
        <div class="container">
            <h1><?php the_title(); ?></h1>
        </div>
    <?php endif; ?>
    <?php
    ?>
    <div class="container">
        <?php
        the_content();
        ?>
    </div>
</main>

<?php
get_footer();
?>


