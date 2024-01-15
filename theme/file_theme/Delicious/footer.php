<?php
/**
 * Footer template for easyParent
 *
 * 
 *
 * @package easyParent
 */
?>

<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="container">
        <?php
            if(is_active_sidebar('footer1')){
                dynamic_sidebar('footer1');
            }
        ?>
      </div>
      <div class="copyright">
      <?php
            if(is_active_sidebar('footer2')){
                dynamic_sidebar('footer2');
            }
        ?>
      </div>
      <div class="credits">
        <?php
            if(is_active_sidebar('footer3')){
                dynamic_sidebar('footer3');
            }
        ?>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


  <?php wp_footer();?>

</body>

</html>