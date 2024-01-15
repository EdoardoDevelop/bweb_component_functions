<?php


if ( ! function_exists( '!######!_theme_setup' ) ) :
    function !######!_theme_setup(){
        // Custom menu areas
		register_nav_menus( array(
            'header' => esc_html__( 'Header', '!######!' )
        ) );

        /*  Remove P in description output
        /* ------------------------------------ */
        remove_filter('term_description','wpautop');
        
        function !######!_enable_more_buttons($buttons) {
            $buttons[] = 'hr';
            return $buttons;
        }
        add_filter("mce_buttons", "!######!_enable_more_buttons");
      

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
        wp_enqueue_script( '!######!-bootstrap', get_template_directory_uri() . '/assets/vendor/bootstrap/js/bootstrap.bundle.min.js', array( 'jquery' ),'', true );
        wp_enqueue_script( '!######!-glightbox', get_template_directory_uri() . '/assets/vendor/glightbox/js/glightbox.min.js', array( 'jquery' ),'', true );
        wp_enqueue_script( '!######!-isotope-layout', get_template_directory_uri() . '/assets/vendor/isotope-layout/isotope.pkgd.min.js', array( 'jquery' ),'', true );
        wp_enqueue_script( '!######!-main', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ),'', true );

        /** CSS **/
        wp_enqueue_style( '!######!-animate-css', 'https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,600,600i,700,700i|Satisfy|Comic+Neue:300,300i,400,400i,700,700i');
        //wp_enqueue_style( '!######!-animate-css', get_template_directory_uri().'/assets/vendor/animate.css/animate.min.css');
        wp_enqueue_style( '!######!-bootstrap-css', get_template_directory_uri().'/assets/vendor/bootstrap/css/bootstrap.min.css');
        wp_enqueue_style( '!######!-bootstrap-icons-css', get_template_directory_uri().'/assets/vendor/bootstrap-icons/bootstrap-icons.css');
        wp_enqueue_style( '!######!-boxicons-css', get_template_directory_uri().'/assets/vendor/boxicons/css/boxicons.min.css');
        wp_enqueue_style( '!######!-glightbox-css', get_template_directory_uri().'/assets/vendor/glightbox/css/glightbox.min.css');
        wp_enqueue_style( '!######!-style-css', get_template_directory_uri().'/assets/css/style.css');
        
   }
endif;