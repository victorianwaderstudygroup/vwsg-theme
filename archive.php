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
                <h1><?=get_query_var('year')?> News &amp; Events</h1>
                <?php
                if (have_posts()) :
                    while (have_posts()) :
                        the_post();
                        get_template_part('partial/news-item');
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </div>
<?php

get_footer();