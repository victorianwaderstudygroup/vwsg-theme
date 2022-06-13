<?php

// Enqueue stylesheets
function vwsg_styles()
{
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/lib/fontawesome/5.15.4/css/all.css', [], '5.15.4');
    wp_enqueue_style('fonts', 'https://fonts.googleapis.com/css?family=Julius+Sans+One|Open+Sans:300,400,700', []);
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/lib/bootstrap/3.4.1/css/bootstrap.min.css', [], '3.4.1');
    wp_enqueue_style('fancybox-css', get_template_directory_uri() . '/lib/fancybox/3.5.7/jquery.fancybox.min.css', [], '3.5.7');

    wp_enqueue_style('vwsg-style', get_stylesheet_uri(), ['bootstrap-css', 'fonts', 'fontawesome'], '1.0.2');

    if (is_front_page()) {
        wp_enqueue_style('vwsg-front-page-style', get_template_directory_uri() . '/css/front-page.css', ['vwsg-style'], '1.0.0');
    }

    if (!is_front_page() || is_news()) {
        wp_enqueue_style('vwsg-page-style', get_template_directory_uri() . '/css/page.css', ['vwsg-style'], '1.0.5');
    }

    if (is_search()) {
        wp_enqueue_style('vwsg-search-style', get_template_directory_uri() . '/css/search.css', ['vwsg-page-style'], '1.0.0');
    }
}

add_action('wp_enqueue_scripts', 'vwsg_styles');

// Enqueue scripts
function vwsg_scripts()
{
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', get_template_directory_uri() . '/lib/jquery/3.6.0/jquery.min.js', [], '3.6.0');
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/lib/bootstrap/3.4.1/js/bootstrap.min.js', [], '3.4.1');
    wp_enqueue_script('fancybox', get_template_directory_uri() . '/lib/fancybox/3.5.7/jquery.fancybox.min.js', [], '3.5.7');
    wp_enqueue_script('vwsg-search-script', get_template_directory_uri() . '/js/search.js', ['jquery'], '1.0.0');
    wp_enqueue_script('vwsg-template-script', get_template_directory_uri() . '/js/functions.js', ['jquery'], '1.0.0');
}

add_action('wp_enqueue_scripts', 'vwsg_scripts');

// Configure theme features
function vwsg_setup()
{
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    register_nav_menu('top-menu', __('Top Menu'));
}

add_action('after_setup_theme', 'vwsg_setup');

// Remove wordpress generator meta
add_filter('the_generator', function () {
    return '';
});
remove_action('wp_head', 'wp_generator');

add_filter('pre_get_posts', function ($query) {
    if ($query->is_search === true) {
        $query->set('post_type', ['post', 'page', 'attachment']);
        $query->set('post_status', ['publish', 'inherit']);
    }
});

function add_categories_for_pages()
{
    register_taxonomy_for_object_type('category', 'page');
}

add_action('init', 'add_categories_for_pages');

// Enable categories for attachments
function add_categories_for_attachments()
{
    register_taxonomy_for_object_type('category', 'attachment');
}

add_action('init', 'add_categories_for_attachments');

// Enable tags for attachments
function add_tags_for_attachments()
{
    register_taxonomy_for_object_type('post_tag', 'attachment');
}

add_action('init', 'add_tags_for_attachments');

function wpdocs_excerpt_more(): string
{
    return '...';
}

add_filter('excerpt_more', 'wpdocs_excerpt_more');

/**
 * Is the current post a single post or a post listing.
 * In the context of this theme, is it news
 *
 * @return bool
 */
function is_news(): bool
{
    return is_single() || is_home() || is_archive();
}

/**
 * Vanity function to make calling breadcrumb like calling other template components
 */
function get_breadcrumb()
{
    get_template_part('breadcrumb');
}

/**
 * Utility function to retrieve News & Events page
 *
 * @return WP_Post|array|null
 */
function get_news_page()
{
    return get_post(17);
}

function build_tweet($tweet, $user_template): string
{
    $twitter_user = 'vwsg_web';

    $template = <<<TWITTER
<p class="tweet">
    %s %s
</p>
TWITTER;

    if ($user_template) {
        $template = sprintf($user_template, $template);
    }

    $is_retweet = false;
    if (array_key_exists('retweeted_status', $tweet)) {
        $text = $tweet['retweeted_status']['full_text'];
        $is_retweet = true;
    } else {
        $text = $tweet['full_text'];
    }
    foreach ($tweet['entities']['user_mentions'] as $i => $user_mention) {
        if (0 == $i && $is_retweet) {
            $text = 'RT @' . $user_mention['screen_name'] . ': ' . $text;
        }
        $text = str_replace(
            '@' . $user_mention['screen_name'],
            sprintf(
                '<a href="%s" target="_blank">@%s</a>',
                'https://twitter.com/' . $user_mention['screen_name'],
                $user_mention['screen_name']
            ),
            $text
        );
    }

    foreach ($tweet['entities']['urls'] as $url) {
        $text = str_replace(
            $url['url'],
            sprintf(
                '<a href="%s">%s</a>',
                $url['expanded_url'],
                $url['display_url']
            ),
            $text
        );
    }

    if ($is_retweet) :
        foreach ($tweet['retweeted_status']['entities']['media'] as $media) {
            $text = str_replace(
                $media,
                '',
                $text
            );
        }
    endif;

    $read_more = sprintf(
        '<a class="read-more" href="https://twitter.com/%s/status/%s">%s</a>',
        $twitter_user,
        $tweet['id_str'],
        '<i class=" fas fa-external-link-alt"></i>'
    );

    return sprintf(
        $template,
        $text,
        $read_more
    );
}

