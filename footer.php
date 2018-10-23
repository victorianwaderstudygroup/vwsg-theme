
    </div>
    <footer>
        <div class="container">
            <div class="col-xs-12 col-md-3 twitter">
                <p class="tweet">
                    After 40 years at the VWSG helm, Clive Minton passes on the chair role to Roger Standen. <a href="//vwsg.org.au/whatsnew.html">vwsg.org.au/whatsnew</a>
                </p>
                <p class="handle">
                    <a href="//twitter.com/vwsg_web">vwsg_web</a>
                </p>
            </div>
            <div class="col-xs-12 col-md-6 gallery">
                <h3><a href="<?php get_permalink( get_page_by_title( 'Gallery' ) ) ?>">Gallery <i class="far fa-image"></i></a></h3>
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
                        endif ?><a href="<?php the_permalink() ?>"><img src="<?=wp_get_attachment_image_src(get_the_ID(), 'thumbnail')[0]; ?>" alt="<?php the_title()?>"></a>
                    <?php
                        $i++;
                    endforeach;
                    wp_reset_postdata();
                ?>

                </div>
            </div>
            <div class="col-xs-12 col-md-3 bulletins">
                <h3><a href="<?php get_permalink( get_page_by_title( 'Bulletins' ) ) ?>">Bulletin <i class="fas fa-bullhorn"></i></a></h3>
                <?php
                $i = 0;
                $args = [
                    'category' => 4,
                    'numberposts' => 1,
                    'post_type' => 'attachment'
                ];
                foreach (get_posts($args) as $post) : setup_postdata($post); ?>
                    <a href="<?=wp_get_attachment_url(get_the_ID()); ?>" target="_blank" class="bulletin">
                        <img src="<?=wp_get_attachment_image_src(get_the_ID(), 'thumbnail')[0]; ?>" alt="<?php the_title()?>">
                        <br>
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