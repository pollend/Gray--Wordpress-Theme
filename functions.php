<?php
	require "admin/homeOptions.php";
	// Add RSS links to <head> section
	automatic_feed_links();
	
	// Load jQuery
	if ( !is_admin() ) {
	   wp_deregister_script('jquery');
	   wp_register_script('jquery', ("http://code.jquery.com/jquery-1.10.1.min.js"), false);
	   wp_enqueue_script('jquery');

       add_theme_support( 'custom-header' );
	}
   

	// Clean up the <head>
	function removeHeadLinks() {
    	remove_action('wp_head', 'rsd_link');
    	remove_action('wp_head', 'wlwmanifest_link');
    }
    add_action('init', 'removeHeadLinks');
    remove_action('wp_head', 'wp_generator');
    
    if (function_exists('register_sidebar')) {
    	register_sidebar(array(
    		'name' => 'Sidebar Widgets',
    		'id'   => 'sidebar-widgets',
    		'description'   => 'These are widgets for the sidebar.',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</div>',
    		'before_title'  => '<h2>',
    		'after_title'   => '</h2>'
    	));
    }


    function gray_menu_args( $args ) {
     $args['show_home'] = true;
     return $args;
    }
    add_filter( 'wp_page_menu_args', 'gray_menu_args' );

    $gray_Header = array(
        'default-image'          => '',
        'random-default'         => false,
        'flex-height'            => true,
        'flex-width'             => true,
        'height'                 => 250,
        'width'                  => 960,
        'max-width'              => 2000,
        'default-text-color'     => '',
        'header-text'            => true,
        'uploads'                => true,
        'wp-head-callback'       => '',
        'admin-head-callback'    => '',
        'admin-preview-callback' => '',
    );
    add_theme_support( 'custom-header', $gray_Header );



    function gray_admin_menu()
    {
        include_once "admin/homeOptions.php";
        add_theme_page('gray home page', 'Theme Options', 'read', 'home', 'gray_home_options_page');
    }
    add_action('admin_menu','gray_admin_menu');


 

?>