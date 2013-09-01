<?php
	require "admin/homeOptions.php";

    if ( ! isset( $content_width ) )
    $content_width = 1000;

	// Add RSS links to <head> section
	add_theme_support( 'automatic-feed-links' );
	
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

    function gray_customizer_preview(){
        ?>
        //test
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


?>