<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php wp_head(); ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body <?php body_class(); ?>>
	<div class="device-xs visible-xs"></div>
	<div class="device-sm visible-sm"></div>
	<div class="device-md visible-md"></div>
	<div class="device-lg visible-lg"></div>

<nav class="navbar navbar-inverse">
    <div class="container">
		<div class="navbar-header">
            <a class="navbar-brand" href="<?= site_url(); ?>">
                <img class="navbar-logo" src="<?= get_template_directory_uri() ?>/images/logo.svg" alt="<?= bloginfo('site_title') ?>">
				Victorian Wader Study Group
            </a>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-menu" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

            <?php wp_page_menu([
                'container_id' => 'top-menu',
                'container_class' => '',
                'menu_class' => 'navbar-collapse collapse',
                'menu_id' => 'top-menu',
                'before' => '<ul class="nav navbar-nav">',
                'depth' => 1,
                'exclude' => '34'
            ]); ?>
			<?php get_search_form(); ?>
		</div>
    </div>
</nav>

<div class="container">
<?php
	$parent_post = get_top_ancestor();
	$child_pages = get_child_pages($parent_post);

	if (count($child_pages)) {
	?>

	<div class="row visible-sm visible-xs toggle-submenu-wrapper">
		<div class="col-xs-12">
			<div class="toggle-submenu pull-right">
				<div class="show-menu">
					<button class="btn"><i class="fas fa-bars"></i> Show submenu</button>
				</div>
				<div class="hide-menu">
					<button class="btn"><i class="fas fa-bars"></i> Hide submenu</button>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>