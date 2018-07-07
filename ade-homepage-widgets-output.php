<?php

/* ---------------------------------------------------------- *
 * FUNCTION: POSTS_QUERY
 * ---------------------------------------------------------- */
function ade_home_post_query($blog, $post, $image_sizes, $widget, $link) {

  global $originalblogid;

  $blog = strchr($blog, "(", false); //parse string for post ID
    $blog = strchr($blog, ")", true); //parse again
    $blog = ltrim($blog, '(' ); //parse again

  if( is_multisite()){
    if ( strlen($blog) > 0 && $blog !== $originalblogid) {
          $blog_id = $blog; //if so, then make that the blog_id
      } else {
          $blog_id = $originalblogid;
      }

    switch_to_blog ($blog_id); // select correct blog, whether current or other
  }

  $args = array(
    'p' => $post,
    'post_type' => array( 'post', 'ai1ec_event' )
 );

  $newquery = new WP_Query( $args ); // query for post content

    while ( $newquery->have_posts() ): $newquery->the_post();

        $title = get_the_title();

        if ( strlen($link) > 0 ) { // see if optional link has been passed (features does not pass a value)
          $uselink = $link;
          if (strpos($uselink, ":") > 0) { //see if passed link includes http, if not add it
            $uselink = $uselink;
          } elseif ( $uselink == 'empty') { // see if is 'empty' placeholder
            $uselink = get_permalink();
          } else { // if no http and not 'empty', construct url
            $uselink = "http://".$uselink."";
          }
        } else { //if no link passed, use permalink from post
          $uselink = get_permalink();
        }

        $post_object .= '<div class="post-wrap">';

          $post_object .= '<a href="'.$uselink.'" title="'.$title.'" class="ade-home-slider-image slider-'.$widget.'">'.get_the_post_thumbnail($post_id, $image_sizes[0] ).'</a>'; //image


          $post_object .= '<div class="overlay">'; //create overlay
            $post_object .= '<a href="'.$uselink.'" title="'.$title.'" class="slider-'.$widget.'"><h4 class="ade-home-overlay-title">'.$title.'</h4></a>';
            $post_object .= '</div>'; //close overlay

        $post_object .= '</div>'; //close

      $index_object .= get_the_post_thumbnail( $post_id, $image_sizes[1] );

    endwhile;

  if( ms_is_switched() == true ){  //switch back to original blog
    switch_to_blog($originalblogid);
  }

    wp_reset_postdata();

    return array('boxslider' => $post_object, 'pager' => $index_object, 'title' => $title );

} // end post_query()



/* ---------------------------------------------------------- *
 * FEATURES WIDGET
 * ---------------------------------------------------------- */
function ade_home_features_widget( $atts ){

  extract( shortcode_atts( array(), $atts));

  //get settings from Features menu page
  $setting = (array) get_option( 'ade_home_features_settings' );
  $prefix = 'ade_home_features_';

  $blogs = array();
    for ($counter = 0; $counter<=7; $counter++) {
      $num = $counter +1 ;
      $which = $prefix.$num;
      $which .= '_1';
      $value = esc_attr( $setting[$which]);
      if ($value != '') {
        $blogs[] = $value;
      } else {
        $blogs[] = 'empty';
      }
    }

    $posts = array();
      for ($counter = 0; $counter<=7; $counter++) {
        $num = $counter +1 ;
        $which = $prefix.$num;
        $which .= '_2';
        $value = esc_attr( $setting[$which]);
        if ($value != '') {
          $posts[] = $value;
        } else {
          $posts[] = 'empty';
        }
      }

  $features_images = array( 'ade-home-features-image-largest', 'ade-home-features-image-small' );

  $widget = 'features'; // becomes part of identifying class used for analytics

  //call ade_home_features_post_query() for each settings pair where $post is not empty
  $outputs = array();
    for ($counter = 0; $counter<=7; $counter++) {
      if ( $posts[$counter] != 'empty' ) {
        $outputs[] = ade_home_post_query( $blogs[$counter], $posts[$counter], $features_images, $widget);
      } else {
        $outputs[] = 'empty';
      }
    }

  $numslides = count($outputs);

   //build the boxslider object
   $boxslider = '<ul id="ade-home-features-slider" class="bxslider">';

   for ($counter = 0; $counter<$numslides; $counter++) {
     $this_output = $outputs[$counter];
     if ($this_output != 'empty') {
       $boxslider .= '<li>'.$this_output['boxslider'].'</li>';
     }
   }
   $boxslider .= '</ul>'; //close out boxslider object

  $slideindexcounter = 0;

  $pager = '<div id="ade-home-features-pager" class="features-pager">';  //build the pager object
    for ($counter = 0; $counter<$numslides; $counter++) {
      $this_output = $outputs[$counter];
      if ($this_output != 'empty') {
        if( $counter != 0 ) {
            $slideindexcounter = $slideindexcounter + 1;
          }
        $pager .= '<a data-slide-index="'.$slideindexcounter.'" href="" title="'.$this_output['title'].'" aria-label="slide '.$slideindexcounter.'" class="slider-'.$widget.'-thumb">'.$this_output['pager'].'</a>';
      }
    }
  $pager .= '</div>';  //close the pager object

  $final = '<section id="ade-home-features-widget" aria-labelledby="featureslidertitle"><h2 id="featureslidertitle" class="screen-reader-text">Featured Articles</h2>'; //create features-widget div
  $final .= $boxslider;
  $final .= $pager;
  $final .= '</section>';
  return $final;

} // END features_widget()

