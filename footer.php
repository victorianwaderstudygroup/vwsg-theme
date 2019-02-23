
    </div>
    <footer>
        <div class="container">
            <div class="col-xs-12 col-md-3 twitter">
                <?=display_tweet()?>
            </div>
            <div class="col-xs-12 col-md-6 gallery">
                <h3><a href="<?=get_permalink( get_page_by_title( 'Gallery' ) ) ?>">Gallery</a></h3>
                <?php
                    $i = 0;
                    $args = [
                        'category' => 3,
                        'numberposts' => 9,
                        'post_type' => 'attachment',
                        'orderby' => 'rand'
                    ];
                    foreach (get_posts($args) as $post) :
                        setup_postdata($post);
                        if ($i % 3 == 0) :
                            if ($i != 0) : ?>
                            </div>
                        <?php endif; ?>
                            <div>
                    <?php
                        endif ?><a href="<?=the_permalink() ?>"><img src="<?=wp_get_attachment_image_src(get_the_ID(), 'thumbnail')[0]; ?>" alt="<?php the_title()?>"></a>
                    <?php
                        $i++;
                    endforeach;
                    wp_reset_postdata();
                ?>

                </div>
            </div>
            <div class="col-xs-12 col-md-3 bulletin">
                <h3><a href="<?php get_permalink( get_page_by_title( 'Bulletins' ) ) ?>">Bulletin </a></h3>
                <?php
                $i = 0;
                $args = [
                    'category' => 4,
                    'numberposts' => 1,
                    'post_type' => 'attachment',
                    'orderby' => 'name'
                ];
                foreach (get_posts($args) as $post) : setup_postdata($post); ?>
                    <a href="<?=wp_get_attachment_url(get_the_ID()); ?>" target="_blank" class="bulletin">
                        <img src="<?=wp_get_attachment_image_src(get_the_ID(), 'thumbnail')[0]; ?>" alt="<?php the_title()?>"><br>
                        <?=nl2br(get_the_content(get_the_ID()));?>
                    </a>
            <?php
                endforeach;
                wp_reset_postdata();
            ?>
            </div>
            <div class="col-xs-12 copyright">
                <p>&copy; Copyright <?=date('Y');?> VWSG. Website maintained by Birgita Hansen. Page last updated: <?=get_the_date('F d, Y')?></p>
            </div>
        </div>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>