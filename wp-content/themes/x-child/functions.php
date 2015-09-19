<?php

// =============================================================================
// FUNCTIONS.PHP
// -----------------------------------------------------------------------------
// Overwrite or add your own custom functions to X in this file.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Enqueue Parent Stylesheet
//   02. Additional Functions
// =============================================================================

// Enqueue Parent Stylesheet
// =============================================================================

add_filter( 'x_enqueue_parent_stylesheet', '__return_true' );


// Additional Functions
// =============================================================================

function x_filter_by_category( $query ) {
if ( $query->is_home() && $query->is_main_query() && isset($_GET['cat_select']) ) {
$query->set( 'cat', implode( ',', $_GET['cat_select'] ) );
}
}
add_action('pre_get_posts', 'x_filter_by_category');