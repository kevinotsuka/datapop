<?php

// =============================================================================
// VIEWS/GLOBAL/_SCRIPT-ISOTOPE-PORTFOLIO.PHP
// -----------------------------------------------------------------------------
// Isotope script call for portfolio output.
// =============================================================================

$stack  = x_get_stack();
$is_rtl = is_rtl();

?>

<script>

  jQuery(document).ready(function($) {

    <?php if ( $is_rtl ) : ?>

      $.Isotope.prototype._positionAbs = function( x, y ) {
        return { right: x, top: y };
      };

    <?php endif; ?>

    var $container   = $('#x-iso-container');
    var $optionSets  = $('.option-set');
    var $optionLinks = $optionSets.find('a');

    $container.before('<span id="x-isotope-loading"><span>');

    $(window).load(function() {
      $container.isotope({
        itemSelector   : '.x-iso-container > .hentry',
        resizable      : true,
        filter         : '*',
        <?php if ( $is_rtl ) : ?>
          transformsEnabled : false,
        <?php endif; ?>
        containerStyle : {
          overflow : 'hidden',
          position : 'relative'
        }
      });
      $('#x-isotope-loading').stop(true,true).fadeOut(300);
      $('#x-iso-container > .hentry').each(function(i) {
        $(this).delay(i * 150).animate({'opacity' : 1},500);
      });
    });

    $(window).smartresize(function() {
      $container.isotope({  });
    });

    var options = {};//moving options up here outside of function

    $optionLinks.click(function() {
      var $this = $(this);//this = this
      //if ( $this.hasClass('selected') ) {
        //return false;
      //}
      var $optionSet = $this.parents('.option-set');//set parent
      //$optionSet.find('.selected');
      //$this.addClass('selected');
      //<?php if ( $stack == 'ethos' ) : ?>//ignore
        //$('.x-portfolio-filter-label').text($this.text());//ignore
      //<?php endif; ?>//ignore
          var key     = $optionSet.attr('data-option-key');//,//set key
          options[ key ]   = $this.attr('data-option-value');//set filter
          var value = concatValues( options );
      //value        = value === 'false' ? false : value;
      //options[key] = value;
      //if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
        //changeLayoutMode( $this, value );
      //} else {
        $container.isotope({filter: value });
      }
      return false;
    });

  // flatten object by concatting values//
  function concatValues( obj ) {
  var value = '';
  for ( var prop in obj ) {
    value += obj[ prop ];
  }
  return value;
  }
  //end custom function//

    $('.x-portfolio-filters').click(function() {
      $(this).parent().find('ul').slideToggle(600, 'easeOutExpo');
    });

  });

</script>