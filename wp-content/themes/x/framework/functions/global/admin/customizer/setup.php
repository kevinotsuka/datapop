<?php

// =============================================================================
// FUNCTIONS/GLOBAL/ADMIN/CUSTOMIZER/SETUP.PHP
// -----------------------------------------------------------------------------
// Initializes and sets up the WordPress Live Preview feature by including
// sections, controls, and settings.
//
// - Sections: organize the controls.
// - Controls: receive input and pass it to the settings.
// - Settings: interface with the existing options in the theme.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Set Path
//   02. Require Files
//   03. Remove Unused Sections and Controls
//   04. Preloader
// =============================================================================

// Set Path
// =============================================================================

$cstm_path = X_TEMPLATE_PATH . '/framework/functions/global/admin/customizer';



// Require Files
// =============================================================================

require_once( $cstm_path . '/controls.php' );
require_once( $cstm_path . '/fonts.php' );
require_once( $cstm_path . '/register.php' );
require_once( $cstm_path . '/output.php' );
require_once( $cstm_path . '/tools.php' );
require_once( $cstm_path . '/transients.php' );



// Remove Unused Sections and Controls
// =============================================================================

function x_remove_customizer_sections( $wp_customize ) {

  $wp_customize->remove_section( 'nav' );
  $wp_customize->remove_section( 'colors' );
  $wp_customize->remove_section( 'title_tagline' );
  $wp_customize->remove_section( 'background_image' );
  $wp_customize->remove_section( 'static_front_page' );

  $wp_customize->remove_control( 'blogname' );
  $wp_customize->remove_control( 'blogdescription' );
  $wp_customize->remove_control( 'nav_menu_locations[primary]' );
  $wp_customize->remove_control( 'nav_menu_locations[footer]' );

}

add_action( 'customize_register', 'x_remove_customizer_sections' );



// Preloader
// =============================================================================

function x_customizer_preloader() {
  echo '<style type="text/css"> @import url("//fonts.googleapis.com/css?family=Lato:100,300"); body { overflow: hidden !important; } #x-customizer-preloader { position: fixed; top: 0; left: 0; right: 0; bottom: 0; text-align: center; background-color: #fff; z-index: 9999999; } #x-customizer-preloader #x-customizer-preloader-inner { display: table; position: absolute; top: 50%; left: 50%; width: 450px; margin: -90px 0 0 -225px; background-repeat: no-repeat; background-position: center 155px; background-color: #fff; } #x-customizer-preloader p.status { display: table-cell; vertical-align: middle; position: relative; padding: 0 0 10px; font-family: Lato, "Helvetica Neue", Helvetica, Arial, sans-serif; line-height: 1.1; color: #333; } #x-customizer-preloader p.status span { position: relative; display: block; z-index: 99999999; } #x-customizer-preloader p.status span.loading { margin-left: -2px; font-size: 84px; font-weight: 100; letter-spacing: -2px; text-transform: uppercase; } #x-customizer-preloader p.status span.step { margin-top: 9px; font-size: 18px; font-weight: 300; } #x-customizer-preloader h1.powered-by { position: absolute; left: 0; right: 0; bottom: 24px; margin-right: -6px; font-size: 14px; font-weight: 300; letter-spacing: 6px; line-height: 1.1; text-transform: uppercase; color: #b5b5b5; } </style><div id="x-customizer-preloader"><div id="x-customizer-preloader-inner"><p class="status"><span class="loading">Loading</span><span class="step">(Step 2 of 2) Initializing Live Preview</span></p></div><h1 class="powered-by">Powered by Theme.co</h1></div>';
}

add_action( 'customize_controls_print_styles', 'x_customizer_preloader' );