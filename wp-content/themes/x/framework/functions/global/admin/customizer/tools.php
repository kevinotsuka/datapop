<?php 

// =============================================================================
// FUNCTIONS/GLOBAL/ADMIN/CUSTOMIZER/TOOLS.PHP
// -----------------------------------------------------------------------------
// Sets up various tools to use for the Customizer.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Turn on Output Buffering
//   02. Add Tools to "Available Tools" Page
//   03. Import Tool
//   04. Export Tool
//   05. Reset Tool
// =============================================================================

// Turn on Output Buffering
// =============================================================================

ob_start();



// Add Sections to "Available Tools" Page
// =============================================================================

function x_customizer_add_tools() {

  if ( current_user_can( 'edit_theme_options' ) ) { ?>

    <div class="tool-box x-customizer">
      <h3 class="title">X &ndash; Customizer Tools</h3>
      <?php x_customizer_import_tool(); ?>
      <?php x_customizer_export_tool(); ?>
      <?php x_customizer_reset_tool(); ?>
    </div>

  <?php }

}

add_action( 'tool_box', 'x_customizer_add_tools' );



// Import Tool
// =============================================================================

//
// Functionality.
//

function x_customizer_import() {

  if ( isset( $_FILES['import'] ) && check_admin_referer( 'x-customizer-import' ) ) {
    if ( $_FILES['import']['error'] > 0 ) {
      wp_die( 'An import error occured. Please try again.' );
    } else {
      $file_name  = $_FILES['import']['name'];
      $file_array = explode( '.', $file_name );
      $file_ext   = strtolower( end( $file_array ) );
      $file_size  = $_FILES['import']['size'];
      if ( ( $file_ext == 'json' ) && ( $file_size < 500000 ) ) {
        $encoded_options = file_get_contents( $_FILES['import']['tmp_name'] );
        $options         = json_decode( $encoded_options, true );
        foreach ( $options as $key => $value ) {
          update_option( $key, $value );
        }
        echo '<div class="updated"><p><strong>Huzzah!</strong> All Customizer settings were successfully restored!</p></div>';
      } else {
        echo '<div class="error"><p><strong>Uh oh.</strong> Invalid file type provided or file size too big. Please try again.</p></div>';
      }
    }
  }

}


//
// Output.
//

function x_customizer_import_tool() { ?>

  <div class="import-export-reset import">
    <?php x_customizer_import(); ?>
    <h3 class="title">Import</h3>
    <form method="post" enctype="multipart/form-data">
      <?php wp_nonce_field( 'x-customizer-import' ); ?>
      <p>Howdy! Upload your X Customizer Settings (XCS) file and we&apos;ll import the options into this site.</p>
      <p>Choose a XCS (.json) file to upload, then click "Upload File and Import."</p>
      <p>Choose a file from your computer: <input type="file" id="x-customizer-import" name="import"></p>
      <p class="submit">
        <input type="submit" name="submit" id="x-customizer-import-submit" class="button" value="Upload File and Import" disabled>
      </p>
    </form>
  </div>

<?php }



// Export Tool
// =============================================================================

//
// Functionality.
//

function x_customizer_export() {

  $blogname  = strtolower( str_replace( ' ', '-', get_option( 'blogname' ) ) );
  $file_name = $blogname . '-xcs';
  $options   = x_customizer_options_list();

  foreach ( $options as $key ) {
    $value      = maybe_unserialize( get_option( $key ) );
    $data[$key] = $value;
  }

  $json_data = json_encode( $data );


  //
  // We wrap the content of our JSON data with ob_clean() and exit() to ensure
  // that $json_data doesn't contain any extra data. This works in conjunction
  // with ob_start() at the top of the file, which prevents header errors from
  // occuring (i.e. extra whitespace somewhere in the code).
  //

  ob_clean();

  echo $json_data;

  header( 'Content-Type: text/json; charset=' . get_option( 'blog_charset' ) );
  header( 'Content-Disposition: attachment; filename="' . $file_name . '.json"' );

  exit();

}


//
// Output.
//

function x_customizer_export_tool() {

  if ( ! isset( $_POST['export'] ) ) {

  ?>

    <div class="import-export-reset export">
      <h3 class="title">Export</h3>
      <form method="post">
        <?php wp_nonce_field( 'x-customizer-export' ); ?>
        <p>When you click the button below WordPress will create a JSON file for you to save to your computer.</p>
        <p>This format, which we call X Customizer Settings or XCS, will contain your Customizer settings for X.</p>
        <p>Once you&apos;ve saved the download file, you can use the Customizer Import section to import the previusly exported settings.</p>
        <p class="submit">
          <input type="submit" name="export" class="button button-primary" value="Download XCS File">
        </p>
      </form>
    </div>

  <?php

  } elseif ( check_admin_referer( 'x-customizer-export' ) ) {
    x_customizer_export();
  }

}



// Reset Tool
// =============================================================================

//
// Functionality.
//

function x_customizer_reset() {

  if ( isset( $_POST['reset'] ) && check_admin_referer( 'x-customizer-reset' ) ) {

    $options = x_customizer_options_list();

    foreach ( $options as $option ) {
      delete_option( $option );
    }

    echo '<div class="updated"><p>All Customizer settings were successfully <strong>reset</strong>.</p></div>';

  }

}


//
// Output.
//

function x_customizer_reset_tool() { ?>

  <div class="import-export-reset reset">
    <?php x_customizer_reset(); ?>
    <h3 class="title">Reset</h3>
    <form method="post">
      <?php wp_nonce_field( 'x-customizer-reset' ); ?>
      <p>When you click the button below WordPress will reset your Customizer settings as if it were a brand new installation.</p>
      <p>Be extremely careful using this option as there is no way to revert this option once it has been made unless you previously exported your settings to use as a backup.</p>
      <p>To reset your options, select the checkbox next to the button to indicate you have read the information above then click the "Reset Customizer Settings" button.</p>
      <p class="submit">
        <input type="submit" name="reset" id="x-customizer-reset-submit" class="button" value="Reset Customizer Settings" disabled>
        <input type="checkbox" id="x-customizer-reset-confirm">
      </p>
    </form>
  </div>

<?php }