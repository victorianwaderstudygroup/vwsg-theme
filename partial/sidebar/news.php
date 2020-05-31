<?php
/**
 * Created by PhpStorm.
 * User: Scott
 * Date: 31/12/2018
 * Time: 11:29 AM
 */
?>

<div class="menu">
    <ul>
        <?php
        $parent_post = get_news_page();
        printf(
            '<li class="page_item page_item_top page-item-%d"><a href="%s">%s</a></li>',
            $parent_post->ID,
            get_permalink($parent_post->ID),
            $parent_post->post_title
        );
        wp_get_archives([
            'type' => 'yearly',
            'format' => 'custom',
            'before' => '<li class="page_item">',
            'after' => '</li>'
        ]);
        ?>
    </ul>
</div>