add_shortcode( 'ade-homepage-widgets-features', 'ade_home_features_widget');


  /* ---------------------------------------------------------- *
   * ANNOUNCEMENTS WIDGET
   * ---------------------------------------------------------- */

   function ade_home_announcements_widget( $atts ){

   //get settings
     $setting = (array) get_option( 'ade_home_announcements_settings' );
     $prefix = 'ade_home_announcements_';

     $blogs = array();
       for ($counter = 0; $counter<=7; $counter++) {
         $num = $counter +1 ;
         $which = $prefix.$num;
         $which .= '_1';
         $value = esc_attr( $setting[$which]);
         if ($value != '') {
           $blogs[] = $value;
         } else {
           $blogs[] = 'empty';
         }
       }

    $posts = array();
      for ($counter = 0; $counter<=7; $counter++) {
        $num = $counter +1 ;
        $which = $prefix.$num;
        $which .= '_2';
        $value = esc_attr( $setting[$which]);
        if ($value != '') {
          $posts[] = $value;
        } else {
          $posts[] = 'empty';
        }
      }

    $links = array();
      for ($counter = 0; $counter<=7; $counter++) {
        $num = $counter +1 ;
        $which = $prefix.$num;
        $which .= '_4';
        $value = esc_attr( $setting[$which]);
        if ($value != '') {
          $links[] = $value;
        } else {
          $links[] = 'empty'; //must add 'empty' to keep arrays aligned
        }
      }


     $announcements_images = array( 'ade-home-announcements-image-largest', 'ade-home-announcements-image-small' );

     $widget = 'announcements';  // becomes part of identifying class used for analytics

     //call ade_home_post_query() for each settings pair where $post is not empty
     $outputs = array();
       for ($counter = 0; $counter<=7; $counter++) {
         if ( $posts[$counter] != 'empty' ) {
             $outputs[] = ade_home_post_query( $blogs[$counter], $posts[$counter], $announcements_images, $widget, $links[$counter] );
         } else {
           $outputs[] = 'empty';
         }
       }

    $numslides = count($outputs);

     //build the boxslider object
     $boxslider = '<ul id="ade-home-announcements-slider" class="bxslider">';

     for ($counter = 0; $counter<$numslides; $counter++) {
       $this_output = $outputs[$counter];
       if ($this_output != 'empty') {
         $boxslider .= '<li>'.$this_output['boxslider'].'</li>';
       }
     }
     $boxslider .= '</ul>'; //close out boxslider object

     $pager = '<div id="ade-home-announcements-pager">';  //build the pager object
        $pager .= '<div id="stopstart"></div><div id="ade-home-announce-prev-one"></div>';

      $slideindexcounter = 0;

        for ($counter = 0; $counter<$numslides; $counter++) {
          $this_output = $outputs[$counter];
          if ($this_output != 'empty') {
            if( $counter != 0 ) {
                $slideindexcounter = $slideindexcounter + 1;
              }
            $pager .= '<a href="" data-slide-index='.$slideindexcounter.'" class="ade-home-announce-pager-link" aria-label="slide '.$slideindexcounter.'"><i class="fa fa-circle"></i></a>';
          } else {}
        }

        $pager .= '<div id="ade-home-announce-next-one"></div>';
        $pager .= '</div>';  //close the pager object

     $final .= $boxslider;
     $final .= $pager;

     return $final;

   } // END announcements_widget()


