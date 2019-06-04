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


        <div class="col-xs-12 col-md-9 main col-md-offset-3">
            <?php
            get_breadcrumb();
            ?>


            <div class="content">
                <h1>Search</h1>
                <div class="row">

                    <div class="col-md-10 col-md-offset-1">
                        <div class="btn-group btn-group-justified search_filters">
                            <div class="btn btn-default on" data-type="news">
                                <i class="far fa-newspaper"></i> News
                            </div>
                            <div class="btn btn-default on" data-type="page">
                                <i class="far fa-file-alt"></i> Pages
                            </div>
                            <div class="btn btn-default on" data-type="pdf">
                                <i class="far fa-file-pdf"></i> PDFs
                            </div>
                        </div>
                    </div>
                </div>


                <?php
                if (have_posts()) :
                    $i = 1;
                    while (have_posts()) : the_post(); ?>

                        <?php
                        switch (get_post_type()) {
                            case 'attachment':
                                switch (get_post_mime_type()) {
                                    case 'application/pdf':
                                        $icon = 'far fa-file-pdf';
                                        $type = 'pdf';
                                        break;
                                }
                                break;
                            case 'page':
                                $icon = 'far fa-file-alt';
                                $type = 'page';
                                break;
                            case 'post':
                                $icon = 'far fa-newspaper';
                                $type = 'news';
                                break;
                        }
                        ?>

                        <div class="search_result type-<?=$type?>">
                            <?php
                            if ($icon):
                                ?>
                                <i class="<?= $icon ?>"></i>
                            <?php
                            endif;
                            ?>
                            <h4>
                                <a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h4>

                            <?php the_excerpt(); ?>
                        </div>
                    <?php
                    endwhile;
                else:
                    ?>
                    <div class="search-result">
                        <p>No results found</p>
                    </div>
                <?php
                endif;
                ?>
            </div>
        </div>
    </div>
<?php

get_footer();