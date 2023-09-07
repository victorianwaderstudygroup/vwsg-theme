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
		<img class="banner" src="<?=get_template_directory_uri()?>/images/home-banner-1.jpg" role="presentation">
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
			<a class="col-xs-12 col-sm-4 feature" href="<?php the_permalink(); ?>">
				<?php if (has_post_thumbnail()) : ?>
					<img src="<?php the_post_thumbnail_url('75'); ?>" class="feature-img" role="presentation">
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
				'posts_per_page' => 1,
				'post_type' => 'post',
				'orderby' => 'date',
				'order' => 'DESC',
				'category__in' => [
					get_cat_ID('News'),
					get_cat_ID('Uncategorised')
				],
				'category__not_in' => [get_cat_ID('Archive')]
			];

			$query = new WP_Query($args);
			if ($query->have_posts()) {
				while ($query->have_posts()) :
					$query->the_post();

					get_template_part('partial/news-item-compact');

				endwhile;
			}
			wp_reset_postdata();
			?>
			<a class="more-news" href="/news-events">More news &rarr;</i></a>
		</div>
	</div>

<?php
get_footer();