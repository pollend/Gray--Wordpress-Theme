<?php
	require "admin/homeOptions.php";

    if ( ! isset( $content_width ) )
    $content_width = 500;


	// Clean up the <head>
	function removeHeadLinks() {
    	remove_action('wp_head', 'rsd_link');
    	remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'wp_generator');
    }
    add_action('init', 'removeHeadLinks');
    

	register_sidebar(array(
		'name' => 'Sidebar Widgets',
		'id'   => 'sidebar-widgets',
		'description'   => 'These are widgets for the sidebar.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>'
	));
    


    function gray_menu_args( $args ) {
     $args['show_home'] = true;
     return $args;
    }
    add_filter( 'wp_page_menu_args', 'gray_menu_args' );

    //setup the customizer
    function gray_customizer($wp_customizer)
    {
        //full background image
        $wp_customizer->add_section(
            'gray_cover_background_image',
            array(
                'title' => 'cover background image',
                'description' => 'full background image.',
                'priority' => 35,
            )
        );

        $wp_customizer->add_setting( 'gray_cover_background_image' ,  array( 'transport' => 'postMessage'));

        $wp_customizer->add_control(
        new WP_Customize_Image_Control(
                $wp_customizer,
                'gray_cover_background_image',
                array(
                    'label' => 'Image Upload',
                    'section' => 'gray_cover_background_image',
                    'settings' => 'gray_cover_background_image'
                )
            )
        );

        //background color and image
        $wp_customizer->add_section(
            'gray_pattern_background',
            array(
                'title' => 'Pattern Background',
                'description' => 'background color and pattern.',
                'priority' => 35,
            )
        );

        $wp_customizer->add_setting('gray_pattern_repeat', array('transport' => 'postMessage') );
         $wp_customizer->add_control(
             new WP_Customize_Image_Control(
                $wp_customizer,
                'gray_pattern_repeat',
                array(
                    'label' => 'Image Upload',
                    'section' => 'gray_pattern_background',
                    'settings' => 'gray_pattern_repeat'
                )
            )
        );

        $control = $wp_customizer->get_control( 'gray_pattern_repeat' );

        $control->add_tab( 'builtins', __('Built-ins'), function() {
        /* Supply a list of built-in background that come with your theme */
        $backgrounds = array(
            'images/strip.png'
        );

        global  $wp_customize;
        $control =  $wp_customize->get_control( 'gray_pattern_repeat' );

        foreach ( (array) $backgrounds as $background )
            $control->print_tab_image( esc_url_raw( get_stylesheet_directory_uri() . '/' . $background ) );

         } );


        $wp_customizer->add_setting(
        'gray_gradient_one',
            array(
                'default' => '#1958a0',
                'transport' => 'postMessage'
            )
        );

        $wp_customizer->add_control(new WP_Customize_Color_Control($wp_customizer, 'gray_gradient_one', array(
            'section'    => 'gray_pattern_background',
            'settings'   => 'gray_gradient_one',
        )));

        $wp_customizer->add_setting(
        'gray_gradient_two',
            array(
                'default' => '#001a6b',
                'transport' => 'postMessage'
            )
        );

        $wp_customizer->add_control(new WP_Customize_Color_Control($wp_customizer, 'gray_gradient_two', array(
        'section'    => 'gray_pattern_background',
        'settings'   => 'gray_gradient_two',
        )));

         if ( $wp_customizer->is_preview() && ! is_admin() ) {
            add_action( 'wp_footer', 'gray_customizer_preview', 21);
        }
    }
    add_action( 'customize_register', 'gray_customizer' );

    //create the varibles for the custom preview
    function gray_customizer_preview(){
        ?>
        <script type="text/javascript">
            var color_one = "<?php echo  get_theme_mod('gray_gradient_one'); ?>";
            var color_two= "<?php echo get_theme_mod('gray_gradient_two'); ?>";
            var background_image= "<?php echo get_theme_mod('gray_pattern_repeat'); ?>" ;
            var cover_background_image =  "<?php echo get_theme_mod('gray_cover_background_image'); ?>" ;
        </script>
        <?php
    }

    function gray_customizer_live_preview()
    {
        wp_enqueue_script( 
              'mytheme-themecustomizer',            //Give the script an ID
              get_template_directory_uri().'/js/preview.js',//Point to file
              array( 'jquery','customize-preview' ),    //Define dependencies
              '',                       //Define a version (optional) 
              true                      //Put script in footer?
        );
    }
    add_action( 'customize_preview_init', 'gray_customizer_live_preview' );

    function gray_script_style()
    {
        //add javascript to pages with comment form
        if ( is_singular() ) 
            wp_enqueue_script( 'comment-reply' );

        //get debounce script to prevent user event spam
        wp_enqueue_script( "debounce", get_template_directory_uri()."/js/debounce.js",array("jquery"),'1.1');

        //enqueue jquery and main javascript
        wp_enqueue_script('jquery');   

        //get main script
        wp_enqueue_script( "gray_main", get_template_directory_uri()."/js/main.js",array("jquery","debounce","transit"),'1.0.0');
    
        //image overlay script
        wp_enqueue_script("gray_imageOverlay",get_template_directory_uri()."/js/imageOverlay.js",array("gray_main"),'1.0.0');

        //register style sheet
        wp_enqueue_style( 'gray_style', get_stylesheet_uri(), array(), '1.0.0' );

        //image overly style sheet
        wp_enqueue_style( 'gray_imageOverlay', get_template_directory_uri() . "/imageOverlay.css", array(), '1.0.0' );

        //transit
         wp_enqueue_script( 'transit', get_template_directory_uri() . "/js/transit.js", array(), '1' );
    }
    add_action( 'wp_enqueue_scripts', 'gray_script_style' );

    //setup the theme and register the header and feed links
    function gray_setup()
    {
        // Add RSS links to <head> section
        add_theme_support( 'automatic-feed-links' );


        add_theme_support( 'custom-header', array(
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
        ));

    }
    add_action( 'after_setup_theme', 'gray_setup' );

    function gray_admin_menu()
    {
        include_once "admin/homeOptions.php";
        add_theme_page('gray home page', 'Theme Options', 'read', 'home', 'gray_home_options_page');
    }
    add_action('admin_menu','gray_admin_menu');


?>