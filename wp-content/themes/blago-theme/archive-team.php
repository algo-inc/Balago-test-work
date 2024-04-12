<?php
get_header();
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php if ( have_posts() ) : ?>
            <div class="container">
                <h1 class="page-title"><?php post_type_archive_title(); ?></h1>
            </div>
            <section class="content-container">
                <div class="flex-container">
                    <div class="archive-sidebar">

                    </div>
                    <div id="posts" class="team-post-container container">
                        <?php
                        $args = array(
                            'post_type' => 'team',
                            'posts_per_page' => 10,
                        );
                        $query = new WP_Query( $args );

                        if ( $query->have_posts() ) {
                            while ( $query->have_posts() ) {
                                $query->the_post();
                                get_template_part('template-parts/team-member-card', 'team-member-card');
                            }
                            wp_reset_postdata();
                        } else {
                            echo 'Постів не знайдено.';
                        }
                        ?>
                    </div>
                </div>
            </section>
        <?php else : ?>
            <?= 'no post' ?>
        <?php endif; ?>
    </main>
</div>
<?php
get_footer();
?>


