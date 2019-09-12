<?php
/**
 * Created by PhpStorm.
 * User: Scott
 * Date: 1/01/2019
 * Time: 11:55 AM
 */
?>

<div class="col-sm-6 col-md-4">
    <?php
    $url = get_the_post_thumbnail_url(get_the_ID(), [220, 220]);
    $bg_image = '';
    if ($url) {
        $bg_image = sprintf('style="background-image: url(\'%s\'); background-size: cover;"', $url);
    }
    ?>
    <a class="thumbnail" href="<?php the_permalink()?>" <?=$bg_image?>>
        <?=$url ? '<div class="img-overlay"></div>':''; ?>
        <span class="title">
            <?php the_title() ?>
        </span>

        <?php /*$content = get_the_content();
        if (!empty($content)): ?>
        <span class="desc">
            <?=$content?>
        </span>
        <?php endif; */?>
    </a>
</div>