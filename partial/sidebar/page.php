<?php
/**
 * Created by PhpStorm.
 * User: Scott
 * Date: 31/12/2018
 * Time: 11:29 AM
 */

?>
<?php

if (is_single()) {
	$parent_post = get_page_by_title('News & Events');
}

if (!isset($parent_post)) {
	$parent_post = get_top_ancestor();
}

if (!isset($child_pages)) {
	$child_pages = get_child_pages($parent_post);
}


// only show submenu if top level ancestor has children
if (count($child_pages)) {
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

            $query = new WP_Query([
                'category_name' => 'fieldwork',
                'post_type' => 'page'
            ]);

            $exclude = implode(',', array_column($query->posts, 'ID'));
            wp_reset_postdata();

            wp_list_pages([
                'child_of' => $parent_post->ID,
                'title_li' => '',
                'exclude' => $exclude
            ]);


            ?>
        </ul>
    </div>
    <?php
}
?>
