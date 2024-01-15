<?php
/**
 *
 * @since bcomponent
 */

get_header();

?>
 <main id="main">
    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-end align-items-center">
          
          <ol>
            <li><a href="index.html">Home</a></li>
            <li>Inner Page</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs Section -->
    <div class="container">
        <br>
    <?php
    if ( have_posts() ) :

        if ( is_home() && ! is_front_page() ) :
            ?>
            <header>
                <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
            </header>
            <?php
        endif;

        /* Start the Loop */
        while ( have_posts() ) :
            the_post();

            /*
            * Include the Post-Type-specific template for the content.
            * If you want to override this in a child theme, then include a file
            * called content-___.php (where ___ is the Post Type name) and that will be used instead.
            */
            if(is_single()) :
                get_template_part( 'template-parts/content', 'single' );
            elseif(is_archive()):
                get_template_part( 'template-parts/content', 'archive' );
            elseif(is_page()) :
                get_template_part( 'template-parts/content', 'page' );
            else:
                get_template_part( 'template-parts/content', get_post_type() );
            endif;

        endwhile;
        if (function_exists('wp_pagenavi')){wp_pagenavi();};

    else :

        get_template_part( 'template-parts/content', 'none' );

    endif;
    ?>

    </div>

</main><!-- #main -->


<?php
//get_sidebar();
get_footer(); ?>