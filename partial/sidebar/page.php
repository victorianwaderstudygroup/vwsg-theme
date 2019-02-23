<?php
/**
 * Created by PhpStorm.
 * User: Scott
 * Date: 31/12/2018
 * Time: 11:29 AM
 */

?>
<?php

// Find top ancestor
$parent_post = get_post();
while ($parent_post->post_parent) {
    $parent_post = get_post($parent_post->post_parent);
}

// only show submenu if top level ancestor has children
if (count(get_pages(['child_of' => $parent_post->ID]))) {
    ?>
    <div class="menu">
        <ul>
            <?php
            printf(
                '<li class="page_item page_item_top page-item-%d"><a href="%s">%s</a></li>',
                $parent_post->ID,
                get_permalink($parent_post->ID),
                $parent_post->post_title
            );

            wp_list_pages([
                'child_of' => $parent_post->ID,
                'title_li' => ''
            ]);

            ?>
        </ul>
    </div>
    <?php
}
?>
