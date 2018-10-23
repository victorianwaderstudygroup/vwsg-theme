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
<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-left">

            <button type="button" class="navbar-toggle collapsed" data-toggled="collapse" data-target="#top-menu" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= site_url(); ?>">
                <img class="navbar-logo" src="<?= get_template_directory_uri() ?>/images/logo.svg" alt="<?= bloginfo('site_title') ?>">
            </a>

            <?php wp_nav_menu([
                'theme_location' => 'top-menu',
                'container_id' => 'top-menu',
                'container_class' => 'navbar-collapse collapse',
                'menu_class' => 'nav navbar-nav',
                'menu_id' => ''
            ]); ?>
        </div>
        <div class="navbar-right">
            <?php get_search_form(); ?>
        </div>
    </div>
</nav>

<div class="container">

