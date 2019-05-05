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
        <?php
        $i = 0;
        $args = [
            'category' => 6,
            'numberposts' => 3,
            'post_type' => 'page',
            'orderby' => 'meta_value_num',
            'meta_key' => 'home_position',
            'order' => 'ASC'
        ];
        foreach (get_posts($args) as $post) : setup_postdata($post); ?>
            <a class="col-xs-12 col-sm-6 col-md-4 feature" href="<?=the_permalink()?>">
            <?php if (has_post_thumbnail()) : ?>
                <img src="<?=the_post_thumbnail_url('75');?>" class="feature-img">
            <?php
            endif;
            ?>
                <span><?=the_title();?></span></a>
            <?php
        endforeach;
        wp_reset_postdata();
    ?>
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
            <h2>Latest news</h2>
            <ul>
            <?php
            foreach (get_posts() as $post) : setup_postdata($post); ?>
                <li class="news_item">
                        <h3>
                            <a href="<?php the_permalink() ?>">
                               <!-- <div class="col-xs-3">
                                    <span class="date"><?/*= get_the_date('d') */?><br><?/*= get_the_date('M') */?></span>
                                </div>-->
                                    <?php the_title() ?>
                            </a>
                        </h3>
                    </li>
            <?php endforeach;
            wp_reset_postdata();
            ?>
            </ul>

        </div>
    </div>
<?php
get_footer();