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
                $page = get_query_var('paged') ?? 1;
                $per_page = 4;
                $gallery_args = [
                    'post_type' => 'attachment',
                    'post_status' => 'any',
                    'category_name' => 'Gallery',
                    'orderby' => 'name',
                    'posts_per_page' => $per_page,
                    'paged' => $page
                ];

                $query = new WP_Query($gallery_args);

                foreach ($query->posts as $post):
                    setup_postdata($post);
                ?>
                <div class="col-md-4 col-lg-3">
                    <a href="<?= wp_get_attachment_url(get_the_ID()); ?>" target="_blank" class="tile" data-fancybox="gallery" data-caption="<?=wp_get_attachment_caption(get_the_ID());?>">
                        <img src="<?= wp_get_attachment_image_src(get_the_ID())[0]; ?>" alt="<?php the_title() ?>">
                    </a>
                </div>
                <?php
                endforeach;
                wp_reset_postdata();
                ?>

				<div class="col-xs-12">
                <?php
					$page = get_query_var('paged');
					$page = $page == 0 ? 1 : $page;

                    for($i = 1; $i <= $query->max_num_pages; $i++):
                        printf('<a href="%s" class="btn %s">%s</a> ',
                            '?paged=' . $i,
                            $page == $i ? 'btn-disabled' : 'btn-default',
                            $i);
                    endfor;
                ?>
				</div>
            </div>
        </div>
    </div>
<?php
get_footer();