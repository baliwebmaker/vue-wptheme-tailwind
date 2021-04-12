<?php
define('THEME_NAME', 'vue-tw');

/**
 * Remove admin bar
 */
add_filter('show_admin_bar', '__return_false');
/**
 * Set up theme options on activation
 */

function vue_wordpress_setup()
{

    add_theme_support( 'title-tag' );

    add_theme_support( 'post-thumbnails' );

    add_theme_support( 'custom-logo', array(
        'height' => 160,
        'width' => 160,
    ) );

    register_nav_menus( array(
        'main' => 'Main Menu',
    ) );

}

add_action( 'after_setup_theme', 'vue_wordpress_setup' );

/**
 * Load scripts and styles
 */
function vue_wordpress_scripts()
{
    // Styles
    wp_enqueue_style( 'style.css', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style('vue_wordpress.css', get_template_directory_uri() . '/dist/vue-wordpress.css');

    // Scripts
    //$_SERVER['SERVER_PORT']==='80'?
    // Enable For Production - Disable for Development
	//wp_enqueue_script('vue_wordpress.js', get_template_directory_uri() . '/dist/vue-wordpress.js', array(), null, true);
    //:
    // Enable For Development - Remove for Production
    wp_enqueue_script( 'vue_wordpress.js', 'http://wp.test:8080/vue-wordpress.js', array(), false, true );
}

add_action( 'wp_enqueue_scripts', 'vue_wordpress_scripts' );

/**
 * Declare REST API Data Localizer dependency
 */

if ( !class_exists( 'RADL' ) ) {
    add_action( 'admin_notices', function () {
        echo '<div class="error"><p>REST API Data Localizer not activated. To use this theme go to <a href="' . esc_url( admin_url( 'plugins.php' ) ) . '">plugins</a> to download and/or activate REST API Data Localizer.</p></div>';
    } );
    return;
}

/**
 * Initialize REST API Data Localizer
 */

new RADL( '__VUE_WORDPRESS__', 'vue_wordpress.js', array(
    'routing' => RADL::callback( 'vue_wordpress_routing' ),
    'state' => array(
        'categories' => RADL::endpoint( 'categories'),
        'media' => RADL::endpoint( 'media' ),
        'menus' => RADL::callback( 'vue_wordpress_menus' ),
        'pages' => RADL::endpoint( 'pages' ),
        'posts' => RADL::endpoint( 'posts' ),
        'tags' => RADL::endpoint( 'tags' ),
        'users' => RADL::endpoint( 'users' ),
        'site' => RADL::callback( 'vue_wordpress_site' ),

        'special_package' => RADL::endpoint( 'special_package' ),
    ),
) );

/**
 * REST API Data Localizer callbacks
 */

function vue_wordpress_routing()
{
    $routing = array(
        'category_base' => get_option( 'category_base' ),
        'page_on_front' => null,
        'page_for_posts' => null,
        'permalink_structure' => get_option( 'permalink_structure' ),
        'show_on_front' => get_option( 'show_on_front' ),
        'tag_base' => get_option( 'tag_base' ),
        'url' => get_bloginfo( 'url' )
    );

    if ( $routing['show_on_front'] === 'page' ) {
        $front_page_id = get_option( 'page_on_front' );
        $posts_page_id = get_option( 'page_for_posts' );

        if ( $front_page_id ) {
            $front_page = get_post( $front_page_id );
            $routing['page_on_front'] = $front_page->post_name;
        }

        if ( $posts_page_id ) {
            $posts_page = get_post( $posts_page_id );
            $routing['page_for_posts'] = $posts_page->post_name;
        }

    }

    return $routing;
}

function vue_wordpress_menus()
{
    $menus = array();
    // $locations is an array where ([NAME] = MENU_ID);
    $locations = get_nav_menu_locations();

    foreach ( array_keys( $locations ) as $name ) {
        $id = $locations[$name];
        $menu = array();
        $menu_items = wp_get_nav_menu_items( $id );

        foreach ( $menu_items as $i ) {

            array_push( $menu, array(
                'id'      => $i->ID,
                'parent'  => $i->menu_item_parent,
                'target'  => $i->target,
                'content' => $i->title,
                'title'   => $i->attr_title,
                'url'     => $i->url,
            ) );

        }

        $menus[$name] = $menu;
    }

    return $menus;
}

function vue_wordpress_site()
{
    return array(
        'description' => get_bloginfo( 'description' ),
        'docTitle' => '',
        'loading' => false,
        'logo' => get_theme_mod( 'custom_logo' ),
        'name' => get_bloginfo( 'name' ),
        'posts_per_page' => get_option( 'posts_per_page' ),
        'url' => get_bloginfo( 'url' )
    );

}

/**
 * In template functions
 */

function vue_wordpress_min_read( $content )
{
    $length = count( explode( ' ', $content ) ) + 1;
    $time = $length / 200;

    if ( is_float( $time ) ) {
        $time = ceil( $time );
    }
   
    return $time . 'min read';
}
/* REGISTER package post type
===============================*/
function register_special_package() {
    $args = array(
                'label' => __('Special Package', THEME_NAME),
                'labels' => array(
                            'singular_name'=> __('Special package', THEME_NAME),
                            'add_new' => __('Add New Special package', THEME_NAME),
                            'add_new_item' => __('Add New Special package', THEME_NAME),
                            'new_item' => __('New Special package', THEME_NAME),
                            'edit_item' => __('Edit Special package', THEME_NAME),
                            'all_items' => __('All Special package', THEME_NAME),
                            'view_item' => __('View Special package', THEME_NAME),
                            'search_items' => __('Search Special package', THEME_NAME),
                            'not_found' =>  __('Nothing found', THEME_NAME),
                            'show_in_nav_menus' => true,
                            'menu_icon'  => 'dashicons-store',
                            'not_found_in_trash' => __('Nothing found in Trash', THEME_NAME),
                            ),
                'menu_icon' => 'dashicons-store',
                'description' => __('All Special package.', THEME_NAME),
                'public' => true,
                'show_ui' => true,
                'show_in_rest' => true,
                'capability_type' => 'page',
                'hierarchical' => false,
                'has_archive' => true,
                'supports' => array('title','editor','excerpt', 'page-attributes', 'thumbnail'),
                'rewrite' => array(
                            'slug' => _x('special_package', 'Slug wording of package for permalink', THEME_NAME), 
                            'with_front' => false
                            )	
                );
            register_post_type('special_package', $args);
    }
    add_action('init', 'register_special_package');
    