//SHORTCODE
add_shortcode( 'ade-homepage-widgets-announcements', 'ade_home_announcements_widget');

/* ---------------------------------------------------------- *
 * FUNCTION: HEADLINES WIDGET
 * ---------------------------------------------------------- */
function ade_home_widgets_headlines_query( $blog, $category, $number ) {

  global $originalblogid;

  $number = intval($number);

  $blog = strchr($blog, "(", false); //parse string for post ID
    $blog = strchr($blog, ")", true); //parse again
    $blog = ltrim($blog, '(' ); //parse again

  if( is_multisite()){
    if ( strlen($blog) > 0 && $blog !== $originalblogid) {
          $blog_id = $blog; //if so, then make that the blog_id
      } else {
          $blog_id = $originalblogid;
      }

    switch_to_blog ($blog_id); // select correct blog, whether current or other
  }

  $args = array(
    'category_name' => $category,
    'posts_per_page' => $number,
    'post_status' => 'publish'
  );

  $newquery = new WP_Query( $args ); // query for post content

    while ( $newquery->have_posts() ): $newquery->the_post();
      $postid = get_the_ID();
      $title = get_the_title();
      $link = get_permalink();
      $date = get_the_date('F j, Y');
      $post_object .= '<li id="'.$postid.'" class="ade-home-headlines-item"><a href="'.$link.'" class="headlines-link">'.$title.'</a>  <span style="font-style:italic; font-size:90%;">('.$date.')</span></li>';
    endwhile;

    if( ms_is_switched() == true ){  //switch back to original blog
      switch_to_blog($originalblogid);
    }

    wp_reset_postdata();

    return $post_object;

} //end Headlines Widget Query

function ade_home_widgets_headlines() {

  $setting = (array) get_option( 'ade_home_headlines_settings' );
  $prefix = 'ade_home_headlines_';

  $blog = esc_attr( $setting[$prefix.'1_1']);
  $category = esc_attr( $setting[$prefix.'1_2']);
  $number = esc_attr( $setting[$prefix.'1_3']);

  $widget_output = ade_home_widgets_headlines_query( $blog, $category, $number);

  $ourwidget = '<div class="category-widget"><div class="innerborder"><h3 id="headlinestitle">Latest Headlines</h3><ul>'.$widget_output.'</ul></div></div>';

  return $ourwidget;
}

//SHORTCODE
add_shortcode( 'ade-homepage-widgets-headlines', 'ade_home_widgets_headlines');


