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
        <?php get_search_form(); ?>

        <div class="col-xs-12 col-md-9 main col-md-offset-3">
            <div class="content">
                <h1>Search</h1>
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post(); ?>
                    <div class="search_result">
                        <h4><?php the_title() ?></h4>

                        <?php the_excerpt(); ?>
                    </div>
                    <?php
                    endwhile;
                    endif;
                    ?>
            </div>
        </div>
    </div>
<?php

get_footer();