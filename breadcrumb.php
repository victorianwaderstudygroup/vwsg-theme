<?php
/**
 * Created by PhpStorm.
 * User: Scott
 * Date: 30/12/2018
 * Time: 1:18 PM
 */
?>

<div class="breadcrumbs">
    <?php

        if (is_news()) {
            get_template_part('partial/breadcrumb/news');
        } else if (get_the_id()) {
            get_template_part('partial/breadcrumb/page');
        } else {
            get_template_part('partial/breadcrumb/fallback');
        }
    ?>
</div>