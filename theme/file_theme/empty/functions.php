<?php


if ( ! function_exists( '!######!_theme_setup' ) ) :
    function !######!_theme_setup(){
        // Custom menu areas
		register_nav_menus( array(
            'header' => esc_html__( 'Header', '!######!' )
        ) );

        add_theme_support( 'align-wide' );

        // Enable featured image
		add_theme_support( 'post-thumbnails' );

        add_theme_support( "title-tag" );
        /*  Remove P in description output
        /* ------------------------------------ */
        remove_filter('term_description','wpautop');

        add_post_type_support( 'page', 'excerpt' );
        add_theme_support( 'woocommerce' );
        
        function !######!_enable_more_buttons($buttons) {
            $buttons[] = 'hr';
            return $buttons;
        }
        add_filter("mce_buttons", "!######!_enable_more_buttons");
      
        // Thumbnail sizes
        add_image_size( 'image_thumb', 350, 350, true ); //(cropped)
        add_image_size( 'image_single', 1200, 675, true ); 	//(cropped)
        add_image_size( 'image_big', 1400, 928, true ); 	//(cropped)
        add_image_size( 'image_HD', 1920, 1080, true ); 	//(cropped)

        add_filter( 'image_size_names_choose', '_custom_sizes_for_gut' );
 
        function _custom_sizes_for_gut( $sizes ) {
            return array_merge( $sizes, array(
                'image_thumb' => __( 'Thumb' ),
                'image_single' => __( 'Single' ),
                'image_big' => __( 'Big' ),
                'image_HD' => __( 'HD' )
            ) );
        }

        /*  Register sidebars
        /* ------------------------------------ */
        if ( ! function_exists( '!######!_sidebars' ) ) {

            function !######!_sidebars()	{
                
                register_sidebar(array( 
                    'name' => esc_html__( 'Primary', '!######!' ),
                    'id' => 'sidebar',
                    'description' => esc_html__( 'Normal full width sidebar.', '!######!' ), 
                    'before_widget' => '<section id="%1$s" class="widget %2$s">',
                    'after_widget' => '</section>',
                    'before_title' => '<h4 class="widget-title">',
                    'after_title' => '</h4>'
                ));
                register_sidebar(array( 
                    'name' => esc_html__( 'shop-sidebar', '!######!' ),
                    'id' => 'shop-sidebar',
                    'description' => esc_html__( 'shop-sidebar.', '!######!' ), 
                    'before_widget' => '<section id="%1$s" class="widget %2$s">',
                    'after_widget' => '</section>',
                    'before_title' => '<h4 class="widget-title">',
                    'after_title' => '</h4>'
                ));
                register_sidebar(array( 
                    'name' => esc_html__( 'Footer 1', '!######!' ),
                    'id' => 'footer1',
                    'description' => esc_html__( 'Footer 1.', '!######!' ), 
                    'before_widget' => '<div id="%1$s" class="%2$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<h6>',
                    'after_title' => '</h6>'
                ));
                register_sidebar(array( 
                    'name' => esc_html__( 'Footer 2', '!######!' ),
                    'id' => 'footer2',
                    'description' => esc_html__( 'Footer 2.', '!######!' ), 
                    'before_widget' => '<div id="%1$s" class="%2$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<h6>',
                    'after_title' => '</h6>'
                ));
                register_sidebar(array( 
                    'name' => esc_html__( 'Footer 3', '!######!' ),
                    'id' => 'footer3',
                    'description' => esc_html__( 'Footer 3.', '!######!' ), 
                    'before_widget' => '<div id="%1$s" class="%2$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<h6>',
                    'after_title' => '</h6>'
                ));
                
            }

        }
        add_action( 'widgets_init', '!######!_sidebars' );
    }
    add_action( 'after_setup_theme', '!######!_theme_setup' );
endif;

if ( ! function_exists( '!######!_enqueue' ) ) :
    add_action( 'wp_enqueue_scripts', '!######!_enqueue' );
    function !######!_enqueue() {

        /** JS **/
        wp_enqueue_script( '!######!-bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array( 'jquery' ),'', true );
        wp_enqueue_script( '!######!-bootstrap-select', 'https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js', array( 'jquery' ),'', true  );
                
        wp_enqueue_script( '!######!-front-script', get_template_directory_uri() . '/assets/js/script.js', array( 'jquery' ),'', true );

        /** CSS **/
		wp_enqueue_style( '!######!-style-normalize', get_template_directory_uri().'/assets/css/normalize.css');
        wp_enqueue_style( '!######!-bootstrap-css', get_template_directory_uri().'/assets/css/bootstrap.min.css');
        
		wp_enqueue_style( '!######!-front-style', get_template_directory_uri().'/assets/css/style.css');
        
        //wp_enqueue_script( '!######!-front-script', get_template_directory_uri() . '/namefile.js', array( 'jquery' ),'', true );
		//wp_enqueue_style( '!######!-style', get_template_directory_uri().'/namefile.css');
   }
endif;