/**
 * Builds tweet from cached json result.
 * Expects cron/twitter.cron.php to be running
 */
function display_tweet($template = '')
{
    $json = json_decode(file_get_contents(get_template_directory() . '/cron/vwsg_web.json'), JSON_OBJECT_AS_ARRAY);
    $tweet = $json[0];

    echo build_tweet($tweet, $template);
}

function display_tweets($template = '')
{
    $json = json_decode(file_get_contents(get_template_directory() . '/cron/vwsg_web.json'), JSON_OBJECT_AS_ARRAY);

    foreach ($json as $i => $tweet) {
        if ($i > 2) {
            break;
        }
        echo build_tweet($tweet, $template);
    }
}

function list_news($attrs)
{
    $attrs = shortcode_atts([
        'category' => 'News'
    ], $attrs);

    $page = filter_var(get_query_var('paged'), FILTER_VALIDATE_INT);
    $page = empty($page) ? 1 : $page;
    $per_page = 10;

    $news_args = [
        'post_type' => 'post',
        'posts_per_page' => $per_page,
        'offset' => ($page - 1) * $per_page,
    ];

    switch ($attrs['category']) {
        case 'News':
            $news_args['category__in'] = [
                get_cat_ID($attrs['category']),
                get_cat_ID('Uncategorised')
            ];
            $news_args['category__not_in'] = [get_cat_ID('Archive')];

            break;
        case 'Archive':
            $news_args['cat'] = get_cat_ID('Archive');
            $news_args['category__in'] = [get_cat_ID('News'), get_cat_ID('Uncategorised')];
            break;
        default:
            $news_args['cat'] = get_cat_ID($attrs['category']);
    }

    ob_start();
    $query = new WP_Query($news_args);
    if ($query->have_posts()) {
        while ($query->have_posts()) :
            $query->the_post();

            get_template_part('partial/news-item');

        endwhile;
    }
    wp_reset_postdata();

    ?>

	<div class="col-xs-12 pagination">
        <?php
        $page = get_query_var('paged');
        $page = $page == 0 ? 1 : $page;

        for ($i = 1; $i <= $query->max_num_pages; $i++):
            printf(
                '<a href="%s" class="btn %s">%s</a> ',
                '?paged=' . $i,
                $page == $i ? 'btn-current' : 'btn-default',
                $i
            );
        endfor;
        ?>
	</div>

    <?php
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

add_shortcode('news-listing', 'list_news');

function list_subpages($attrs)
{
    $parent_id = get_the_ID();
    $subpage_args = [
        'post_type' => 'page',
        'post_parent' => $parent_id,
        'orderby' => ['menu_order', 'post_title']
    ];

    ob_start();
    $query = new WP_Query($subpage_args);
    if ($query->have_posts()) { ?>
		<div class="subpage-listing">
            <?php
            while ($query->have_posts()) :
                $query->the_post();

                get_template_part('partial/subpage-listing-item');

            endwhile; ?>
		</div>
        <?php
    }
    wp_reset_postdata();
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

add_shortcode('subpage_listing', 'list_subpages');

function list_fieldwork()
{
    $fieldwork_args = [
        'post_type' => 'page',
        'category_name' => 'Fieldwork',
        'orderby' => 'name'
    ];

    ob_start();
    $query = new WP_Query($fieldwork_args);
    $count = 0;
    if ($query->have_posts()) {
        while ($query->have_posts()) :
            $query->the_post();
            $count++; ?>
			<div class="fieldwork-entry <?=$count == 1 ? 'open' : ''?>">
				<header>
					<h3><?php
                        the_title() ?></h3>
				</header>
				<div class="content">
                    <?php
                    the_content(); ?>
				</div>
			</div>
        <?php
        endwhile;
    }
    wp_reset_postdata();
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

add_shortcode('fieldwork-listing', 'list_fieldwork');

function get_top_ancestor()
{
    $parent_post = get_post();
    while ($parent_post->post_parent) {
        $parent_post = get_post($parent_post->post_parent);
    }

    return $parent_post;
}

function get_child_pages($parent_post)
{
    return get_pages(['child_of' => $parent_post->ID, 'sort_column' => 'menu_order,post_title']);
}

class Breadcrumb_Walker extends Walker_Nav_Menu
{
    protected function get_direct_ancestors($elements): array
    {
        $currentID = get_the_ID();
        $ancestors = [];

        do {
            $ancestor = array_filter($elements, function ($item) use ($currentID) {
                if ($item->ID == $currentID || $item->object_id == $currentID) {
                    return true;
                } else {
                    return false;
                }
            });
            $ancestor = array_pop($ancestor);
            $currentID = $ancestor->post_parent;
            array_unshift($ancestors, $ancestor);
        } while ($ancestor->menu_item_parent > 0);

        return $ancestors;
    }

    protected function exclude_top_level_items($elements): array
    {
        return array_filter($elements, function ($item) {
            // Top level items have no parent (post_parent=0) everything else will have a post_parent>0
            // so we use PHP falsiness/truthiness to return
            return $item->post_parent;
        });
    }

    function walk($elements, $max_depth, ...$args): string
    {
        $elements = $this->get_direct_ancestors($elements);
        //$elements = $this->exclude_top_level_items($elements);
        $output = parent::walk($elements, $max_depth, $args);

        return '<a href="' . site_url() . '" title="' . get_bloginfo('title') . '">Home</a>' . $output;
    }

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        // Don't link current page
        if ($item->object_id == get_the_ID()) {
            $output .= ' &gt; ' . $item->title;
        } else {
            $classes = empty($item->classes) ? array() : (array)$item->classes;
            $classes[] = 'menu-item-' . $item->ID;

            /**
             * Filters the arguments for a single nav menu item.
             *
             * @param stdClass $args  An object of wp_nav_menu() arguments.
             * @param WP_Post  $item  Menu item data object.
             * @param int      $depth Depth of menu item. Used for padding.
             *
             * @since 4.4.0
             */
            $args = apply_filters('nav_menu_item_args', $args, $item, $depth);

            /**
             * Filters the CSS class(es) applied to a menu item's list item element.
             *
             * @param array    $classes The CSS classes that are applied to the menu item's `<li>` element.
             * @param WP_Post  $item    The current menu item.
             * @param stdClass $args    An object of wp_nav_menu() arguments.
             * @param int      $depth   Depth of menu item. Used for padding.
             *
             * @since 3.0.0
             * @since 4.1.0 The `$depth` parameter was added.
             */
            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

            /**
             * Filters the ID applied to a menu item's list item element.
             *
             * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
             * @param WP_Post  $item    The current menu item.
             * @param stdClass $args    An object of wp_nav_menu() arguments.
             * @param int      $depth   Depth of menu item. Used for padding.
             *
             * @since 3.0.1
             * @since 4.1.0 The `$depth` parameter was added.
             */
            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';

            $output .= ' &gt; <a' . $id . $class_names . '';

            $atts = array();
            $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
            $atts['target'] = !empty($item->target) ? $item->target : '';
            $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
            $atts['href'] = !empty($item->url) ? $item->url : '';

            /**
             * Filters the HTML attributes applied to a menu item's anchor element.
             *
             * @param array    $atts   {
             *                         The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
             *
             * @type string    $title  Title attribute.
             * @type string    $target Target attribute.
             * @type string    $rel    The rel attribute.
             * @type string    $href   The href attribute.
             * }
             *
             * @param WP_Post  $item   The current menu item.
             * @param stdClass $args   An object of wp_nav_menu() arguments.
             * @param int      $depth  Depth of menu item. Used for padding.
             *
             * @since 3.6.0
             * @since 4.1.0 The `$depth` parameter was added.
             */
            $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

            $attributes = '';
            foreach ($atts as $attr => $value) {
                if (!empty($value)) {
                    $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            /** This filter is documented in wp-includes/post-template.php */
            $title = apply_filters('the_title', $item->title, $item->ID);

            /**
             * Filters a menu item's title.
             *
             * @param string   $title The menu item's title.
             * @param WP_Post  $item  The current menu item.
             * @param stdClass $args  An object of wp_nav_menu() arguments.
             * @param int      $depth Depth of menu item. Used for padding.
             *
             * @since 4.4.0
             */
            $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

            $item_output = $args->before;
            $item_output .= '' . $attributes . '>';
            $item_output .= $args->link_before . $title . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;

            /**
             * Filters a menu item's starting output.
             * The menu item's starting output only includes `$args->before`, the opening `<a>`,
             * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
             * no filter for modifying the opening and closing `<li>` for a menu item.
             *
             * @param string   $item_output The menu item's starting HTML output.
             * @param WP_Post  $item        Menu item data object.
             * @param int      $depth       Depth of menu item. Used for padding.
             * @param stdClass $args        An object of wp_nav_menu() arguments.
             *
             * @since 3.0.0
             */
            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }
    }

    function end_el(&$output, $item, $depth = 0, $args = array())
    {
    }

    function start_lvl(&$output, $depth = 0, $args = array())
    {
    }

    function end_lvl(&$output, $depth = 0, $args = array())
    {
    }

}
