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
                        <form id="filter-form" method="get" action="<?php echo esc_url( home_url() ); ?>">
                            <input type="hidden" name="post_type" value="projects">
                            <label for="status">Статус</label>
                            <select id="status-select" name="status">
                                <option value="">Усі</option>
                                <option value="1"<?php selected( isset( $_GET['status'] ) && $_GET['status'] === '1' ); ?>>Завершені</option>
                                <option value="0"<?php selected( isset( $_GET['status'] ) && $_GET['status'] === '0' ); ?>>В процесі</option>
                            </select>
                        </form>
                    </div>
                    <div id="posts" class="archive-project-container">
                        <?php
                        $args = array(
                            'post_type' => 'projects',
                            'posts_per_page' => -1,
                        );

                        if ( isset( $_GET['status'] ) && $_GET['status'] !== '' ) {
                            $status = (int) $_GET['status'];
                            $value = $status;
                            $args['meta_query'] = array(
                                array(
                                    'key'     => 'status',
                                    'value'   => $value,
                                    'compare' => '=',
                                ),
                            );
                        }
                        $projects_query = new WP_Query( $args );
                        if ( $projects_query->have_posts() ) :
                            while ( $projects_query->have_posts() ) :
                                $projects_query->the_post();
                                get_template_part( 'template-parts/project-card', 'project-card' );
                                ?>
                                <?php
                            endwhile;
                        else :
                            echo '<p>Записів не знайдено.</p>';
                        endif;
                        ?>
                    </div>
                </div>
                <script>
                    document.getElementById('status-select').addEventListener('change', function() {
                        document.getElementById('filter-form').submit();
                    });
                </script>
            </section>
        <?php else : ?>
            <?= 'no post' ?>
        <?php endif; ?>
    </main>
</div>
<?php
get_footer();
?>

