<?php
/**
 * Created by PhpStorm.
 * User: Scott
 * Date: 20/10/2018
 * Time: 11:57 AM
 */

/**
 * This is the static home-page template
 */
get_header();

?>
    <div class="row">
        <img class="banner" src="<?= get_template_directory_uri() ?>/images/home-banner-1.jpg">
    </div>

    <div class="row features">
        <a class="col-xs-12 col-sm-6 col-md-4 feature" href="">
            <img src="<?= get_template_directory_uri() ?>/images/oystercatcher-sightings.png" class="feature-img">
            <span>
                Report Oystercatcher Band Sightings
            </span>
        </a>
        <a class="col-xs-12 col-sm-6 col-md-4 feature" href="">
            <img src="<?= get_template_directory_uri() ?>/images/wader-gallery.png" class="feature-img">
            <span>
                Wader Gallery
            </span>
        </a>
        <a class="col-xs-12 col-sm-6 col-md-4 feature" href="">
            <img src="<?= get_template_directory_uri() ?>/images/flag-sightings.png" class="feature-img">
            <span>
                Report Leg Flag Sightings
            </span>
        </a>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-9 main">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post(); ?>
                    <h1><?php the_title() ?></h1>
                    <?php
                    the_content();
                endwhile;
            endif;
            ?>
        </div>
        <div class="col-xs-12 col-md-3 whats-on">
            <h2>What&rsquo;s On</h2>

            <?php
            foreach (get_posts() as $post) : setup_postdata($post); ?>
                <div class="row news_item">
                    <h3>
                        <a href="<?php the_permalink() ?>">
                            <div class="col-xs-3">
                                <span class="date"><?= get_the_date('d') ?><br><?= get_the_date('M') ?></span>
                            </div>
                            <div class="col-xs-9">
                                <?php the_title() ?>
                            </div>
                        </a>
                    </h3>
                </div>
            <?php endforeach;
            wp_reset_postdata();
            ?>

        </div>
    </div>
<?php
get_footer();