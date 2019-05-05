<?php
/**
 * Created by PhpStorm.
 * User: Scott
 * Date: 20/10/2018
 * Time: 11:57 AM
 */

get_header();
/**
 * This is the post listing template (News & Events)
 */
?>


    <div class="row">
        <?php get_sidebar(); ?>

        <div class="col-xs-12 col-md-9 main">
            <?php get_breadcrumb(); ?>

            <div class="content news_listing">
                <h1>News &amp; Events</h1>
                <?php
                    $post = get_post(305);
                    setup_postdata($post); // Field work programme
                ?>

                <a href="<?= get_permalink(); ?>" class="tile">
                    <?php if (has_post_thumbnail()) : ?>
                        <img src="<?=the_post_thumbnail_url();?>" class="feature-img" alt="<?php the_title() ?>">
                    <?php
                    endif;
                    ?>
                    <span><?= the_title(); ?></span>
                </a>
                <?php
                wp_reset_postdata();
                ?>
<br>
                <?php
                $post_args = [
                    'date_query' => [
                        'year' => date('Y')
                    ]
                ];

                $current_posts = get_posts($post_args);

                if (count($current_posts)):
                    foreach ($current_posts as $post) :
                        setup_postdata($post);
                        get_template_part('partial/news-item');
                    endforeach;
                else:
                    if (have_posts()) :
                        while (have_posts()) :
                            the_post();
                            get_template_part('partial/news-item');
                        endwhile;
                    endif;
                endif;
                ?>
            </div>
        </div>
    </div>
<?php

get_footer();