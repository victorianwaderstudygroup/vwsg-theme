<?php
/**
 * Created by PhpStorm.
 * User: Scott
 * Date: 20/10/2018
 * Time: 11:57 AM
 */

get_header();
?>


    <div class="row">
        <?php get_sidebar(); ?>

        <div class="col-xs-12 col-md-9 main">
            <?php get_breadcrumb(); ?>

            <div class="content gallery">
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post(); ?>
                        <h1><?php the_title() ?></h1>
                        <?php
                        the_content();
                    endwhile;
                endif;
                ?>

                <?php
                $bulletin_args = [
                    'post_type' => 'attachment',
                    'category_name' => 'Gallery',
                    'orderby' => 'name',
                    'posts_per_page' => 16
                ];

                foreach (get_posts($bulletin_args) as $post):
                    setup_postdata($post);
                ?>
                <div class="col-md-3">
                    <a href="<?= wp_get_attachment_url(get_the_ID()); ?>" target="_blank" class="tile" data-fancybox="gallery" data-caption="<?=wp_get_attachment_caption(get_the_ID());?>">
                        <img src="<?= wp_get_attachment_image_src(get_the_ID())[0]; ?>" alt="<?php the_title() ?>">
                        <caption></caption>
                    </a>
                </div>
                <?php
                endforeach;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>
<?php
get_footer();