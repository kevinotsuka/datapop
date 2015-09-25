<?php

// =============================================================================
// VIEWS/RENEW/TEMPLATE-LAYOUT-PORTFOLIO.PHP
// -----------------------------------------------------------------------------
// Portfolio page output for Renew.
// =============================================================================

?>

<?php get_header(); ?>

  <div class="x-container max width offset">
    <div class="<?php x_main_content_class(); ?>" role="main">
<div class="k-content">
<?php x_get_view( 'global', '_content', 'the-content' ); ?>

<div class="options">
      <ul class= "unstyled">
        <li>
          <ul class="x-portfolio-filters-menu-2 unstyled">
          <div class="option-set" data-option-key="type">
          <li><h5 class="filter-header">Mission Areas</h5></li>
            <li><a href="#" data-option-value="" class="x-portfolio-filter x-btn selected"><?php _e( 'All', '__x__' ); ?></a></li>
              <li><a href="#" data-option-value=".x-portfolio-b94ad99e5dc27b3365d5d2aa77d73ff0" class="x-portfolio-filter x-btn">Advocacy</a></li>
              <li><a href="#" data-option-value=".x-portfolio-7412df2b1db8cd2a5d4aafdb6c2090d3" class="x-portfolio-filter x-btn">Research</a></li>
              <li><a href="#" data-option-value=".x-portfolio-c185ddac8b5a8f5aa23c5b80bc12d214" class="x-portfolio-filter x-btn">Training</a></li>
         </div>
          </ul>
        </li>
      </ul>
    </div>
   </div>
      <?php x_get_view( 'global', '_portfolio' ); ?>

    </div>

    <?php get_sidebar(); ?>

  </div>

<?php get_footer(); ?>

