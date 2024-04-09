<?php
get_header();
?>
<main id="primary" class="site-main">
    <div class="container">
        <?php
        the_content();
        ?>
        <?php
        $projects_query = new WP_Query(array(
            'post_type' => 'project',
            'posts_per_page' => -1,
        ));
        if ($projects_query->have_posts()) :
            ?>
            <div class="projects">
                <?php
                while ($projects_query->have_posts()) :
                    $projects_query->the_post();
                    get_template_part( 'template-parts/project-card', 'project-card')
                    ?>
                    <script>
                        Fancybox.bind(document.getElementById("gallery-<?php echo get_the_ID(); ?>"), "[data-fancybox]", {});
                    </script>
                <?php
                endwhile;
                ?>
            </div>
        <?php
        endif;
        wp_reset_postdata();
        ?>
    </div>
</main>

<?php
get_footer();
?>

