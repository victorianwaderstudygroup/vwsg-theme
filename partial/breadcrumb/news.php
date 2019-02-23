<?php
/**
 * Created by PhpStorm.
 * User: Scott
 * Date: 30/12/2018
 * Time: 1:17 PM
 */
?>
    <ul>
        <li><a href="<?= get_home_url() ?>">Home</a></li>
        <li><a href="<?= get_page_link(get_news_page()) ?>"><span class="divider">&gt;</span>News &amp; Events</a></li>
        <?php if (is_single()) {

            ?>
            <li>
                <a href="<?= get_permalink() ?>"><span class="divider">&gt;</span><?= get_the_title() ?></a>
            </li>
            <li>
                <a href="<?= get_permalink() ?>"><span class="divider">&gt;</span><?= get_the_title() ?></a>
            </li>
        <?php } ?>
    </ul>
