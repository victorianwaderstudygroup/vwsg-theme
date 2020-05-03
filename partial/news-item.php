<?php
/**
 * Created by PhpStorm.
 * User: Scott
 * Date: 1/01/2019
 * Time: 11:55 AM
 */
?>
<article class="news_item">
    <p class="date"><i class="far fa-calendar-alt"></i> <?= get_the_date('F d, Y') ?></p>
    <h1>
        <?php the_title() ?>
    </h1>
    <?php
    the_content(); ?>
</article>