/* ---------------------------------------------------------- *
 * BOX WIDGET
 * ---------------------------------------------------------- */

 function ade_home_widgets_box( $atts ){

   //extract shortcode attributes
    extract( shortcode_atts( array(
      'box' => ''  // 'box' attribute should equal distinguishing number in settings section slug from add_settings_section()
    ), $atts));

    $setting = (array) get_option( 'ade_home_blog_corner_settings');

   $prefix = 'ade_home_blog_corner_box_';
   $prefix .= $box;
   $prefix .= '_';

   $blog = esc_attr( $setting[$prefix.'1'] );
   $post = esc_attr( $setting[$prefix.'2'] );
   $icon = esc_attr( $setting[$prefix.'4'] );
   $text = esc_attr( $setting[$prefix.'5'] );
   $image = 'ade-home-box-widget-image';

   $boxwidget = '<div id="box'.$box.'" class="box-widget"><div id="banner-'.$box.'" class="box-widget-banner box-widget-top"><i class="fa fa-'.$icon.' fa-lg"></i> '.$text.'</div><div class="box-widget-post">';

   global $originalblogid;

   $blog = strchr($blog, "(", false); //parse string for post ID
     $blog = strchr($blog, ")", true); //parse again
     $blog = ltrim($blog, '(' ); //parse again

   if( is_multisite()){
     if ( strlen($blog) > 0 && $blog !== $originalblogid) {
           $blog_id = $blog; //if so, then make that the blog_id
       } else {
           $blog_id = $originalblogid;
       }
     switch_to_blog ($blog_id); // select correct blog, whether current or other
   }

 $args = array(
 'p' => $post,
 'post_type' => array( 'post', 'ai1ec_event' )
  );


   $newquery = new WP_Query( $args ); // query for post content

     while ( $newquery->have_posts() ): $newquery->the_post();

           $title = get_the_title();

           $boxwidget .= '<a href="'.get_permalink().'" title="'.$title.'" class="boxwidget-post-thumb">'.get_the_post_thumbnail( $post_id, $image ).'</a>'; //image

           $boxwidget .= '<div class="box-widget-overlay">'; //create overlay
           $boxwidget .= '<a href="'.get_permalink().'" title="'.$title.'" class="boxwidget-post-title"><h4>'.$title.'</h4></a>';
           $boxwidget .= '</div>'; //close overlay

     endwhile;

     wp_reset_postdata();

     if( ms_is_switched() == true ){  //switch back to original blog
       switch_to_blog($originalblogid);
     }

  //  $box_widget_query_output = box_widget_query( $blog, $post, $image );

   $boxwidget .= '</div></div>';

   return $boxwidget;

 } // END
 //SHORTCODE
 add_shortcode( 'ade-homepage-widgets-box', 'ade_home_widgets_box');

 /* ---------------------------------------------------------- *
  * FUNCTION: QUICK LINKS
  * ---------------------------------------------------------- */
 function ade_home_widgets_quicklinks() {


   $setting = (array) get_option( 'ade_home_quicklinks_settings' );
   $prefix = 'ade_home_quicklinks_';

   $icons = array();
   $links = array();
   $titles = array();

   for ($counter = 0; $counter<=5; $counter++) {
     $num = $counter + 1;
     $iteration = $prefix.$num;
     $icon_field = $iteration.'_1';
     $link_field = $iteration.'_2';
     $title_field = $iteration.'_3';
     $icons[] = esc_attr( $setting[$icon_field]);
     $links[] = esc_attr( $setting[$link_field]);
     $titles[] = esc_attr( $setting[$title_field]);
   }

   $numicons = count($icons);
   $quicklinks = '';
   for ($counter = 0; $counter <= $numicons; $counter++) {
     if ( $icons[$counter] != '' ) {
       $quicklinks .= '<div class="quicklink"><a href="'.$links[$counter].'" title="'.$titles[$counter].'" class="quicklink-link"><i class="fa fa-3x fa-'.$icons[$counter].'"></i><br class="donotfilter"><span class="quicklink-title">'.$titles[$counter].'</span></a></div>';
     }
   }

  return $quicklinks;
 }

 //SHORTCODE
 add_shortcode( 'ade-homepage-widgets-quicklinks', 'ade_home_widgets_quicklinks');


 /* ---------------------------------------------------------- *
  * FUNCTION: STATIC MESSAGE
  * ---------------------------------------------------------- */
 function ade_home_widgets_message() {

   $setting = (array) get_option( 'ade_home_message_settings' );
   $prefix = 'ade_home_message_1_';

   $text = esc_attr( $setting[$prefix.'1']);
   $link = esc_attr( $setting[$prefix.'2']);

   $message = '';

   if ( strlen($text) > 0 ) {
     $message .= '<section aria-labelledby="staticmessage" class="staticmessagesection"><div id="staticmessage"><div class="staticmessagetext"><a href="'.$link.'" title="'.$text.'" class="staticmessage-link">'.$text.'</a></div><a class="link-as-button-wrap link-as-button button-medium bright_blue text-center staticmessagebutton" href="'.$link.'" title="'.$text.'">Learn More</a></div></section>';
   }
   else {
   }

   return $message;
 }
 //SHORTCODE
 add_shortcode( 'ade-homepage-widgets-message', 'ade_home_widgets_message');

?>
