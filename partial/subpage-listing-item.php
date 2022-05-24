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
	$meta = get_post_meta(get_the_ID());
	$target = '';
	if (array_key_exists('redirect', $meta)) {
		$url = $meta['redirect'][0];
		if (strpos($url, get_site_url()) !== 0) {
			$target = '_blank';
		}
	} else {
		$url = get_the_permalink(get_the_ID());
	}

	$image_url = get_the_post_thumbnail_url(get_the_ID(), [220, 220]);
    $bg_image = '';
    if ($image_url) {
        $bg_image = sprintf('style="background-image: url(\'%s\'); background-size: cover;"', $image_url);
    }
    ?>
    <a class="thumbnail" href="<?=$url?>" target="<?=$target?>" <?=$bg_image?>>
        <?=$url ? '<div class="img-overlay"></div>':''; ?>
        <span class="title">
            <?=$meta['short_title'][0] ?? the_title() ?>
        </span>

        <?php /*$content = get_the_content();
        if (!empty($content)): ?>
        <span class="desc">
            <?=$content?>
        </span>
        <?php endif; */?>
    </a>
</div>