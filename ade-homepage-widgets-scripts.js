// Features Slider - bxSlider
jQuery(document).ready(function( $ ){
  $('#ade-home-features-slider').bxSlider({
      autoStart: false,
      pagerCustom: '#ade-home-features-pager',
      preloadImages: 'visible',
      touchEnabled: true
  }); //end bxSlider() for #features-slider
});

// Announcements Slider - bxSlider
jQuery(document).ready(function( $ ){
$('#ade-home-announcements-slider').bxSlider({
      auto: true,
      autoStart: true,
      pause: 5000,
      controls: true,
      infiniteLoop: true,
      preloadImages: 'visible',
      autoHover: true,
      touchEnabled: true,
      autoControls: true,
      startText: '<span class="screen-reader-text">play</span><i class="fa fa-play"></i>',
      stopText: '<span class="screen-reader-text">pause</span><i class="fa fa-pause"></i>',
      autoControlsSelector: '#stopstart',
      autoControlsCombine: true,
      nextSelector: '#ade-home-announce-next-one',
      prevSelector: '#ade-home-announce-prev-one',
      nextText: '<span class="screen-reader-text">next</span><i class="fa fa-hand-o-right"></i>',
      prevText: '<span class="screen-reader-text">previous</span><i class="fa fa-hand-o-left"></i>',
      pagerCustom: '#ade-home-announcements-pager'
  }); //end bxSlider() for #announcements-slider
});



jQuery(window).on('load', function ( ) {
  jQuery('iframe[id^=twitter-widget-2]').each(function ( ) {
    var head = jQuery(this).contents().find('head');
    if (head.length) {
      head.append('<style>.timeline {max-width: 100% !important; width: 100% !important;} .timeline .stream { max-width: none !important; width: 100% !important;}</style>');
    }
    jQuery('#twitter-widget-2').append(jQuery('<div class=timeline>') );
  })
});
