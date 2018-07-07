jQuery('.ade-homepage-widgets-choose-new').change(function() {
    var item = jQuery(this).closest('table');
    var date = item.find('input.ade-homepage-widgets-datefield');
    var d = new Date();
    var n = d.toISOString();
    date.val( n );
  });
