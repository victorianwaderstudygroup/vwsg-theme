<?php
/**
 * Created by PhpStorm.
 * User: Scott
 * Date: 30/12/2018
 * Time: 1:21 PM
 */
?>
<ul>
    <li><a href="<?=get_home_url()?>">Home</a></li>
    <?php

    $ancestors = get_post_ancestors(get_post());
    array_push($ancestors, get_the_ID());

    wp_list_pages([
        'link_before' => '<span class="divider">&gt;</span>',
        'title_li' => false,
        'include' => implode(',', $ancestors)
    ]);
    ?>
</ul>
