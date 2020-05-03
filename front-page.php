<?php
/**
 * Created by PhpStorm.
 * User: Scott
 * Date: 20/10/2018
 * Time: 11:57 AM
 */

/**
 * This is the static home-page template
 */
get_header();

?>
	<div class="row">
		<img class="banner" src="<?=get_template_directory_uri()?>/images/home-banner-1.jpg">
	</div>

	<div class="row features">
		<?php
		$i = 0;
		$args = [
			'category' => 6,
			'numberposts' => 3,
			'post_type' => 'page',
			'orderby' => 'meta_value_num',
			'meta_key' => 'home_position',
			'order' => 'ASC'
		];
		foreach (get_posts($args) as $post) : setup_postdata($post); ?>
			<a class="col-xs-12 col-sm-4 feature" href="<?=the_permalink()?>">
				<?php if (has_post_thumbnail()) : ?>
					<img src="<?=the_post_thumbnail_url('75');?>" class="feature-img">
				<?php
				endif;
				?>
				<span><?=the_title();?></span></a>
		<?php
		endforeach;
		wp_reset_postdata();
		?>
	</div>

	<div class="row">
		<div class="col-xs-12 col-md-8 col-lg-8 main">
			<?php
			if (have_posts()) :
				while (have_posts()) : the_post(); ?>
					<h1><?php the_title() ?></h1>
					<?php
					the_content();
				endwhile;
			endif;
			?>
		</div>
		<div class="col-xs-12 col-md-4 col-lg-4 news section">
			<h2><i class="far fa-newspaper"></i> Latest News</h2>
			<?php

			$args = [
				'numberposts' => 1,
				'post_type' => 'post',
				'orderby' => 'date',
				'order' => 'DESC'
			];
			echo list_news($args, true);
			?>
			<a class="more-news" href="/news-events">More news &rarr;</i></a>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 tweets section">
			<h2><i class="fab fa-twitter"></i> Tweets</h2>
			<?=display_tweets('<div class="col-xs-12 col-md-4">%s</div>')?>

			<a class="more-tweets" href="http://twitter.com/vwsg_web">More tweets <i class="fab fa-twitter"></i></a>
		</div>
	</div>
<?php
get_footer();