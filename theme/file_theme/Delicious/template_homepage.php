<?php
/**
* Template Name: Homepage
 *
 *
 * @package bcomponent
 */

get_header();
?>

<main id="main">

<?php
while ( have_posts() ) :
    the_post();

    the_content();


endwhile; // End of the loop.
?>

</main><!-- #main -->


<?php
get_footer();