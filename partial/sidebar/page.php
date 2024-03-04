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
                '<li class="page_item page_item_top page-item-%d %s"><a href="%s">%s</a></li>',
                $parent_post->ID,
                $parent_post->ID === get_the_ID() ? 'current_page_item' : '',
                get_permalink($parent_post->ID),
                $parent_post->post_title
            );

            $query = new WP_Query([
                'category_name' => 'fieldwork',
                'post_type' => 'page',
		'nopaging' => true
            ]);

            $exclude = implode(',', array_column($query->posts, 'ID'));
            wp_reset_postdata();

            $pages = new WP_Query([
				'child_of' => $parent_post->ID,
				'exclude' => $exclude,
				'sort_column' => 'menu_order',
				'nopaging' => true
			]);


            $pages = get_pages([
            	'child_of' => $parent_post->ID,
				'exclude' => $exclude,
				'sort_column' => 'menu_order'
			]);

			$child_open = false;
            foreach ($pages as $page) {
				$classes = array();
				$target = '';
				$previous_id = $previous_id ?? 0;
				$parent_id = $parent_id ?? 0;
				$title = $page->post_title;

            	if ($page->ID === get_the_ID()) {
            		array_push($classes, 'current_page_item');
				}
            	if (!$child_open && $previous_id == $page->post_parent) {
					printf('<ul class="children">');
					$child_open = true;
					$parent_id = $previous_id;
				}

				if ($child_open && $parent_id != $page->post_parent ) {
					printf('</li></ul>');
					$child_open = false;
				} else {
					printf('</li>');
				}

				$page_meta = get_post_meta($page->ID);
				if (array_key_exists('redirect', $page_meta) && stripos($page_meta['redirect'][0], get_site_url()) === false) {
					$target = '_blank';
					array_push($classes, 'external');
					$title = sprintf("%s %s", $title, '<i class="fas fa-external-link-alt"></i>');
				}


            	printf('<li class="%s"><a href="%s" target="%s">%s</a>', implode(' ', $classes), get_the_permalink($page->ID), $target, $title);



				$previous_id = $page->ID;

			}

/*            wp_list_pages([
                'child_of' => $parent_post->ID,
                'title_li' => '',
                'exclude' => $exclude,
            ]);
*/

            ?>
        </ul>
    </div>
    <?php
}
?>
