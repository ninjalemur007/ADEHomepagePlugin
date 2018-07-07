<?php
/*
Plugin Name: ADE Homepage Widgets
Description: Set of custom admin pages, settings, and functions with shortcodes for populating the ADE Homepage. Compatible only with azdeptofed.
Version: 1.4.0
Author: C. Walley, Arizona Department of Education
License: GPL
*/


/* ---------------------------------------------------------- *
 * GLOBAL CONSTANTS & UNIVERSALS & UTILITIES
 * ---------------------------------------------------------- */
$originalblogid = get_current_blog_id(); // get current blog ID before entering function


/* ---------------------------------------------------------- *
 * CALL ADMIN OR OUTPUT HALF OF PLUGIN
 * ---------------------------------------------------------- */
if ( ! is_admin() ) {
  ade_home_output_half();
} else {


/* ---------------------------------------------------------- *
 * ADMIN HALF OF PLUGIN - IN-PAGE SCRIPTS BECAUSE ENQUEUE DIDN'T WORK
 * ---------------------------------------------------------- */


  /* ---------------------------------------------------------- *
   * ENQUEUE STYLES and SCRIPTS
   * ---------------------------------------------------------- */
   function ade_home_widgets_admin_stuff() {
      wp_register_style( 'ade-home-widgets-admin-style', plugins_url('ADE Homepage Widgets/wp-admin.css' ) );
      wp_enqueue_style( 'ade-home-widgets-admin-style' );
      wp_enqueue_script( 'ade-homepage-widgets-admin-scripts', plugins_url('ADE Homepage Widgets/ade-homepage-widgets-admin-scripts.js' ), array( 'jquery' ), false, true  );
  }
    add_action( 'admin_enqueue_scripts', 'ade_home_widgets_admin_stuff'  );


  /* ---------------------------------------------------------- *
   * ADMIN MENU PAGES -- FUNCTIONS
   * ---------------------------------------------------------- */

   function ade_home_menu() {
      add_menu_page(
        'ADE Homepage Settings', //page title '$page_title'
        'ADE Homepage', // title in menu bar '$menu_title'
        'administrator', // permissions level '$capability'
        'ade_home_menu', // slug for menu '$menu_slug'
        '', // function to call  '$function' - outputs content for this menu page
        'dashicons-smiley', // icon
        4 //position in dashboard menu
      );
      add_submenu_page( //Featured Posts as first submenu item
        'ade_home_menu', // slug for parent menu '$parent_slug'
        'Features Slider Settings', // page title for tags '$page_title'
        'Features', // menu title '$menu_title'
        'administrator', // permissions level '$capability'
        'ade_home_menu', // slug for menu '$menu_slug'  --> $menu_page_slug
        'ade_home_features_menu_output' // function to call to output page content '$function'
      );
      add_submenu_page( //Announcements
        'ade_home_menu', //top-menu slug
        'Announcements Slider Settings', // page title for tags '$page_title'
        'Announcements', // menu title '$menu_title'
        'administrator', // permissions level
        'ade_home_announcements_menu', // slug for menu
        'ade_home_announcements_menu_output'  // function to call
      );
      add_submenu_page( //Headlines
        'ade_home_menu', //top-menu slug
        'Headlines Widget Settings', // page title for tags '$page_title'
        'Headlines', // menu title '$menu_title'
        'administrator', // permissions level
        'ade_home_headlines_menu', // slug for menu
        'ade_home_headlines_menu_output'  // function to call
      );
      add_submenu_page( //Post ID Lookup
        'ade_home_menu', //top-menu slug
        'Posts Lookup', // page title for tags '$page_title'
        'Post ID Lookup', // menu title '$menu_title'
        'administrator', // permissions level
        'ade_home_post_id_menu', // slug for menu
        'ade_home_post_id_menu_output'  // function to call
      );
      add_submenu_page( //Blog Corner
        'ade_home_menu', //top-menu slug
        'Blog Corner Box Widgets Settings', // page title for tags '$page_title'
        'Blog Corner', // menu title '$menu_title'
        'administrator', // permissions level
        'ade_home_blog_corner_menu', // slug for menu
        'ade_home_blog_corner_menu_output'  // function to call
      );
      add_submenu_page( //Quick Links
        'ade_home_menu', //top-menu slug
        'Quick Links Settings', // page title for tags '$page_title'
        'Quick Links', // menu title '$menu_title'
        'administrator', // permissions level
        'ade_home_quicklinks_menu', // slug for menu
        'ade_home_quicklinks_menu_output'  // function to call
      );
      add_submenu_page( //Static Message
        'ade_home_menu', //top-menu slug
        'Static Message Settings', // page title for tags '$page_title'
        'Message', // menu title '$menu_title'
        'administrator', // permissions level
        'ade_home_message_menu', // slug for menu
        'ade_home_message_menu_output'  // function to call
      );
    } //end function ade_home_menu

  add_action('admin_menu', 'ade_home_menu' );

/* ---------------------------------------------------------- *
 * SETTINGS FIELDS - FEATURES WIDGET
 * ---------------------------------------------------------- */

  function ade_home_widgets_settings_init(){

/***

  FEATURES PAGE of ADE Homepage menu in admin
  Settings for Features slider widget

***/

  //register the below settings
  register_setting(
    'ade_home_features_settings',
    'ade_home_features_settings'
  );  // JUST KEEP THESE THE SAME

   // FEATURES POST 1
      // Page = Features, Section = Post 1
        add_settings_section(
          'ade_home_features_post_1', //$id -- slug used in settings fields  - $section_slug
          'Post 1', // readable title on screen
          'ade_home_features_post_1_callback', // function that echos content under Title
          'ade_home_features_menu' //  $menu_page_slug / slug name of the settings page to show section
        );

      //Page = Features, Section = Post 1, Field = Select Blog
        add_settings_field(
          'ade_home_features_1_1', //ID with ade_home_ prefix
          'Select Blog', // field title
          'ade_home_features_1_1_callback',  //field callback function
          'ade_home_features_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
          'ade_home_features_post_1' // get this from add_settings_section  $section_slug,
        );

      //Page = Features, Section = Post 1, Field = Enter Post ID
        add_settings_field(
          'ade_home_features_1_2', //ID with ade_home_ prefix
          'Enter Post ID', // field title
          'ade_home_features_1_2_callback',  //field callback function
          'ade_home_features_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
          'ade_home_features_post_1' // get this from add_settings_section  $section_slug,
        );

      //Page = Features, Section = Post 1, Field = Last Updated
        add_settings_field(
          'ade_home_features_1_3', //ID with ade_home_ prefix
          'Last Updated', // field title
          'ade_home_features_1_3_callback',  //field callback function
          'ade_home_features_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
          'ade_home_features_post_1' // get this from add_settings_section  $section_slug,
        );

    // FEATURES POST 2
       // Page = Features, Section = Post 2
         add_settings_section(
           'ade_home_features_post_2', //$id -- slug used in settings fields  - $section_slug
           'Post 2', // readable title on screen
           'ade_home_features_post_2_callback', // function that echos content under Title
           'ade_home_features_menu' //  $menu_page_slug / slug name of the settings page to show section
         );

       //Page = Features, Section = Post 1, Field = Select Blog
         add_settings_field(
           'ade_home_features_2_1', //ID with ade_home_ prefix
           'Select Blog', // field title
           'ade_home_features_2_1_callback',  //field callback function
           'ade_home_features_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
           'ade_home_features_post_2' // get this from add_settings_section  $section_slug,
         );

       //Page = Features, Section = Post 1, Field = Select Post
         add_settings_field(
           'ade_home_features_2_2', //ID with ade_home_ prefix
           'Enter Post ID', // field title
           'ade_home_features_2_2_callback',  //field callback function
           'ade_home_features_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
           'ade_home_features_post_2' // get this from add_settings_section  $section_slug,
         );

        //Page = Features, Section = Post 2, Field = Last Updated
           add_settings_field(
             'ade_home_features_2_3', //ID with ade_home_ prefix
             'Last Updated', // field title
             'ade_home_features_2_3_callback',  //field callback function
             'ade_home_features_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_features_post_2' // get this from add_settings_section  $section_slug,
           );

     // FEATURES POST 3
        // Page = Features, Section = Post 3
          add_settings_section(
            'ade_home_features_post_3', //$id -- slug used in settings fields  - $section_slug
            'Post 3', // readable title on screen
            'ade_home_features_post_3_callback', // function that echos content under Title
            'ade_home_features_menu' //  $menu_page_slug / slug name of the settings page to show section
          );

        //Page = Features, Section = Post 3, Field = Select Blog
          add_settings_field(
            'ade_home_features_3_1', //ID with ade_home_ prefix
            'Select Blog', // field title
            'ade_home_features_3_1_callback',  //field callback function
            'ade_home_features_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
            'ade_home_features_post_3' // get this from add_settings_section  $section_slug,
          );

        //Page = Features, Section = Post 1, Field = Select Post
          add_settings_field(
            'ade_home_features_3_2', //ID with ade_home_ prefix
            'Enter Post ID', // field title
            'ade_home_features_3_2_callback',  //field callback function
            'ade_home_features_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
            'ade_home_features_post_3' // get this from add_settings_section  $section_slug,
          );

          //Page = Features, Section = Post 3, Field = Last Updated
            add_settings_field(
              'ade_home_features_3_3', //ID with ade_home_ prefix
              'Last Updated', // field title
              'ade_home_features_3_3_callback',  //field callback function
              'ade_home_features_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
              'ade_home_features_post_3' // get this from add_settings_section  $section_slug,
            );

    // FEATURES POST 4
       // Page = Features, Section = Post 4
         add_settings_section(
           'ade_home_features_post_4', //$id -- slug used in settings fields  - $section_slug
           'Post 4', // readable title on screen
           'ade_home_features_post_4_callback', // function that echos content under Title
           'ade_home_features_menu' //  $menu_page_slug / slug name of the settings page to show section
         );

       //Page = Features, Section = Post 4, Field = Select Blog
         add_settings_field(
           'ade_home_features_4_1', //ID with ade_home_ prefix
           'Select Blog', // field title
           'ade_home_features_4_1_callback',  //field callback function
           'ade_home_features_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
           'ade_home_features_post_4' // get this from add_settings_section  $section_slug,
         );

       //Page = Features, Section = Post 4, Field = Select Post
         add_settings_field(
           'ade_home_features_4_2', //ID with ade_home_ prefix
           'Enter Post ID', // field title
           'ade_home_features_4_2_callback',  //field callback function
           'ade_home_features_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
           'ade_home_features_post_4' // get this from add_settings_section  $section_slug,
         );

         //Page = Features, Section = Post 4, Field = Last Updated
           add_settings_field(
             'ade_home_features_4_3', //ID with ade_home_ prefix
             'Last Updated', // field title
             'ade_home_features_4_3_callback',  //field callback function
             'ade_home_features_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_features_post_4' // get this from add_settings_section  $section_slug,
           );

 /*** ANNOUNCEMENTS PAGE ***/

        //register the below settings
       register_setting(
         'ade_home_announcements_settings',
         'ade_home_announcements_settings'
       );  // JUST KEEP THESE THE SAME

    // ANNOUNCEMENTS POST 1
       // Page = Announcements, Section = Post 1
         add_settings_section(
           'ade_home_announcements_post_1', //$id -- slug used in settings fields  - $section_slug
           'Post 1', // readable title on screen
           'ade_home_announcements_post_1_callback', // function that echos content under Title
           'ade_home_announcements_menu' //  $menu_page_slug / slug name of the settings page to show section
         );

       //Page = Announcements, Section = Post 1, Field = Select Blog
         add_settings_field(
           'ade_home_announcements_1_1', //ID with ade_home_ prefix
           'Select Blog', // field title
           'ade_home_announcements_1_1_callback',  //field callback function
           'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
           'ade_home_announcements_post_1' // get this from add_settings_section  $section_slug,
         );

       //Page = Announcements, Section = Post 1, Field = Select Post
         add_settings_field(
           'ade_home_announcements_1_2', //ID with ade_home_ prefix
           'Enter Post ID', // field title
           'ade_home_announcements_1_2_callback',  //field callback function
           'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
           'ade_home_announcements_post_1' // get this from add_settings_section  $section_slug,
         );

       //Page = Announcements, Section = Post 1, Field = Last Updated
         add_settings_field(
           'ade_home_announcements_1_3', //ID with ade_home_ prefix
           'Last Updated', // field title
           'ade_home_announcements_1_3_callback',  //field callback function
           'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
           'ade_home_announcements_post_1' // get this from add_settings_section  $section_slug,
         );

       //Page = Announcements, Section = Post 1, Field = Optional Link
         add_settings_field(
           'ade_home_announcements_1_4', //ID with ade_home_ prefix
           'Optional Link', // field title
           'ade_home_announcements_1_4_callback',  //field callback function
           'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
           'ade_home_announcements_post_1' // get this from add_settings_section  $section_slug,
         );


     // ANNOUNCEMENTS POST 2
        // Page = Announcements, Section = Post 2
          add_settings_section(
            'ade_home_announcements_post_2', //$id -- slug used in settings fields  - $section_slug
            'Post 2', // readable title on screen
            'ade_home_announcements_post_2_callback', // function that echos content under Title
            'ade_home_announcements_menu' //  $menu_page_slug / slug name of the settings page to show section
          );

        //Page = Announcements, Section = Post 1, Field = Select Blog
          add_settings_field(
            'ade_home_announcements_2_1', //ID with ade_home_ prefix
            'Select Blog', // field title
            'ade_home_announcements_2_1_callback',  //field callback function
            'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
            'ade_home_announcements_post_2' // get this from add_settings_section  $section_slug,
          );

        //Page = Announcements, Section = Post 1, Field = Select Post
          add_settings_field(
            'ade_home_announcements_2_2', //ID with ade_home_ prefix
            'Enter Post ID', // field title
            'ade_home_announcements_2_2_callback',  //field callback function
            'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
            'ade_home_announcements_post_2' // get this from add_settings_section  $section_slug,
          );

        //Page = Announcements, Section = Post 2, Field = Last Updated
          add_settings_field(
            'ade_home_announcements_2_3', //ID with ade_home_ prefix
            'Last Updated', // field title
            'ade_home_announcements_2_3_callback',  //field callback function
            'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
            'ade_home_announcements_post_2' // get this from add_settings_section  $section_slug,
          );

         //Page = Announcements, Section = Post 2, Field = Optional Link
           add_settings_field(
             'ade_home_announcements_2_4', //ID with ade_home_ prefix
             'Optional Link', // field title
             'ade_home_announcements_2_4_callback',  //field callback function
             'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_announcements_post_2' // get this from add_settings_section  $section_slug,
           );

      // ANNOUNCEMENTS POST 3
         // Page = Announcements, Section = Post 3
           add_settings_section(
             'ade_home_announcements_post_3', //$id -- slug used in settings fields  - $section_slug
             'Post 3', // readable title on screen
             'ade_home_announcements_post_3_callback', // function that echos content under Title
             'ade_home_announcements_menu' //  $menu_page_slug / slug name of the settings page to show section
           );

         //Page = Announcements, Section = Post 3, Field = Select Blog
           add_settings_field(
             'ade_home_announcements_3_1', //ID with ade_home_ prefix
             'Select Blog', // field title
             'ade_home_announcements_3_1_callback',  //field callback function
             'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_announcements_post_3' // get this from add_settings_section  $section_slug,
           );

         //Page = Announcements, Section = Post 3, Field = Select Post
           add_settings_field(
             'ade_home_announcements_3_2', //ID with ade_home_ prefix
             'Enter Post ID', // field title
             'ade_home_announcements_3_2_callback',  //field callback function
             'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_announcements_post_3' // get this from add_settings_section  $section_slug,
           );

           //Page = Announcements, Section = Post 3, Field = Last Updated
             add_settings_field(
               'ade_home_announcements_3_3', //ID with ade_home_ prefix
               'Last Updated', // field title
               'ade_home_announcements_3_3_callback',  //field callback function
               'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
               'ade_home_announcements_post_3' // get this from add_settings_section  $section_slug,
             );

          //Page = Announcements, Section = Post 3, Field = Optional Link
            add_settings_field(
              'ade_home_announcements_3_4', //ID with ade_home_ prefix
              'Optional Link', // field title
              'ade_home_announcements_3_4_callback',  //field callback function
              'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
              'ade_home_announcements_post_3' // get this from add_settings_section  $section_slug,
            );

     // ANNOUNCEMENTS POST 4
        // Page = Announcements, Section = Post 4
          add_settings_section(
            'ade_home_announcements_post_4', //$id -- slug used in settings fields  - $section_slug
            'Post 4', // readable title on screen
            'ade_home_announcements_post_4_callback', // function that echos content under Title
            'ade_home_announcements_menu' //  $menu_page_slug / slug name of the settings page to show section
          );

        //Page = Announcements, Section = Post 4, Field = Select Blog
          add_settings_field(
            'ade_home_announcements_4_1', //ID with ade_home_ prefix
            'Select Blog', // field title
            'ade_home_announcements_4_1_callback',  //field callback function
            'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
            'ade_home_announcements_post_4' // get this from add_settings_section  $section_slug,
          );

        //Page = Announcements, Section = Post 4, Field = Select Post
          add_settings_field(
            'ade_home_announcements_4_2', //ID with ade_home_ prefix
            'Enter Post ID', // field title
            'ade_home_announcements_4_2_callback',  //field callback function
            'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
            'ade_home_announcements_post_4' // get this from add_settings_section  $section_slug,
          );

        //Page = Announcements, Section = Post 4, Field = Last Updated
          add_settings_field(
            'ade_home_announcements_4_3', //ID with ade_home_ prefix
            'Last Updated', // field title
            'ade_home_announcements_4_3_callback',  //field callback function
            'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
            'ade_home_announcements_post_4' // get this from add_settings_section  $section_slug,
          );

        //Page = Announcements, Section = Post 4, Field = Optional Link
          add_settings_field(
            'ade_home_announcements_4_4', //ID with ade_home_ prefix
            'Optional Link', // field title
            'ade_home_announcements_4_4_callback',  //field callback function
            'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
            'ade_home_announcements_post_4' // get this from add_settings_section  $section_slug,
          );

      // ANNOUNCEMENTS POST 5
         // Page = Announcements, Section = Post 5
           add_settings_section(
             'ade_home_announcements_post_5', //$id -- slug used in settings fields  - $section_slug
             'Post 5', // readable title on screen
             'ade_home_announcements_post_5_callback', // function that echos content under Title
             'ade_home_announcements_menu' //  $menu_page_slug / slug name of the settings page to show section
           );

         //Page = Announcements, Section = Post 5, Field = Select Blog
           add_settings_field(
             'ade_home_announcements_5_1', //ID with ade_home_ prefix
             'Select Blog', // field title
             'ade_home_announcements_5_1_callback',  //field callback function
             'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_announcements_post_5' // get this from add_settings_section  $section_slug,
           );

         //Page = Announcements, Section = Post 5, Field = Select Post
           add_settings_field(
             'ade_home_announcements_5_2', //ID with ade_home_ prefix
             'Enter Post ID', // field title
             'ade_home_announcements_5_2_callback',  //field callback function
             'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_announcements_post_5' // get this from add_settings_section  $section_slug,
           );

         //Page = Announcements, Section = Post 5, Field = Last Updated
           add_settings_field(
             'ade_home_announcements_5_3', //ID with ade_home_ prefix
             'Last Updated', // field title
             'ade_home_announcements_5_3_callback',  //field callback function
             'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_announcements_post_5' // get this from add_settings_section  $section_slug,
           );

         //Page = Announcements, Section = Post 5, Field = Optional Link
           add_settings_field(
             'ade_home_announcements_5_4', //ID with ade_home_ prefix
             'Optional Link', // field title
             'ade_home_announcements_5_4_callback',  //field callback function
             'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_announcements_post_5' // get this from add_settings_section  $section_slug,
           );

     // ANNOUNCEMENTS POST 6
        // Page = Announcements, Section = Post 6
          add_settings_section(
            'ade_home_announcements_post_6', //$id -- slug used in settings fields  - $section_slug
            'Post 6', // readable title on screen
            'ade_home_announcements_post_6_callback', // function that echos content under Title
            'ade_home_announcements_menu' //  $menu_page_slug / slug name of the settings page to show section
          );

        //Page = Announcements, Section = Post 6, Field = Select Blog
          add_settings_field(
            'ade_home_announcements_6_1', //ID with ade_home_ prefix
            'Select Blog', // field title
            'ade_home_announcements_6_1_callback',  //field callback function
            'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
            'ade_home_announcements_post_6' // get this from add_settings_section  $section_slug,
          );

        //Page = Announcements, Section = Post 6, Field = Select Post
          add_settings_field(
            'ade_home_announcements_6_2', //ID with ade_home_ prefix
            'Enter Post ID', // field title
            'ade_home_announcements_6_2_callback',  //field callback function
            'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
            'ade_home_announcements_post_6' // get this from add_settings_section  $section_slug,
          );

        //Page = Announcements, Section = Post 6, Field = Last Updated
          add_settings_field(
            'ade_home_announcements_6_3', //ID with ade_home_ prefix
            'Last Updated', // field title
            'ade_home_announcements_6_3_callback',  //field callback function
            'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
            'ade_home_announcements_post_6' // get this from add_settings_section  $section_slug,
          );

        //Page = Announcements, Section = Post 6, Field = Optional Link
          add_settings_field(
            'ade_home_announcements_6_4', //ID with ade_home_ prefix
            'Optional Link', // field title
            'ade_home_announcements_6_4_callback',  //field callback function
            'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
            'ade_home_announcements_post_6' // get this from add_settings_section  $section_slug,
          );

    // ANNOUNCEMENTS POST 7
       // Page = Announcements, Section = Post 7
         add_settings_section(
           'ade_home_announcements_post_7', //$id -- slug used in settings fields  - $section_slug
           'Post 7', // readable title on screen
           'ade_home_announcements_post_7_callback', // function that echos content under Title
           'ade_home_announcements_menu' //  $menu_page_slug / slug name of the settings page to show section
         );

       //Page = Announcements, Section = Post 7, Field = Select Blog
         add_settings_field(
           'ade_home_announcements_7_1', //ID with ade_home_ prefix
           'Select Blog', // field title
           'ade_home_announcements_7_1_callback',  //field callback function
           'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
           'ade_home_announcements_post_7' // get this from add_settings_section  $section_slug,
         );

       //Page = Announcements, Section = Post 7, Field = Select Post
         add_settings_field(
           'ade_home_announcements_7_2', //ID with ade_home_ prefix
           'Enter Post ID', // field title
           'ade_home_announcements_7_2_callback',  //field callback function
           'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
           'ade_home_announcements_post_7' // get this from add_settings_section  $section_slug,
         );

       //Page = Announcements, Section = Post 7, Field = Last Updated
         add_settings_field(
           'ade_home_announcements_7_3', //ID with ade_home_ prefix
           'Last Updated', // field title
           'ade_home_announcements_7_3_callback',  //field callback function
           'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
           'ade_home_announcements_post_7' // get this from add_settings_section  $section_slug,
         );

       //Page = Announcements, Section = Post 7, Field = Optional Link
         add_settings_field(
           'ade_home_announcements_7_4', //ID with ade_home_ prefix
           'Optional Link', // field title
           'ade_home_announcements_7_4_callback',  //field callback function
           'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
           'ade_home_announcements_post_7' // get this from add_settings_section  $section_slug,
         );

   // ANNOUNCEMENTS POST 8
      // Page = Announcements, Section = Post 8
        add_settings_section(
          'ade_home_announcements_post_8', //$id -- slug used in settings fields  - $section_slug
          'Post 8', // readable title on screen
          'ade_home_announcements_post_8_callback', // function that echos content under Title
          'ade_home_announcements_menu' //  $menu_page_slug / slug name of the settings page to show section
        );

      //Page = Announcements, Section = Post 8, Field = Select Blog
        add_settings_field(
          'ade_home_announcements_8_1', //ID with ade_home_ prefix
          'Select Blog', // field title
          'ade_home_announcements_8_1_callback',  //field callback function
          'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
          'ade_home_announcements_post_8' // get this from add_settings_section  $section_slug,
        );

      //Page = Announcements, Section = Post 8, Field = Select Post
        add_settings_field(
          'ade_home_announcements_8_2', //ID with ade_home_ prefix
          'Enter Post ID', // field title
          'ade_home_announcements_8_2_callback',  //field callback function
          'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
          'ade_home_announcements_post_8' // get this from add_settings_section  $section_slug,
        );

      //Page = Announcements, Section = Post 8, Field = Last Updated
        add_settings_field(
          'ade_home_announcements_8_3', //ID with ade_home_ prefix
          'Last Updated', // field title
          'ade_home_announcements_8_3_callback',  //field callback function
          'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
          'ade_home_announcements_post_8' // get this from add_settings_section  $section_slug,
        );

      //Page = Announcements, Section = Post 8, Field = Optional Link
        add_settings_field(
          'ade_home_announcements_8_4', //ID with ade_home_ prefix
          'Optional Link', // field title
          'ade_home_announcements_8_4_callback',  //field callback function
          'ade_home_announcements_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
          'ade_home_announcements_post_8' // get this from add_settings_section  $section_slug,
        );

  /*** Post ID PAGE ***/

     //register the below settings
     register_setting(
       'ade_home_post_id_settings',
       'ade_home_post_id_settings'
     );  // JUST KEEP THESE THE SAME

  // POST ID Section
     // Page = Post ID Settings, Section = Post ID
       add_settings_section(
         'ade_home_post_id_admin', //$id -- slug used in settings fields  - $section_slug
         'List Posts for Selected Blog', // readable title on screen
         'ade_home_post_id_admin_callback', // function that echos content under Title
         'ade_home_post_id_menu' //  $menu_page_slug / slug name of the settings page to show section
       );

     //Page = Post ID Settings, Section = Post ID, Field = Select Blog
       add_settings_field(
         'ade_home_post_id_blog', //ID with ade_home_ prefix
         'Select Blog', // field title
         'ade_home_post_id_blog_callback',  //field callback function
         'ade_home_post_id_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
         'ade_home_post_id_admin' // get this from add_settings_section  $section_slug,
       );

     //Page = Post ID Settings, Section = Post ID, Field = List Posts
       add_settings_field(
         'ade_home_post_id_list', //ID with ade_home_ prefix
         'List Posts', // field title
         'ade_home_post_id_list_callback',  //field callback function
         'ade_home_post_id_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
         'ade_home_post_id_admin' // get this from add_settings_section  $section_slug,
       );

 /*** HEADLINES PAGE ***/

        //register the below settings
       register_setting(
         'ade_home_headlines_settings',
         'ade_home_headlines_settings'
       );  // JUST KEEP THESE THE SAME

    // HEADLINES WIDGET
       // Page = Headlines, Section = headlines_widget
         add_settings_section(
           'ade_home_headlines_widget', //$id -- slug used in settings fields  - $section_slug
           'Headlines Widget', // readable title on screen
           'ade_home_headlines_widget_callback', // function that echos content under Title
           'ade_home_headlines_menu' //  $menu_page_slug / slug name of the settings page to show section
         );

       //Page = Headlines, Section = headlines_widget, Field = Select Blog
         add_settings_field(
           'ade_home_headlines_1_1', //ID with ade_home_ prefix
           'Select Blog', // field title
           'ade_home_headlines_1_1_callback',  //field callback function
           'ade_home_headlines_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
           'ade_home_headlines_widget' // get this from add_settings_section  $section_slug,
         );

       //Page = Headlines, Section = headlines_widget, Field = Category
         add_settings_field(
           'ade_home_headlines_1_2', //ID with ade_home_ prefix
           'Enter Category Slug', // field title
           'ade_home_headlines_1_2_callback',  //field callback function
           'ade_home_headlines_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
           'ade_home_headlines_widget' // get this from add_settings_section  $section_slug,
         );

       //Page = Headlines, Section = headlines_widget, Field = Number Posts
         add_settings_field(
           'ade_home_headlines_1_3', //ID with ade_home_ prefix
           'Enter Number Posts', // field title
           'ade_home_headlines_1_3_callback',  //field callback function
           'ade_home_headlines_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
           'ade_home_headlines_widget' // get this from add_settings_section  $section_slug,
         );

/*** BLOG CORNER PAGE ***/
      //register the below settings
      register_setting(
        'ade_home_blog_corner_settings',
        'ade_home_blog_corner_settings'
      );  // JUST KEEP THESE THE SAME

      // BOX 1
         // Page = Blog Corner, Section = blog_corner_box_1
           add_settings_section(
             'ade_home_blog_corner_box_1', //$id -- slug used in settings fields  - $section_slug
             'Blog Corner Box 1', // readable title on screen
             'ade_home_blog_corner_box_1_callback', // function that echos content under Title
             'ade_home_blog_corner_menu' //  $menu_page_slug / slug name of the settings page to show section
           );

         //Page = Blog Corner, Section = blog_corner_box_1
           add_settings_field(
             'ade_home_blog_corner_box_1_1', //ID with ade_home_ prefix
             'Select Blog', // field title
             'ade_home_blog_corner_box_1_1_callback',  //field callback function
             'ade_home_blog_corner_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_blog_corner_box_1' // get this from add_settings_section  $section_slug,
           );

         //Page = Blog Corner, Section = blog_corner_box_1
           add_settings_field(
             'ade_home_blog_corner_box_1_2', //ID with ade_home_ prefix
             'Post ID', // field title
             'ade_home_blog_corner_box_1_2_callback',  //field callback function
             'ade_home_blog_corner_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_blog_corner_box_1' // get this from add_settings_section  $section_slug,
           );

         //Page = Blog Corner, Section = blog_corner_box_1
           add_settings_field(
             'ade_home_blog_corner_box_1_3', //ID with ade_home_ prefix
             'Last Updated', // field title
             'ade_home_blog_corner_box_1_3_callback',  //field callback function
             'ade_home_blog_corner_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_blog_corner_box_1' // get this from add_settings_section  $section_slug,
           );

         //Page = Blog Corner, Section = blog_corner_box_1
           add_settings_field(
             'ade_home_blog_corner_box_1_4', //ID with ade_home_ prefix
             'Banner Icon', // field title
             'ade_home_blog_corner_box_1_4_callback',  //field callback function
             'ade_home_blog_corner_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_blog_corner_box_1' // get this from add_settings_section  $section_slug,
           );

         //Page = Blog Corner, Section = blog_corner_box_1
           add_settings_field(
             'ade_home_blog_corner_box_1_5', //ID with ade_home_ prefix
             'Banner Text', // field title
             'ade_home_blog_corner_box_1_5_callback',  //field callback function
             'ade_home_blog_corner_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_blog_corner_box_1' // get this from add_settings_section  $section_slug,
           );

     // BOX 2
        // Page = Blog Corner, Section = blog_corner_box_2
          add_settings_section(
            'ade_home_blog_corner_box_2', //$id -- slug used in settings fields  - $section_slug
            'Blog Corner Box 2', // readable title on screen
            'ade_home_blog_corner_box_2_callback', // function that echos content under Title
            'ade_home_blog_corner_menu' //  $menu_page_slug / slug name of the settings page to show section
          );

        //Page = Blog Corner, Section = blog_corner_box_2
          add_settings_field(
            'ade_home_blog_corner_box_2_1', //ID with ade_home_ prefix
            'Select Blog', // field title
            'ade_home_blog_corner_box_2_1_callback',  //field callback function
            'ade_home_blog_corner_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
            'ade_home_blog_corner_box_2' // get this from add_settings_section  $section_slug,
          );

        //Page = Blog Corner, Section = blog_corner_box_2
          add_settings_field(
            'ade_home_blog_corner_box_2_2', //ID with ade_home_ prefix
            'Post ID', // field title
            'ade_home_blog_corner_box_2_2_callback',  //field callback function
            'ade_home_blog_corner_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
            'ade_home_blog_corner_box_2' // get this from add_settings_section  $section_slug,
          );

        //Page = Blog Corner, Section = blog_corner_box_2
          add_settings_field(
            'ade_home_blog_corner_box_2_3', //ID with ade_home_ prefix
            'Last Updated', // field title
            'ade_home_blog_corner_box_2_3_callback',  //field callback function
            'ade_home_blog_corner_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
            'ade_home_blog_corner_box_2' // get this from add_settings_section  $section_slug,
          );

        //Page = Blog Corner, Section = blog_corner_box_2
          add_settings_field(
            'ade_home_blog_corner_box_2_4', //ID with ade_home_ prefix
            'Banner Icon', // field title
            'ade_home_blog_corner_box_2_4_callback',  //field callback function
            'ade_home_blog_corner_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
            'ade_home_blog_corner_box_2' // get this from add_settings_section  $section_slug,
          );

        //Page = Blog Corner, Section = blog_corner_box_2
          add_settings_field(
            'ade_home_blog_corner_box_2_5', //ID with ade_home_ prefix
            'Banner Text', // field title
            'ade_home_blog_corner_box_2_5_callback',  //field callback function
            'ade_home_blog_corner_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
            'ade_home_blog_corner_box_2' // get this from add_settings_section  $section_slug,
          );

      // BOX 3
         // Page = Blog Corner, Section = blog_corner_box_3
           add_settings_section(
             'ade_home_blog_corner_box_3', //$id -- slug used in settings fields  - $section_slug
             'Blog Corner Box 3', // readable title on screen
             'ade_home_blog_corner_box_3_callback', // function that echos content under Title
             'ade_home_blog_corner_menu' //  $menu_page_slug / slug name of the settings page to show section
           );

         //Page = Blog Corner, Section = blog_corner_box_3
           add_settings_field(
             'ade_home_blog_corner_box_3_1', //ID with ade_home_ prefix
             'Select Blog', // field title
             'ade_home_blog_corner_box_3_1_callback',  //field callback function
             'ade_home_blog_corner_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_blog_corner_box_3' // get this from add_settings_section  $section_slug,
           );

         //Page = Blog Corner, Section = blog_corner_box_3
           add_settings_field(
             'ade_home_blog_corner_box_3_2', //ID with ade_home_ prefix
             'Post ID', // field title
             'ade_home_blog_corner_box_3_2_callback',  //field callback function
             'ade_home_blog_corner_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_blog_corner_box_3' // get this from add_settings_section  $section_slug,
           );

         //Page = Blog Corner, Section = blog_corner_box_3
           add_settings_field(
             'ade_home_blog_corner_box_3_3', //ID with ade_home_ prefix
             'Last Updated', // field title
             'ade_home_blog_corner_box_3_3_callback',  //field callback function
             'ade_home_blog_corner_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_blog_corner_box_3' // get this from add_settings_section  $section_slug,
           );

         //Page = Blog Corner, Section = blog_corner_box_3
           add_settings_field(
             'ade_home_blog_corner_box_3_4', //ID with ade_home_ prefix
             'Banner Icon', // field title
             'ade_home_blog_corner_box_3_4_callback',  //field callback function
             'ade_home_blog_corner_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_blog_corner_box_3' // get this from add_settings_section  $section_slug,
           );

         //Page = Blog Corner, Section = blog_corner_box_3
           add_settings_field(
             'ade_home_blog_corner_box_3_5', //ID with ade_home_ prefix
             'Banner Text', // field title
             'ade_home_blog_corner_box_3_5_callback',  //field callback function
             'ade_home_blog_corner_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_blog_corner_box_3' // get this from add_settings_section  $section_slug,
           );

       // BOX 4
          // Page = Blog Corner, Section = blog_corner_box_4
            add_settings_section(
              'ade_home_blog_corner_box_4', //$id -- slug used in settings fields  - $section_slug
              'Blog Corner Box 4', // readable title on screen
              'ade_home_blog_corner_box_4_callback', // function that echos content under Title
              'ade_home_blog_corner_menu' //  $menu_page_slug / slug name of the settings page to show section
            );

          //Page = Blog Corner, Section = blog_corner_box_4
            add_settings_field(
              'ade_home_blog_corner_box_4_1', //ID with ade_home_ prefix
              'Select Blog', // field title
              'ade_home_blog_corner_box_4_1_callback',  //field callback function
              'ade_home_blog_corner_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
              'ade_home_blog_corner_box_4' // get this from add_settings_section  $section_slug,
            );

          //Page = Blog Corner, Section = blog_corner_box_4
            add_settings_field(
              'ade_home_blog_corner_box_4_2', //ID with ade_home_ prefix
              'Post ID', // field title
              'ade_home_blog_corner_box_4_2_callback',  //field callback function
              'ade_home_blog_corner_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
              'ade_home_blog_corner_box_4' // get this from add_settings_section  $section_slug,
            );

          //Page = Blog Corner, Section = blog_corner_box_4
            add_settings_field(
              'ade_home_blog_corner_box_4_3', //ID with ade_home_ prefix
              'Last Updated', // field title
              'ade_home_blog_corner_box_4_3_callback',  //field callback function
              'ade_home_blog_corner_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
              'ade_home_blog_corner_box_4' // get this from add_settings_section  $section_slug,
            );

          //Page = Blog Corner, Section = blog_corner_box_4
            add_settings_field(
              'ade_home_blog_corner_box_4_4', //ID with ade_home_ prefix
              'Banner Icon', // field title
              'ade_home_blog_corner_box_4_4_callback',  //field callback function
              'ade_home_blog_corner_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
              'ade_home_blog_corner_box_4' // get this from add_settings_section  $section_slug,
            );

          //Page = Blog Corner, Section = blog_corner_box_4
            add_settings_field(
              'ade_home_blog_corner_box_4_5', //ID with ade_home_ prefix
              'Banner Text', // field title
              'ade_home_blog_corner_box_4_5_callback',  //field callback function
              'ade_home_blog_corner_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
              'ade_home_blog_corner_box_4' // get this from add_settings_section  $section_slug,
            );

/*** QUICK LINKS PAGE ***/
      //register the below settings
      register_setting(
        'ade_home_quicklinks_settings',
        'ade_home_quicklinks_settings'
      );  // JUST KEEP THESE THE SAME

      // Quick Link 1
         // Page = Quick Links, Section = quicklinks_1
           add_settings_section(
             'ade_home_quicklinks_1', //$id -- slug used in settings fields  - $section_slug
             'Quick Link 1', // readable title on screen
             'ade_home_quicklinks_1_callback', // function that echos content under Title
             'ade_home_quicklinks_menu' //  $menu_page_slug / slug name of the settings page to show section
           );
         // Page = Quick Links, Section = quicklinks_1
           add_settings_field(
             'ade_home_quicklinks_1_1', //ID with ade_home_ prefix
             'Icon', // field title
             'ade_home_quicklinks_1_1_callback',  //field callback function
             'ade_home_quicklinks_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_quicklinks_1' // get this from add_settings_section  $section_slug,
           );
         // Page = Quick Links, Section = quicklinks_1
           add_settings_field(
             'ade_home_quicklinks_1_2', //ID with ade_home_ prefix
             'Link', // field title
             'ade_home_quicklinks_1_2_callback',  //field callback function
             'ade_home_quicklinks_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_quicklinks_1' // get this from add_settings_section  $section_slug,
           );
         // Page = Quick Links, Section = quicklinks_1
           add_settings_field(
             'ade_home_quicklinks_1_3', //ID with ade_home_ prefix
             'Title', // field title
             'ade_home_quicklinks_1_3_callback',  //field callback function
             'ade_home_quicklinks_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_quicklinks_1' // get this from add_settings_section  $section_slug,
           );

       // Quick Link 2
          // Page = Quick Links, Section = quicklinks_2
            add_settings_section(
              'ade_home_quicklinks_2', //$id -- slug used in settings fields  - $section_slug
              'Quick Link 2', // readable title on screen
              'ade_home_quicklinks_2_callback', // function that echos content under Title
              'ade_home_quicklinks_menu' //  $menu_page_slug / slug name of the settings page to show section
            );
          // Page = Quick Links, Section = quicklinks_2
            add_settings_field(
              'ade_home_quicklinks_2_1', //ID with ade_home_ prefix
              'Icon', // field title
              'ade_home_quicklinks_2_1_callback',  //field callback function
              'ade_home_quicklinks_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
              'ade_home_quicklinks_2' // get this from add_settings_section  $section_slug,
            );
          // Page = Quick Links, Section = quicklinks_2
            add_settings_field(
              'ade_home_quicklinks_2_2', //ID with ade_home_ prefix
              'Link', // field title
              'ade_home_quicklinks_2_2_callback',  //field callback function
              'ade_home_quicklinks_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
              'ade_home_quicklinks_2' // get this from add_settings_section  $section_slug,
            );
          // Page = Quick Links, Section = quicklinks_2
            add_settings_field(
              'ade_home_quicklinks_2_3', //ID with ade_home_ prefix
              'Title', // field title
              'ade_home_quicklinks_2_3_callback',  //field callback function
              'ade_home_quicklinks_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
              'ade_home_quicklinks_2' // get this from add_settings_section  $section_slug,
            );

      // Quick Link 3
         // Page = Quick Links, Section = quicklinks_3
           add_settings_section(
             'ade_home_quicklinks_3', //$id -- slug used in settings fields  - $section_slug
             'Quick Link 3', // readable title on screen
             'ade_home_quicklinks_3_callback', // function that echos content under Title
             'ade_home_quicklinks_menu' //  $menu_page_slug / slug name of the settings page to show section
           );
         // Page = Quick Links, Section = quicklinks_3
           add_settings_field(
             'ade_home_quicklinks_3_1', //ID with ade_home_ prefix
             'Icon', // field title
             'ade_home_quicklinks_3_1_callback',  //field callback function
             'ade_home_quicklinks_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_quicklinks_3' // get this from add_settings_section  $section_slug,
           );
         // Page = Quick Links, Section = quicklinks_3
           add_settings_field(
             'ade_home_quicklinks_3_2', //ID with ade_home_ prefix
             'Link', // field title
             'ade_home_quicklinks_3_2_callback',  //field callback function
             'ade_home_quicklinks_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_quicklinks_3' // get this from add_settings_section  $section_slug,
           );
         // Page = Quick Links, Section = quicklinks_3
           add_settings_field(
             'ade_home_quicklinks_3_3', //ID with ade_home_ prefix
             'Title', // field title
             'ade_home_quicklinks_3_3_callback',  //field callback function
             'ade_home_quicklinks_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
             'ade_home_quicklinks_3' // get this from add_settings_section  $section_slug,
           );

     // Quick Link 4
        // Page = Quick Links, Section = quicklinks_4
          add_settings_section(
            'ade_home_quicklinks_4', //$id -- slug used in settings fields  - $section_slug
            'Quick Link 4', // readable title on screen
            'ade_home_quicklinks_4_callback', // function that echos content under Title
            'ade_home_quicklinks_menu' //  $menu_page_slug / slug name of the settings page to show section
          );
        // Page = Quick Links, Section = quicklinks_4
          add_settings_field(
            'ade_home_quicklinks_4_1', //ID with ade_home_ prefix
            'Icon', // field title
            'ade_home_quicklinks_4_1_callback',  //field callback function
            'ade_home_quicklinks_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
            'ade_home_quicklinks_4' // get this from add_settings_section  $section_slug,
          );
        // Page = Quick Links, Section = quicklinks_4
          add_settings_field(
            'ade_home_quicklinks_4_2', //ID with ade_home_ prefix
            'Link', // field title
            'ade_home_quicklinks_4_2_callback',  //field callback function
            'ade_home_quicklinks_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
            'ade_home_quicklinks_4' // get this from add_settings_section  $section_slug,
          );
        // Page = Quick Links, Section = quicklinks_4
          add_settings_field(
            'ade_home_quicklinks_4_3', //ID with ade_home_ prefix
            'Title', // field title
            'ade_home_quicklinks_4_3_callback',  //field callback function
            'ade_home_quicklinks_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
            'ade_home_quicklinks_4' // get this from add_settings_section  $section_slug,
          );

    // Quick Link 5
       // Page = Quick Links, Section = quicklinks_5
         add_settings_section(
           'ade_home_quicklinks_5', //$id -- slug used in settings fields  - $section_slug
           'Quick Link 5', // readable title on screen
           'ade_home_quicklinks_5_callback', // function that echos content under Title
           'ade_home_quicklinks_menu' //  $menu_page_slug / slug name of the settings page to show section
         );
       // Page = Quick Links, Section = quicklinks_5
         add_settings_field(
           'ade_home_quicklinks_5_1', //ID with ade_home_ prefix
           'Icon', // field title
           'ade_home_quicklinks_5_1_callback',  //field callback function
           'ade_home_quicklinks_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
           'ade_home_quicklinks_5' // get this from add_settings_section  $section_slug,
         );
       // Page = Quick Links, Section = quicklinks_5
         add_settings_field(
           'ade_home_quicklinks_5_2', //ID with ade_home_ prefix
           'Link', // field title
           'ade_home_quicklinks_5_2_callback',  //field callback function
           'ade_home_quicklinks_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
           'ade_home_quicklinks_5' // get this from add_settings_section  $section_slug,
         );
       // Page = Quick Links, Section = quicklinks_5
         add_settings_field(
           'ade_home_quicklinks_5_3', //ID with ade_home_ prefix
           'Title', // field title
           'ade_home_quicklinks_5_3_callback',  //field callback function
           'ade_home_quicklinks_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
           'ade_home_quicklinks_5' // get this from add_settings_section  $section_slug,
         );

   // Quick Link 6
      // Page = Quick Links, Section = quicklinks_6
        add_settings_section(
          'ade_home_quicklinks_6', //$id -- slug used in settings fields  - $section_slug
          'Quick Link 6', // readable title on screen
          'ade_home_quicklinks_6_callback', // function that echos content under Title
          'ade_home_quicklinks_menu' //  $menu_page_slug / slug name of the settings page to show section
        );
      // Page = Quick Links, Section = quicklinks_6
        add_settings_field(
          'ade_home_quicklinks_6_1', //ID with ade_home_ prefix
          'Icon', // field title
          'ade_home_quicklinks_6_1_callback',  //field callback function
          'ade_home_quicklinks_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
          'ade_home_quicklinks_6' // get this from add_settings_section  $section_slug,
        );
      // Page = Quick Links, Section = quicklinks_6
        add_settings_field(
          'ade_home_quicklinks_6_2', //ID with ade_home_ prefix
          'Link', // field title
          'ade_home_quicklinks_6_2_callback',  //field callback function
          'ade_home_quicklinks_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
          'ade_home_quicklinks_6' // get this from add_settings_section  $section_slug,
        );
      // Page = Quick Links, Section = quicklinks_6
        add_settings_field(
          'ade_home_quicklinks_6_3', //ID with ade_home_ prefix
          'Title', // field title
          'ade_home_quicklinks_6_3_callback',  //field callback function
          'ade_home_quicklinks_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
          'ade_home_quicklinks_6' // get this from add_settings_section  $section_slug,
        );

/*** STATIC MESSAGE PAGE ***/
    //register the below settings
    register_setting(
      'ade_home_message_settings',
      'ade_home_message_settings'
    );  // JUST KEEP THESE THE SAME

         add_settings_section(
           'ade_home_message_1', //$id -- slug used in settings fields  - $section_slug
           'Static Message', // readable title on screen
           'ade_home_message_1_callback', // function that echos content under Title
           'ade_home_message_menu' //  $menu_page_slug / slug name of the settings page to show section
         );
         add_settings_field(
           'ade_home_message_1_1', //ID with ade_home_ prefix
           'Message Text', // field title
           'ade_home_message_1_1_callback',  //field callback function
           'ade_home_message_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
           'ade_home_message_1' // get this from add_settings_section  $section_slug,
         );
         add_settings_field(
           'ade_home_message_1_2', //ID with ade_home_ prefix
           'Optional Link', // field title
           'ade_home_message_1_2_callback',  //field callback function
           'ade_home_message_menu', //  $menu_page_slug - should be $menu_slug from do_settings_sections()
           'ade_home_message_1' // get this from add_settings_section  $section_slug,
         );

  } // end function ade_home_widgets_settings_init

  add_action( 'admin_init', 'ade_home_widgets_settings_init' );


  /* ---------------------------------------------------------- *
   * CALLBACKS - FEATURES
   * ---------------------------------------------------------- */

  // FEATURES POST 1

    function ade_home_features_post_1_callback() { //Post 1 section
      } //end features_post_1_callback()

    //Features - Post 1 Fields
      function ade_home_features_1_1_callback() {
        //The way this function stores the blog name and id means that when this value is queried it will first need to be parsed to extract just the ID. The reason this function stores both name and id is to make the select field more user-friendly.
        $setting = (array) get_option( 'ade_home_features_settings');
        $field = 'ade_home_features_1_1';
        $value = esc_attr( $setting[$field] );

        $html = "<select id='ade_home_features_post_1_blog_select' name='ade_home_features_settings[$field]' class='ade-homepage-widgets-choose-new'>";
        $html .= "<option id='no_blog' name='no_blog' value='no_blog'>Select Blog</option>";

        if( is_multisite() ) {
          $sitesarg = array( 'orderby' => 'path', 'order' => 'ASC', 'public' => 1, 'archived' => 0, 'deleted' => 0, 'number' => 150 );
          $all_sites = get_sites( $sitesarg );
          foreach($all_sites as $site) {
            $optval = $site->blogname . " (" . $site->blog_id . ")";
            $selected = ($optval === $value) ? 'selected="selected"' : '';
            $html .= '<option value="'.$optval.'" ' . $selected . '>'.$site->blogname.'</option>';
          }
        } else {
            $site = get_bloginfo( 'name');
            $html .= $site;
        }

        $html .= '</select>';
        $html .= "<span class='current-choice'>Current Blog:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <span class='boldtitle'>".$value."</span>";

          echo $html;

        } //end ade_home_features_1_1_callback

      function ade_home_features_1_2_callback() {
        //Simple post ID input box -- waaaayyyy too difficult to create a dropdown to select posts based on blog change in post's blog selection field

        //get stored value for ade_home_features_1_2
          $setting = (array) get_option( 'ade_home_features_settings');

          $blog = 'ade_home_features_1_1'; //get current blog setting
          $blog = esc_attr( $setting[$blog] );  //get current blog setting value

          $blog = strchr($blog, "(", false); //parse string for post ID
          $blog = strchr($blog, ")", true); //parse again
          $blog = ltrim($blog, '(' ); //parse again

          $current_post_field = 'ade_home_features_1_2'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value

          //////// Query to get the current post's title
            global $originalblogid; //call global variable

            if ( is_multisite() ) {
              if ( strlen($blog) > 0 && $blog !== $originalblogid) {
                  $blog_id = $blog; //if so, then make that the blog_id
                } else {
                  $blog_id = $originalblogid;
                }
              switch_to_blog ($blog_id); // select correct blog, whether current or other
            }

            $current_post_object = get_post( $current_post, ARRAY_A );
            $current_post_title = $current_post_object['post_title'];

            if( is_multisite() ) {
              switch_to_blog ($originalblogid);
            }
          //end query

          $html = "<input type='text' name='ade_home_features_settings[$current_post_field]' value='$current_post'  class='ade-homepage-widgets-choose-new'/>";
          $html .= "<span class='current-choice'>Current Post: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post_title."</span>  (ID = ".$current_post.")";
          echo $html;
        } //end ade_home_features_1_2_callback

        function ade_home_features_1_3_callback() {
          //get stored value for ade_home_features_1_3
            $setting = (array) get_option( 'ade_home_features_settings');
            $current_post_field = 'ade_home_features_1_3'; //get current post setting
            $then = esc_attr( $setting[$current_post_field] ); //get current post setting value
            $lastdate = date( 'F d, Y', strtotime($then) );
            $now = date( 'F d, Y' );
            $html = "<input type='hidden' name='ade_home_features_settings[$current_post_field]'  value='$then' class='ade-homepage-widgets-datefield' />";
            $html .= "<span class='current-choice'>This post was added to the homepage on $lastdate. (Today is $now)</span>";
            echo $html;
          } //end ade_home_features_1_3_callback

  // FEATURES POST 2

    function ade_home_features_post_2_callback() { //Post 2 section
    } //end features_post_2_callback()

    //Features - Post 2 Fields
      function ade_home_features_2_1_callback() {
        //The way this function stores the blog name and id means that when this value is queried it will first need to be parsed to extract just the ID. The reason this function stores both name and id is to make the select field more user-friendly.
        $setting = (array) get_option( 'ade_home_features_settings');
        $field = 'ade_home_features_2_1';
        $value = esc_attr( $setting[$field] );
          $html = "<select id='ade_home_features_post_2_blog_select' name='ade_home_features_settings[$field]' class='ade-homepage-widgets-choose-new'>";
          $html .= "<option id='no_blog' name='no_blog' value='no_blog'>Select Blog</option>";
          if( is_multisite() ) {
            $sitesarg = array( 'orderby' => 'path', 'order' => 'ASC', 'public' => 1, 'archived' => 0, 'deleted' => 0, 'number' => 150 );
$all_sites = get_sites( $sitesarg );
            foreach($all_sites as $site) {
              $optval = $site->blogname . " (" . $site->blog_id . ")";
              $selected = ($optval === $value) ? 'selected="selected"' : '';
              $html .= '<option value="'.$optval.'" ' . $selected . '>'.$site->blogname.'</option>';
            }
          } else {
              $site = get_bloginfo( 'name');
              $html .= $site;
          }
          $html .= '</select>';
          $html .= "<span class='current-choice'>Current Blog:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <span class='boldtitle'>".$value."</span>";
          echo $html;

        } //end ade_home_features_2_1_callback

      function ade_home_features_2_2_callback() {
        //Simple post ID input box -- waaaayyyy too difficult to create a dropdown to select posts based on blog change in post's blog selection field

        //get stored value for ade_home_features_2_2
          $setting = (array) get_option( 'ade_home_features_settings');

          $blog = 'ade_home_features_2_1'; //get current blog setting
          $blog = esc_attr( $setting[$blog] );  //get current blog setting value

          $blog = strchr($blog, "(", false); //parse string for post ID
          $blog = strchr($blog, ")", true); //parse again
          $blog = ltrim($blog, '(' ); //parse again

          $current_post_field = 'ade_home_features_2_2'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value

          //////// Query to get the current post's title
            global $originalblogid; //call global variable
            if ( is_multisite() ) {
              if ( strlen($blog) > 0 && $blog !== $originalblogid) {
                  $blog_id = $blog; //if so, then make that the blog_id
                } else {
                  $blog_id = $originalblogid;
                }
              switch_to_blog ($blog_id); // select correct blog, whether current or other
            }

            $current_post_object = get_post( $current_post, ARRAY_A );
            $current_post_title = $current_post_object['post_title'];

            if( is_multisite() ) {
              switch_to_blog ($originalblogid);
            }
          //end query

          $html = "<input type='text' name='ade_home_features_settings[$current_post_field]' value='$current_post'  class='ade-homepage-widgets-choose-new'/>";
          $html .= "<span class='current-choice'>Current Post: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post_title."</span> (ID = ".$current_post.") ";
          echo $html;
        } //end ade_home_features_2_2_callback

        function ade_home_features_2_3_callback() {
          //get stored value for ade_home_features_2_3
            $setting = (array) get_option( 'ade_home_features_settings');
            $current_post_field = 'ade_home_features_2_3'; //get current post setting
            $then = esc_attr( $setting[$current_post_field] ); //get current post setting value
            $lastdate = date( 'F d, Y', strtotime($then) );
            $now = date( 'F d, Y' );
            $html = "<input type='hidden' name='ade_home_features_settings[$current_post_field]'  value='$then' class='ade-homepage-widgets-datefield' />";
            $html .= "<span class='current-choice'>This post was added to the homepage on $lastdate. (Today is $now)</span>";
            echo $html;
          } //end ade_home_features_2_3_callback

  // FEATURES POST 3

    function ade_home_features_post_3_callback() { //Post 3 section
    } //end features_post_3_callback()

    //Features - Post 2 Fields
      function ade_home_features_3_1_callback() {
        //The way this function stores the blog name and id means that when this value is queried it will first need to be parsed to extract just the ID. The reason this function stores both name and id is to make the select field more user-friendly.
        $setting = (array) get_option( 'ade_home_features_settings');
        $field = 'ade_home_features_3_1';
        $value = esc_attr( $setting[$field] );
          $html = "<select id='ade_home_features_post_3_blog_select' name='ade_home_features_settings[$field]' class='ade-homepage-widgets-choose-new'>";
          $html .= "<option id='no_blog' name='no_blog' value='no_blog'>Select Blog</option>";
          if( is_multisite() ) {
            $sitesarg = array( 'orderby' => 'path', 'order' => 'ASC', 'public' => 1, 'archived' => 0, 'deleted' => 0, 'number' => 150 );
$all_sites = get_sites( $sitesarg );
            foreach($all_sites as $site) {
              $optval = $site->blogname . " (" . $site->blog_id . ")";
              $selected = ($optval === $value) ? 'selected="selected"' : '';
              $html .= '<option value="'.$optval.'" ' . $selected . '>'.$site->blogname.'</option>';
            }
          } else {
              $site = get_bloginfo( 'name');
              $html .= $site;
          }
          $html .= '</select>';
          $html .= "<span class='current-choice'>Current Blog:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <span class='boldtitle'>".$value."</span>";
          echo $html;

        } //end ade_home_features_3_1_callback

      function ade_home_features_3_2_callback() {
        //Simple post ID input box -- waaaayyyy too difficult to create a dropdown to select posts based on blog change in post's blog selection field

        //get stored value for ade_home_features_3_2
          $setting = (array) get_option( 'ade_home_features_settings');

          $blog = 'ade_home_features_3_1'; //get current blog setting
          $blog = esc_attr( $setting[$blog] );  //get current blog setting value

          $blog = strchr($blog, "(", false); //parse string for post ID
          $blog = strchr($blog, ")", true); //parse again
          $blog = ltrim($blog, '(' ); //parse again

          $current_post_field = 'ade_home_features_3_2'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value

          //////// Query to get the current post's title
            global $originalblogid; //call global variable
            if ( is_multisite() ) {
              if ( strlen($blog) > 0 && $blog !== $originalblogid) {
                  $blog_id = $blog; //if so, then make that the blog_id
                } else {
                  $blog_id = $originalblogid;
                }
              switch_to_blog ($blog_id); // select correct blog, whether current or other
            }

            $current_post_object = get_post( $current_post, ARRAY_A );
            $current_post_title = $current_post_object['post_title'];

            if( is_multisite() ) {
              switch_to_blog ($originalblogid);
            }
          //end query

          $html = "<input type='text' name='ade_home_features_settings[$current_post_field]' value='$current_post'  class='ade-homepage-widgets-choose-new'/>";
          $html .= "<span class='current-choice'>Current Post: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post_title."</span> (ID = ".$current_post.") ";
          echo $html;
        } //end ade_home_features_3_2_callback

        function ade_home_features_3_3_callback() {
          //get stored value for ade_home_features_3_3
            $setting = (array) get_option( 'ade_home_features_settings');
            $current_post_field = 'ade_home_features_3_3'; //get current post setting
            $then = esc_attr( $setting[$current_post_field] ); //get current post setting value
            $lastdate = date( 'F d, Y', strtotime($then) );
            $now = date( 'F d, Y' );
            $html = "<input type='hidden' name='ade_home_features_settings[$current_post_field]'  value='$then' class='ade-homepage-widgets-datefield' />";
            $html .= "<span class='current-choice'>This post was added to the homepage on $lastdate. (Today is $now)</span>";
            echo $html;
          } //end ade_home_features_3_3_callback

  // FEATURES POST 4

    function ade_home_features_post_4_callback() { //Post 4 section
    } //end features_post_4_callback()

    //Features - Post 2 Fields
      function ade_home_features_4_1_callback() {
        //The way this function stores the blog name and id means that when this value is queried it will first need to be parsed to extract just the ID. The reason this function stores both name and id is to make the select field more user-friendly.
        $setting = (array) get_option( 'ade_home_features_settings');
        $field = 'ade_home_features_4_1';
        $value = esc_attr( $setting[$field] );
          $html = "<select id='ade_home_features_post_4_blog_select' name='ade_home_features_settings[$field]' class='ade-homepage-widgets-choose-new'>";
          $html .= "<option id='no_blog' name='no_blog' value='no_blog'>Select Blog</option>";
          if( is_multisite() ) {
            $sitesarg = array( 'orderby' => 'path', 'order' => 'ASC', 'public' => 1, 'archived' => 0, 'deleted' => 0, 'number' => 150 );
$all_sites = get_sites( $sitesarg );
            foreach($all_sites as $site) {
              $optval = $site->blogname . " (" . $site->blog_id . ")";
              $selected = ($optval === $value) ? 'selected="selected"' : '';
              $html .= '<option value="'.$optval.'" ' . $selected . '>'.$site->blogname.'</option>';
            }
          } else {
              $site = get_bloginfo( 'name');
              $html .= $site;
          }
          $html .= '</select>';
          $html .= "<span class='current-choice'>Current Blog:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <span class='boldtitle'>".$value."</span>";
          echo $html;

        } //end ade_home_features_4_1_callback

      function ade_home_features_4_2_callback() {
        //Simple post ID input box -- waaaayyyy too difficult to create a dropdown to select posts based on blog change in post's blog selection field

        //get stored value for ade_home_features_4_2
          $setting = (array) get_option( 'ade_home_features_settings');

          $blog = 'ade_home_features_4_1'; //get current blog setting
          $blog = esc_attr( $setting[$blog] );  //get current blog setting value

          $blog = strchr($blog, "(", false); //parse string for post ID
          $blog = strchr($blog, ")", true); //parse again
          $blog = ltrim($blog, '(' ); //parse again

          $current_post_field = 'ade_home_features_4_2'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value

          //////// Query to get the current post's title
            global $originalblogid; //call global variable
            if ( is_multisite() ) {
              if ( strlen($blog) > 0 && $blog !== $originalblogid) {
                  $blog_id = $blog; //if so, then make that the blog_id
                } else {
                  $blog_id = $originalblogid;
                }
              switch_to_blog ($blog_id); // select correct blog, whether current or other
            }

            $current_post_object = get_post( $current_post, ARRAY_A );
            $current_post_title = $current_post_object['post_title'];

            if( is_multisite() ) {
              switch_to_blog ($originalblogid);
            }
          //end query

          $html = "<input type='text' name='ade_home_features_settings[$current_post_field]' value='$current_post'  class='ade-homepage-widgets-choose-new'/>";
          $html .= "<span class='current-choice'>Current Post: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post_title."</span> (ID = ".$current_post.") ";
          echo $html;
        } //end ade_home_features_4_2_callback

        function ade_home_features_4_3_callback() {
          //get stored value for ade_home_features_4_3
            $setting = (array) get_option( 'ade_home_features_settings');
            $current_post_field = 'ade_home_features_4_3'; //get current post setting
            $then = esc_attr( $setting[$current_post_field] ); //get current post setting value
            $lastdate = date( 'F d, Y', strtotime($then) );
            $now = date( 'F d, Y' );
            $html = "<input type='hidden' name='ade_home_features_settings[$current_post_field]'  value='$then' class='ade-homepage-widgets-datefield' />";
            $html .= "<span class='current-choice'>This post was added to the homepage on $lastdate. (Today is $now)</span>";
            echo $html;
          } //end ade_home_features_4_3_callback

  /* ---------------------------------------------------------- *
   * CALLBACKS - ANNOUNCEMENTS
   * ---------------------------------------------------------- */

  // ANNOUNCEMENTS POST 1

    function ade_home_announcements_post_1_callback() { //Post 1 section
      } //end announcements_post_1_callback()

    //Features - Post 1 Fields
      function ade_home_announcements_1_1_callback() {
        //The way this function stores the blog name and id means that when this value is queried it will first need to be parsed to extract just the ID. The reason this function stores both name and id is to make the select field more user-friendly.
        $setting = (array) get_option( 'ade_home_announcements_settings');
        $field = 'ade_home_announcements_1_1';
        $value = esc_attr( $setting[$field] );

        $html = "<select id='post_1_blog_select' name='ade_home_announcements_settings[$field]' class='ade-homepage-widgets-choose-new'>";
        $html .= "<option id='no_blog' name='no_blog' value='no_blog'>Select Blog</option>";

        if( is_multisite() ) {
          $sitesarg = array( 'orderby' => 'path', 'order' => 'ASC', 'public' => 1, 'archived' => 0, 'deleted' => 0, 'number' => 150 );
$all_sites = get_sites( $sitesarg );
          foreach($all_sites as $site) {
            $optval = $site->blogname . " (" . $site->blog_id . ")";
            $selected = ($optval === $value) ? 'selected="selected"' : '';
            $html .= '<option value="'.$optval.'" ' . $selected . '>'.$site->blogname.'</option>';
          }
        } else {
            $site = get_bloginfo( 'name');
            $html .= $site;
        }

        $html .= '</select>';
        $html .= "<span class='current-choice'>Current Blog:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <span class='boldtitle'>".$value."</span>";

          echo $html;

        } //end ade_home_announcements_1_1_callback

      function ade_home_announcements_1_2_callback() {
        //Simple post ID input box -- waaaayyyy too difficult to create a dropdown to select posts based on blog change in post's blog selection field

        //get stored value for ade_home_announcements_1_2
          $setting = (array) get_option( 'ade_home_announcements_settings');

          $blog = 'ade_home_announcements_1_1'; //get current blog setting
          $blog = esc_attr( $setting[$blog] );  //get current blog setting value

          $blog = strchr($blog, "(", false); //parse string for post ID
          $blog = strchr($blog, ")", true); //parse again
          $blog = ltrim($blog, '(' ); //parse again

          $current_post_field = 'ade_home_announcements_1_2'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value

          //////// Query to get the current post's title
            global $originalblogid; //call global variable

            if ( is_multisite() ) {
              if ( strlen($blog) > 0 && $blog !== $originalblogid) {
                  $blog_id = $blog; //if so, then make that the blog_id
                } else {
                  $blog_id = $originalblogid;
                }
              switch_to_blog ($blog_id); // select correct blog, whether current or other
            }

            $current_post_object = get_post( $current_post, ARRAY_A );
            $current_post_title = $current_post_object['post_title'];

            if( is_multisite() ) {
              switch_to_blog ($originalblogid);
            }
          //end query

          $html = "<input type='text' name='ade_home_announcements_settings[$current_post_field]' value='$current_post'  class='ade-homepage-widgets-choose-new'/>";
          $html .= "<span class='current-choice'>Current Post: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post_title."</span>  (ID = ".$current_post.")";
          echo $html;
        } //end ade_home_announcements_1_2_callback

      function ade_home_announcements_1_3_callback() {
          $setting = (array) get_option( 'ade_home_announcements_settings');
          $current_post_field = 'ade_home_announcements_1_3'; //get current post setting
          $then = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $lastdate = date( 'F d, Y', strtotime($then) );
          $now = date( 'F d, Y' );
          $html = "<input type='hidden' name='ade_home_announcements_settings[$current_post_field]'  value='$then' class='ade-homepage-widgets-datefield' />";
          $html .= "<span class='current-choice'>This announcement was added to the homepage on $lastdate. (Today is $now)</span>";
          echo $html;
        }

      function ade_home_announcements_1_4_callback() {
          $setting = (array) get_option( 'ade_home_announcements_settings');
          $current_post_field = 'ade_home_announcements_1_4'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_announcements_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
          echo $html;
        }

  // ANNOUNCEMENTS POST 2

    function ade_home_announcements_post_2_callback() { //Post 2 section
    } //end announcements_post_2_callback()

    //Features - Post 2 Fields
      function ade_home_announcements_2_1_callback() {
        //The way this function stores the blog name and id means that when this value is queried it will first need to be parsed to extract just the ID. The reason this function stores both name and id is to make the select field more user-friendly.
        $setting = (array) get_option( 'ade_home_announcements_settings');
        $field = 'ade_home_announcements_2_1';
        $value = esc_attr( $setting[$field] );
          $html = "<select id='post_2_blog_select' name='ade_home_announcements_settings[$field]' class='ade-homepage-widgets-choose-new'>";
          $html .= "<option id='no_blog' name='no_blog' value='no_blog'>Select Blog</option>";
          if( is_multisite() ) {
            $sitesarg = array( 'orderby' => 'path', 'order' => 'ASC', 'public' => 1, 'archived' => 0, 'deleted' => 0, 'number' => 150 );
$all_sites = get_sites( $sitesarg );
            foreach($all_sites as $site) {
              $optval = $site->blogname . " (" . $site->blog_id . ")";
              $selected = ($optval === $value) ? 'selected="selected"' : '';
              $html .= '<option value="'.$optval.'" ' . $selected . '>'.$site->blogname.'</option>';
            }
          } else {
              $site = get_bloginfo( 'name');
              $html .= $site;
          }
          $html .= '</select>';
          $html .= "<span class='current-choice'>Current Blog:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <span class='boldtitle'>".$value."</span>";
          echo $html;

        } //end ade_home_announcements_2_1_callback

      function ade_home_announcements_2_2_callback() {
        //Simple post ID input box -- waaaayyyy too difficult to create a dropdown to select posts based on blog change in post's blog selection field

        //get stored value for ade_home_announcements_2_2
          $setting = (array) get_option( 'ade_home_announcements_settings');

          $blog = 'ade_home_announcements_2_1'; //get current blog setting
          $blog = esc_attr( $setting[$blog] );  //get current blog setting value

          $blog = strchr($blog, "(", false); //parse string for post ID
          $blog = strchr($blog, ")", true); //parse again
          $blog = ltrim($blog, '(' ); //parse again

          $current_post_field = 'ade_home_announcements_2_2'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value

          //////// Query to get the current post's title
            global $originalblogid; //call global variable
            if ( is_multisite() ) {
              if ( strlen($blog) > 0 && $blog !== $originalblogid) {
                  $blog_id = $blog; //if so, then make that the blog_id
                } else {
                  $blog_id = $originalblogid;
                }
              switch_to_blog ($blog_id); // select correct blog, whether current or other
            }

            $current_post_object = get_post( $current_post, ARRAY_A );
            $current_post_title = $current_post_object['post_title'];

            if( is_multisite() ) {
              switch_to_blog ($originalblogid);
            }
          //end query

          $html = "<input type='text' name='ade_home_announcements_settings[$current_post_field]' value='$current_post'  class='ade-homepage-widgets-choose-new'/>";
          $html .= "<span class='current-choice'>Current Post: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post_title."</span> (ID = ".$current_post.") ";
          echo $html;
        } //end ade_home_announcements_2_2_callback

      function ade_home_announcements_2_3_callback() {
          $setting = (array) get_option( 'ade_home_announcements_settings');
          $current_post_field = 'ade_home_announcements_2_3'; //get current post setting
          $then = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $lastdate = date( 'F d, Y', strtotime($then) );
          $now = date( 'F d, Y' );
          $html = "<input type='hidden' name='ade_home_announcements_settings[$current_post_field]'  value='$then' class='ade-homepage-widgets-datefield' />";
          $html .= "<span class='current-choice'>This announcement was added to the homepage on $lastdate. (Today is $now)</span>";
          echo $html;
        }

      function ade_home_announcements_2_4_callback() {
          $setting = (array) get_option( 'ade_home_announcements_settings');
          $current_post_field = 'ade_home_announcements_2_4'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_announcements_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
          echo $html;
        }

  // ANNOUNCEMENTS POST 3

    function ade_home_announcements_post_3_callback() { //Post 3 section
    } //end announcements_post_3_callback()

    //Features - Post 2 Fields
      function ade_home_announcements_3_1_callback() {
        //The way this function stores the blog name and id means that when this value is queried it will first need to be parsed to extract just the ID. The reason this function stores both name and id is to make the select field more user-friendly.
        $setting = (array) get_option( 'ade_home_announcements_settings');
        $field = 'ade_home_announcements_3_1';
        $value = esc_attr( $setting[$field] );
          $html = "<select id='post_3_blog_select' name='ade_home_announcements_settings[$field]' class='ade-homepage-widgets-choose-new'>";
          $html .= "<option id='no_blog' name='no_blog' value='no_blog'>Select Blog</option>";
          if( is_multisite() ) {
            $sitesarg = array( 'orderby' => 'path', 'order' => 'ASC', 'public' => 1, 'archived' => 0, 'deleted' => 0, 'number' => 150 );
$all_sites = get_sites( $sitesarg );
            foreach($all_sites as $site) {
              $optval = $site->blogname . " (" . $site->blog_id . ")";
              $selected = ($optval === $value) ? 'selected="selected"' : '';
              $html .= '<option value="'.$optval.'" ' . $selected . '>'.$site->blogname.'</option>';
            }
          } else {
              $site = get_bloginfo( 'name');
              $html .= $site;
          }
          $html .= '</select>';
          $html .= "<span class='current-choice'>Current Blog:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <span class='boldtitle'>".$value."</span>";
          echo $html;

        } //end ade_home_announcements_3_1_callback

      function ade_home_announcements_3_2_callback() {
        //Simple post ID input box -- waaaayyyy too difficult to create a dropdown to select posts based on blog change in post's blog selection field

        //get stored value for ade_home_announcements_3_2
          $setting = (array) get_option( 'ade_home_announcements_settings');

          $blog = 'ade_home_announcements_3_1'; //get current blog setting
          $blog = esc_attr( $setting[$blog] );  //get current blog setting value

          $blog = strchr($blog, "(", false); //parse string for post ID
          $blog = strchr($blog, ")", true); //parse again
          $blog = ltrim($blog, '(' ); //parse again

          $current_post_field = 'ade_home_announcements_3_2'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value

          //////// Query to get the current post's title
            global $originalblogid; //call global variable
            if ( is_multisite() ) {
              if ( strlen($blog) > 0 && $blog !== $originalblogid) {
                  $blog_id = $blog; //if so, then make that the blog_id
                } else {
                  $blog_id = $originalblogid;
                }
              switch_to_blog ($blog_id); // select correct blog, whether current or other
            }

            $current_post_object = get_post( $current_post, ARRAY_A );
            $current_post_title = $current_post_object['post_title'];

            if( is_multisite() ) {
              switch_to_blog ($originalblogid);
            }
          //end query

          $html = "<input type='text' name='ade_home_announcements_settings[$current_post_field]' value='$current_post'  class='ade-homepage-widgets-choose-new'/>";
          $html .= "<span class='current-choice'>Current Post: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post_title."</span> (ID = ".$current_post.") ";
          echo $html;
        } //end ade_home_announcements_3_2_callback

      function ade_home_announcements_3_3_callback() {
          $setting = (array) get_option( 'ade_home_announcements_settings');
          $current_post_field = 'ade_home_announcements_3_3'; //get current post setting
          $then = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $lastdate = date( 'F d, Y', strtotime($then) );
          $now = date( 'F d, Y' );
          $html = "<input type='hidden' name='ade_home_announcements_settings[$current_post_field]'  value='$then' class='ade-homepage-widgets-datefield' />";
          $html .= "<span class='current-choice'>This announcement was added to the homepage on $lastdate. (Today is $now)</span>";
          echo $html;
        }

      function ade_home_announcements_3_4_callback() {
          $setting = (array) get_option( 'ade_home_announcements_settings');
          $current_post_field = 'ade_home_announcements_3_4'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_announcements_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
          echo $html;
        }

  // ANNOUNCEMENTS POST 4

    function ade_home_announcements_post_4_callback() { //Post 4 section
    } //end announcements_post_4_callback()

    //Features - Post 2 Fields
      function ade_home_announcements_4_1_callback() {
        //The way this function stores the blog name and id means that when this value is queried it will first need to be parsed to extract just the ID. The reason this function stores both name and id is to make the select field more user-friendly.
        $setting = (array) get_option( 'ade_home_announcements_settings');
        $field = 'ade_home_announcements_4_1';
        $value = esc_attr( $setting[$field] );
          $html = "<select id='post_4_blog_select' name='ade_home_announcements_settings[$field]' class='ade-homepage-widgets-choose-new'>";
          $html .= "<option id='no_blog' name='no_blog' value='no_blog'>Select Blog</option>";
          if( is_multisite() ) {
            $sitesarg = array( 'orderby' => 'path', 'order' => 'ASC', 'public' => 1, 'archived' => 0, 'deleted' => 0, 'number' => 150 );
$all_sites = get_sites( $sitesarg );
            foreach($all_sites as $site) {
              $optval = $site->blogname . " (" . $site->blog_id . ")";
              $selected = ($optval === $value) ? 'selected="selected"' : '';
              $html .= '<option value="'.$optval.'" ' . $selected . '>'.$site->blogname.'</option>';
            }
          } else {
              $site = get_bloginfo( 'name');
              $html .= $site;
          }
          $html .= '</select>';
          $html .= "<span class='current-choice'>Current Blog:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <span class='boldtitle'>".$value."</span>";
          echo $html;

        } //end ade_home_announcements_4_1_callback

      function ade_home_announcements_4_2_callback() {
        //Simple post ID input box -- waaaayyyy too difficult to create a dropdown to select posts based on blog change in post's blog selection field

        //get stored value for ade_home_announcements_4_2
          $setting = (array) get_option( 'ade_home_announcements_settings');

          $blog = 'ade_home_announcements_4_1'; //get current blog setting
          $blog = esc_attr( $setting[$blog] );  //get current blog setting value

          $blog = strchr($blog, "(", false); //parse string for post ID
          $blog = strchr($blog, ")", true); //parse again
          $blog = ltrim($blog, '(' ); //parse again

          $current_post_field = 'ade_home_announcements_4_2'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value

          //////// Query to get the current post's title
            global $originalblogid; //call global variable
            if ( is_multisite() ) {
              if ( strlen($blog) > 0 && $blog !== $originalblogid) {
                  $blog_id = $blog; //if so, then make that the blog_id
                } else {
                  $blog_id = $originalblogid;
                }
              switch_to_blog ($blog_id); // select correct blog, whether current or other
            }

            $current_post_object = get_post( $current_post, ARRAY_A );
            $current_post_title = $current_post_object['post_title'];

            if( is_multisite() ) {
              switch_to_blog ($originalblogid);
            }
          //end query

          $html = "<input type='text' name='ade_home_announcements_settings[$current_post_field]' value='$current_post'  class='ade-homepage-widgets-choose-new'/>";
          $html .= "<span class='current-choice'>Current Post: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post_title."</span> (ID = ".$current_post.") ";
          echo $html;
        } //end ade_home_announcements_4_2_callback

      function ade_home_announcements_4_3_callback() {
          $setting = (array) get_option( 'ade_home_announcements_settings');
          $current_post_field = 'ade_home_announcements_4_3'; //get current post setting
          $then = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $lastdate = date( 'F d, Y', strtotime($then) );
          $now = date( 'F d, Y' );
          $html = "<input type='hidden' name='ade_home_announcements_settings[$current_post_field]'  value='$then' class='ade-homepage-widgets-datefield' />";
          $html .= "<span class='current-choice'>This announcement was added to the homepage on $lastdate. (Today is $now)</span>";
          echo $html;
        }

      function ade_home_announcements_4_4_callback() {
          $setting = (array) get_option( 'ade_home_announcements_settings');
          $current_post_field = 'ade_home_announcements_4_4'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_announcements_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
          echo $html;
        }

  // ANNOUNCEMENTS POST 5

    function ade_home_announcements_post_5_callback() { //Post 5 section
    } //end announcements_post_5_callback()

      function ade_home_announcements_5_1_callback() {
        //The way this function stores the blog name and id means that when this value is queried it will first need to be parsed to extract just the ID. The reason this function stores both name and id is to make the select field more user-friendly.
        $setting = (array) get_option( 'ade_home_announcements_settings');
        $field = 'ade_home_announcements_5_1';
        $value = esc_attr( $setting[$field] );
          $html = "<select id='post_5_blog_select' name='ade_home_announcements_settings[$field]' class='ade-homepage-widgets-choose-new'>";
          $html .= "<option id='no_blog' name='no_blog' value='no_blog'>Select Blog</option>";
          if( is_multisite() ) {
            $sitesarg = array( 'orderby' => 'path', 'order' => 'ASC', 'public' => 1, 'archived' => 0, 'deleted' => 0, 'number' => 150 );
$all_sites = get_sites( $sitesarg );
            foreach($all_sites as $site) {
              $optval = $site->blogname . " (" . $site->blog_id . ")";
              $selected = ($optval === $value) ? 'selected="selected"' : '';
              $html .= '<option value="'.$optval.'" ' . $selected . '>'.$site->blogname.'</option>';
            }
          } else {
              $site = get_bloginfo( 'name');
              $html .= $site;
          }
          $html .= '</select>';
          $html .= "<span class='current-choice'>Current Blog:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <span class='boldtitle'>".$value."</span>";
          echo $html;

        } //end ade_home_announcements_5_1_callback

      function ade_home_announcements_5_2_callback() {
        //Simple post ID input box -- waaaayyyy too difficult to create a dropdown to select posts based on blog change in post's blog selection field

        //get stored value for ade_home_announcements_5_2
          $setting = (array) get_option( 'ade_home_announcements_settings');

          $blog = 'ade_home_announcements_5_1'; //get current blog setting
          $blog = esc_attr( $setting[$blog] );  //get current blog setting value

          $blog = strchr($blog, "(", false); //parse string for post ID
          $blog = strchr($blog, ")", true); //parse again
          $blog = ltrim($blog, '(' ); //parse again

          $current_post_field = 'ade_home_announcements_5_2'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value

          //////// Query to get the current post's title
            global $originalblogid; //call global variable
            if ( is_multisite() ) {
              if ( strlen($blog) > 0 && $blog !== $originalblogid) {
                  $blog_id = $blog; //if so, then make that the blog_id
                } else {
                  $blog_id = $originalblogid;
                }
              switch_to_blog ($blog_id); // select correct blog, whether current or other
            }

            $current_post_object = get_post( $current_post, ARRAY_A );
            $current_post_title = $current_post_object['post_title'];

            if( is_multisite() ) {
              switch_to_blog ($originalblogid);
            }
          //end query

          $html = "<input type='text' name='ade_home_announcements_settings[$current_post_field]' value='$current_post'  class='ade-homepage-widgets-choose-new'/>";
          $html .= "<span class='current-choice'>Current Post: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post_title."</span> (ID = ".$current_post.") ";
          echo $html;
        } //end ade_home_announcements_5_2_callback

      function ade_home_announcements_5_3_callback() {
          $setting = (array) get_option( 'ade_home_announcements_settings');
          $current_post_field = 'ade_home_announcements_5_3'; //get current post setting
          $then = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $lastdate = date( 'F d, Y', strtotime($then) );
          $now = date( 'F d, Y' );
          $html = "<input type='hidden' name='ade_home_announcements_settings[$current_post_field]'  value='$then' class='ade-homepage-widgets-datefield' />";
          $html .= "<span class='current-choice'>This announcement was added to the homepage on $lastdate. (Today is $now)</span>";
          echo $html;
        }

      function ade_home_announcements_5_4_callback() {
          $setting = (array) get_option( 'ade_home_announcements_settings');
          $current_post_field = 'ade_home_announcements_5_4'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_announcements_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
          echo $html;
        }

    // ANNOUNCEMENTS POST 6

      function ade_home_announcements_post_6_callback() { //Post 6 section
      } //end announcements_post_6_callback()

        function ade_home_announcements_6_1_callback() {
          //The way this function stores the blog name and id means that when this value is queried it will first need to be parsed to extract just the ID. The reason this function stores both name and id is to make the select field more user-friendly.
          $setting = (array) get_option( 'ade_home_announcements_settings');
          $field = 'ade_home_announcements_6_1';
          $value = esc_attr( $setting[$field] );
            $html = "<select id='post_6_blog_select' name='ade_home_announcements_settings[$field]' class='ade-homepage-widgets-choose-new'>";
            $html .= "<option id='no_blog' name='no_blog' value='no_blog'>Select Blog</option>";
            if( is_multisite() ) {
              $sitesarg = array( 'orderby' => 'path', 'order' => 'ASC', 'public' => 1, 'archived' => 0, 'deleted' => 0, 'number' => 150 );
  $all_sites = get_sites( $sitesarg );
              foreach($all_sites as $site) {
                $optval = $site->blogname . " (" . $site->blog_id . ")";
                $selected = ($optval === $value) ? 'selected="selected"' : '';
                $html .= '<option value="'.$optval.'" ' . $selected . '>'.$site->blogname.'</option>';
              }
            } else {
                $site = get_bloginfo( 'name');
                $html .= $site;
            }
            $html .= '</select>';
            $html .= "<span class='current-choice'>Current Blog:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <span class='boldtitle'>".$value."</span>";
            echo $html;

          } //end ade_home_announcements_6_1_callback

        function ade_home_announcements_6_2_callback() {
          //Simple post ID input box -- waaaayyyy too difficult to create a dropdown to select posts based on blog change in post's blog selection field

          //get stored value for ade_home_announcements_6_2
            $setting = (array) get_option( 'ade_home_announcements_settings');

            $blog = 'ade_home_announcements_6_1'; //get current blog setting
            $blog = esc_attr( $setting[$blog] );  //get current blog setting value

            $blog = strchr($blog, "(", false); //parse string for post ID
            $blog = strchr($blog, ")", true); //parse again
            $blog = ltrim($blog, '(' ); //parse again

            $current_post_field = 'ade_home_announcements_6_2'; //get current post setting
            $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value

            //////// Query to get the current post's title
              global $originalblogid; //call global variable
              if ( is_multisite() ) {
                if ( strlen($blog) > 0 && $blog !== $originalblogid) {
                    $blog_id = $blog; //if so, then make that the blog_id
                  } else {
                    $blog_id = $originalblogid;
                  }
                switch_to_blog ($blog_id); // select correct blog, whether current or other
              }

              $current_post_object = get_post( $current_post, ARRAY_A );
              $current_post_title = $current_post_object['post_title'];

              if( is_multisite() ) {
                switch_to_blog ($originalblogid);
              }
            //end query

            $html = "<input type='text' name='ade_home_announcements_settings[$current_post_field]' value='$current_post'  class='ade-homepage-widgets-choose-new'/>";
            $html .= "<span class='current-choice'>Current Post: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post_title."</span> (ID = ".$current_post.") ";
            echo $html;
          } //end ade_home_announcements_6_2_callback

        function ade_home_announcements_6_3_callback() {
            $setting = (array) get_option( 'ade_home_announcements_settings');
            $current_post_field = 'ade_home_announcements_6_3'; //get current post setting
            $then = esc_attr( $setting[$current_post_field] ); //get current post setting value
            $lastdate = date( 'F d, Y', strtotime($then) );
            $now = date( 'F d, Y' );
            $html = "<input type='hidden' name='ade_home_announcements_settings[$current_post_field]'  value='$then' class='ade-homepage-widgets-datefield' />";
            $html .= "<span class='current-choice'>This announcement was added to the homepage on $lastdate. (Today is $now)</span>";
            echo $html;
          }

        function ade_home_announcements_6_4_callback() {
            $setting = (array) get_option( 'ade_home_announcements_settings');
            $current_post_field = 'ade_home_announcements_6_4'; //get current post setting
            $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
            $html = "<input type='text' name='ade_home_announcements_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
            $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
            echo $html;
          }

      // ANNOUNCEMENTS POST 7

        function ade_home_announcements_post_7_callback() { //Post 7 section
        } //end announcements_post_7_callback()

          function ade_home_announcements_7_1_callback() {
            //The way this function stores the blog name and id means that when this value is queried it will first need to be parsed to extract just the ID. The reason this function stores both name and id is to make the select field more user-friendly.
            $setting = (array) get_option( 'ade_home_announcements_settings');
            $field = 'ade_home_announcements_7_1';
            $value = esc_attr( $setting[$field] );
              $html = "<select id='post_7_blog_select' name='ade_home_announcements_settings[$field]' class='ade-homepage-widgets-choose-new'>";
              $html .= "<option id='no_blog' name='no_blog' value='no_blog'>Select Blog</option>";
              if( is_multisite() ) {
                $sitesarg = array( 'orderby' => 'path', 'order' => 'ASC', 'public' => 1, 'archived' => 0, 'deleted' => 0, 'number' => 150 );
    $all_sites = get_sites( $sitesarg );
                foreach($all_sites as $site) {
                  $optval = $site->blogname . " (" . $site->blog_id . ")";
                  $selected = ($optval === $value) ? 'selected="selected"' : '';
                  $html .= '<option value="'.$optval.'" ' . $selected . '>'.$site->blogname.'</option>';
                }
              } else {
                  $site = get_bloginfo( 'name');
                  $html .= $site;
              }
              $html .= '</select>';
              $html .= "<span class='current-choice'>Current Blog:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <span class='boldtitle'>".$value."</span>";
              echo $html;

            } //end ade_home_announcements_7_1_callback

          function ade_home_announcements_7_2_callback() {
            //Simple post ID input box -- waaaayyyy too difficult to create a dropdown to select posts based on blog change in post's blog selection field

            //get stored value for ade_home_announcements_7_2
              $setting = (array) get_option( 'ade_home_announcements_settings');

              $blog = 'ade_home_announcements_7_1'; //get current blog setting
              $blog = esc_attr( $setting[$blog] );  //get current blog setting value

              $blog = strchr($blog, "(", false); //parse string for post ID
              $blog = strchr($blog, ")", true); //parse again
              $blog = ltrim($blog, '(' ); //parse again

              $current_post_field = 'ade_home_announcements_7_2'; //get current post setting
              $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value

              //////// Query to get the current post's title
                global $originalblogid; //call global variable
                if ( is_multisite() ) {
                  if ( strlen($blog) > 0 && $blog !== $originalblogid) {
                      $blog_id = $blog; //if so, then make that the blog_id
                    } else {
                      $blog_id = $originalblogid;
                    }
                  switch_to_blog ($blog_id); // select correct blog, whether current or other
                }

                $current_post_object = get_post( $current_post, ARRAY_A );
                $current_post_title = $current_post_object['post_title'];

                if( is_multisite() ) {
                  switch_to_blog ($originalblogid);
                }
              //end query

              $html = "<input type='text' name='ade_home_announcements_settings[$current_post_field]' value='$current_post'  class='ade-homepage-widgets-choose-new'/>";
              $html .= "<span class='current-choice'>Current Post: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post_title."</span> (ID = ".$current_post.") ";
              echo $html;
            } //end ade_home_announcements_7_2_callback

          function ade_home_announcements_7_3_callback() {
              $setting = (array) get_option( 'ade_home_announcements_settings');
              $current_post_field = 'ade_home_announcements_7_3'; //get current post setting
              $then = esc_attr( $setting[$current_post_field] ); //get current post setting value
              $lastdate = date( 'F d, Y', strtotime($then) );
              $now = date( 'F d, Y' );
              $html = "<input type='hidden' name='ade_home_announcements_settings[$current_post_field]'  value='$then' class='ade-homepage-widgets-datefield' />";
              $html .= "<span class='current-choice'>This announcement was added to the homepage on $lastdate. (Today is $now)</span>";
              echo $html;
            }

          function ade_home_announcements_7_4_callback() {
              $setting = (array) get_option( 'ade_home_announcements_settings');
              $current_post_field = 'ade_home_announcements_7_4'; //get current post setting
              $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
              $html = "<input type='text' name='ade_home_announcements_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
              $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
              echo $html;
            }

        // ANNOUNCEMENTS POST 8

          function ade_home_announcements_post_8_callback() { //Post 8 section
          } //end announcements_post_8_callback()

            function ade_home_announcements_8_1_callback() {
              //The way this function stores the blog name and id means that when this value is queried it will first need to be parsed to extract just the ID. The reason this function stores both name and id is to make the select field more user-friendly.
              $setting = (array) get_option( 'ade_home_announcements_settings');
              $field = 'ade_home_announcements_8_1';
              $value = esc_attr( $setting[$field] );
                $html = "<select id='post_8_blog_select' name='ade_home_announcements_settings[$field]' class='ade-homepage-widgets-choose-new'>";
                $html .= "<option id='no_blog' name='no_blog' value='no_blog'>Select Blog</option>";
                if( is_multisite() ) {
                  $sitesarg = array( 'orderby' => 'path', 'order' => 'ASC', 'public' => 1, 'archived' => 0, 'deleted' => 0, 'number' => 150 );
      $all_sites = get_sites( $sitesarg );
                  foreach($all_sites as $site) {
                    $optval = $site->blogname . " (" . $site->blog_id . ")";
                    $selected = ($optval === $value) ? 'selected="selected"' : '';
                    $html .= '<option value="'.$optval.'" ' . $selected . '>'.$site->blogname.'</option>';
                  }
                } else {
                    $site = get_bloginfo( 'name');
                    $html .= $site;
                }
                $html .= '</select>';
                $html .= "<span class='current-choice'>Current Blog:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <span class='boldtitle'>".$value."</span>";
                echo $html;

              } //end ade_home_announcements_8_1_callback

            function ade_home_announcements_8_2_callback() {
              //Simple post ID input box -- waaaayyyy too difficult to create a dropdown to select posts based on blog change in post's blog selection field

              //get stored value for ade_home_announcements_8_2
                $setting = (array) get_option( 'ade_home_announcements_settings');

                $blog = 'ade_home_announcements_8_1'; //get current blog setting
                $blog = esc_attr( $setting[$blog] );  //get current blog setting value

                $blog = strchr($blog, "(", false); //parse string for post ID
                $blog = strchr($blog, ")", true); //parse again
                $blog = ltrim($blog, '(' ); //parse again

                $current_post_field = 'ade_home_announcements_8_2'; //get current post setting
                $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value

                //////// Query to get the current post's title
                  global $originalblogid; //call global variable
                  if ( is_multisite() ) {
                    if ( strlen($blog) > 0 && $blog !== $originalblogid) {
                        $blog_id = $blog; //if so, then make that the blog_id
                      } else {
                        $blog_id = $originalblogid;
                      }
                    switch_to_blog ($blog_id); // select correct blog, whether current or other
                  }

                  $current_post_object = get_post( $current_post, ARRAY_A );
                  $current_post_title = $current_post_object['post_title'];

                  if( is_multisite() ) {
                    switch_to_blog ($originalblogid);
                  }
                //end query

                $html = "<input type='text' name='ade_home_announcements_settings[$current_post_field]' value='$current_post'  class='ade-homepage-widgets-choose-new'/>";
                $html .= "<span class='current-choice'>Current Post: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post_title."</span> (ID = ".$current_post.") ";
                echo $html;
              } //end ade_home_announcements_8_2_callback

            function ade_home_announcements_8_3_callback() {
                $setting = (array) get_option( 'ade_home_announcements_settings');
                $current_post_field = 'ade_home_announcements_8_3'; //get current post setting
                $then = esc_attr( $setting[$current_post_field] ); //get current post setting value
                $lastdate = date( 'F d, Y', strtotime($then) );
                $now = date( 'F d, Y' );
                $html = "<input type='hidden' name='ade_home_announcements_settings[$current_post_field]'  value='$then' class='ade-homepage-widgets-datefield' />";
                $html .= "<span class='current-choice'>This announcement was added to the homepage on $lastdate. (Today is $now)</span>";
                echo $html;
              }

            function ade_home_announcements_8_4_callback() {
                $setting = (array) get_option( 'ade_home_announcements_settings');
                $current_post_field = 'ade_home_announcements_8_4'; //get current post setting
                $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
                $html = "<input type='text' name='ade_home_announcements_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
                $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
                echo $html;
              }


  /* ---------------------------------------------------------- *
   * POST ID CALLBACKS
   * ---------------------------------------------------------- */

   //
     function ade_home_post_id_blog_callback() {
       $setting = (array) get_option( 'ade_home_post_id_settings');
       $field = 'ade_home_post_id_blog';

       $value = esc_attr( $setting[$field] );
         $html = "<select id='ade_home_post_id_blog_select' name='ade_home_post_id_settings[$field]' class='ade-homepage-widgets-choose-new'>";
         $html .= "<option id='no_blog' name='no_blog' value='no_blog'>Select Blog</option>";
         if( is_multisite() ) {
           $sitesarg = array( 'orderby' => 'path', 'order' => 'ASC', 'public' => 1, 'archived' => 0, 'deleted' => 0, 'number' => 150 );
           $all_sites = get_sites( $sitesarg );
           foreach($all_sites as $site) {
             $optval = $site->blogname . " (" . $site->blog_id . ")";
             $selected = ($optval === $value) ? 'selected="selected"' : '';
             $html .= '<option value="'.$optval.'" ' . $selected . '>'.$site->blogname.'</option>';
           }
         } else {
             $site = get_bloginfo( 'name');
             $html .= $site;
         }
         $html .= '</select>';
         echo $html;
       } //end

     function ade_home_post_id_list_callback() {
       $setting = (array) get_option( 'ade_home_post_id_settings');
       $blog = 'ade_home_post_id_blog';
       $blog = esc_attr( $setting[$blog] );  //get current blog setting value
       $blog = strchr($blog, "(", false); //parse string for post ID
       $blog = strchr($blog, ")", true); //parse again
       $blog = ltrim($blog, '(' ); //parse again
       ////// Query to get the posts
         global $originalblogid; //call global variable
         if ( is_multisite() ) {
           if ( strlen($blog) > 0 && $blog !== $originalblogid) {
               $blogid = $blog; //if so, then make that the blog_id
             } else {
               $blogid = $originalblogid;
             }
           switch_to_blog ($blogid); // select correct blog, whether current or other
         }

         $args = array (
           'orderby' => 'date',
           'order' => 'DESC',
           'post_status' => 'publish',
           'post_type' => array( 'post', 'ai1ec_event' ),
           'numberposts' => 25
         );
         $postlist = get_posts( $args );
         if( $postlist ) {

           $html = '<table id="postslist"><tr><th>Post Title</th><th>Post ID</th><th>Date Updated/Published</th></tr>';
           foreach ( $postlist as $post ) :
             setup_postdata( $post );
             $PID = $post->ID;
             $PT = $post->post_title;
             $PMD = $post->post_modified;
             $html .= "<tr><td vertical-align:text-top;>".$PT."</td><td>".$PID."</td><td>".$PMD."</td></tr>";
           endforeach;
           wp_reset_postdata();
           $html .= '</table>';
         }
         if( is_multisite() ) {
           switch_to_blog ($originalblogid);
         }
         echo $html;
     }

 /* ---------------------------------------------------------- *
  * CALLBACKS - HEADLINES WIDGET
  * ---------------------------------------------------------- */

 // HEADLINES WIDGET

   function ade_home_headlines_widget_callback() { //Post 1 section
     } //end announcements_post_1_callback()

   //Fields
     function ade_home_headlines_1_1_callback() {
       //The way this function stores the blog name and id means that when this value is queried it will first need to be parsed to extract just the ID. The reason this function stores both name and id is to make the select field more user-friendly.
       $setting = (array) get_option( 'ade_home_headlines_settings');
       $field = 'ade_home_headlines_1_1';
       $value = esc_attr( $setting[$field] );

       $html = "<select id='ade_home_headlines_blog_select' name='ade_home_headlines_settings[$field]' class='ade-homepage-widgets-choose-new'>";
       $html .= "<option id='no_blog' name='no_blog' value='no_blog'>Select Blog</option>";

       if( is_multisite() ) {
         $sitesarg = array( 'orderby' => 'path', 'order' => 'ASC', 'public' => 1, 'archived' => 0, 'deleted' => 0, 'number' => 150 );
$all_sites = get_sites( $sitesarg );
         foreach($all_sites as $site) {
           $optval = $site->blogname . " (" . $site->blog_id . ")";
           $selected = ($optval === $value) ? 'selected="selected"' : '';
           $html .= '<option value="'.$optval.'" ' . $selected . '>'.$site->blogname.'</option>';
         }
       } else {
           $site = get_bloginfo( 'name');
           $html .= $site;
       }

       $html .= '</select>';
       $html .= "<span class='current-choice'>Current Blog:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <span class='boldtitle'>".$value."</span>";

         echo $html;

       } //end ade_home_announcements_1_1_callback

   function ade_home_headlines_1_2_callback() {
       $setting = (array) get_option( 'ade_home_headlines_settings');

       $field = 'ade_home_headlines_1_2'; //get current  setting
       $current_category = esc_attr( $setting[$field] ); //get current  setting value

       $html = "<input type='text' name='ade_home_headlines_settings[$field]' value='$current_category'  class='ade-homepage-widgets-choose-new'/>";
       $html .= "<span class='current-choice'>Current Category: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_category."</span>";
       echo $html;
     } //end ade_home_headlines_1_2_callback

   function ade_home_headlines_1_3_callback() {
       $setting = (array) get_option( 'ade_home_headlines_settings');

       $field = 'ade_home_headlines_1_3'; //get current post setting
       $current_num = esc_attr( $setting[$field] ); //get current post setting value

       $html = "<input type='text' name='ade_home_headlines_settings[$field]' value='$current_num'  class='ade-homepage-widgets-choose-new'/>";
       $html .= "<span class='current-choice'>Current Number: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_num."</span>";
       echo $html;
     } //end ade_home_headlines_1_3_callback


 /* ---------------------------------------------------------- *
  * CALLBACKS - BLOG CORNER BOXES
  * ---------------------------------------------------------- */

 // BLOG CORNER BOX 1

   function ade_home_blog_corner_box_1_callback() {
     }

     function ade_home_blog_corner_box_1_1_callback() {
       $setting = (array) get_option( 'ade_home_blog_corner_settings');
       $field = 'ade_home_blog_corner_box_1_1';
       $value = esc_attr( $setting[$field] );

       $html = "<select id='ade_home_blog_corner_box_1_1_blog_select' name='ade_home_blog_corner_settings[$field]' class='ade-homepage-widgets-choose-new'>";
       $html .= "<option id='no_blog' name='no_blog' value='no_blog'>Select Blog</option>";

       if( is_multisite() ) {
         $sitesarg = array( 'orderby' => 'path', 'order' => 'ASC', 'public' => 1, 'archived' => 0, 'deleted' => 0, 'number' => 150 );
$all_sites = get_sites( $sitesarg );
         foreach($all_sites as $site) {
           $optval = $site->blogname . " (" . $site->blog_id . ")";
           $selected = ($optval === $value) ? 'selected="selected"' : '';
           $html .= '<option value="'.$optval.'" ' . $selected . '>'.$site->blogname.'</option>';
         }
       } else {
           $site = get_bloginfo( 'name');
           $html .= $site;
       }

       $html .= '</select>';
       $html .= "<span class='current-choice'>Current Blog:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <span class='boldtitle'>".$value."</span>";

         echo $html;

       }

     function ade_home_blog_corner_box_1_2_callback() {
         $setting = (array) get_option( 'ade_home_blog_corner_settings');

         $blog = 'ade_home_blog_corner_box_1_1'; //get current blog setting
         $blog = esc_attr( $setting[$blog] );  //get current blog setting value

         $blog = strchr($blog, "(", false); //parse string for post ID
         $blog = strchr($blog, ")", true); //parse again
         $blog = ltrim($blog, '(' ); //parse again

         $current_post_field = 'ade_home_blog_corner_box_1_2'; //get current post setting
         $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value

         //////// Query to get the current post's title
           global $originalblogid; //call global variable

           if ( is_multisite() ) {
             if ( strlen($blog) > 0 && $blog !== $originalblogid) {
                 $blog_id = $blog; //if so, then make that the blog_id
               } else {
                 $blog_id = $originalblogid;
               }
             switch_to_blog ($blog_id); // select correct blog, whether current or other
           }

           $current_post_object = get_post( $current_post, ARRAY_A );
           $current_post_title = $current_post_object['post_title'];

           if( is_multisite() ) {
             switch_to_blog ($originalblogid);
           }
         //end query

         $html = "<input type='text' name='ade_home_blog_corner_settings[$current_post_field]' value='$current_post'  class='ade-homepage-widgets-choose-new' />";
         $html .= "<span class='current-choice'>Current Post: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post_title."</span>  (ID = ".$current_post.")";
         echo $html;
       }

       function ade_home_blog_corner_box_1_3_callback() {
           $setting = (array) get_option( 'ade_home_blog_corner_settings');
           $current_post_field = 'ade_home_blog_corner_box_1_3'; //get current post setting
           $then = esc_attr( $setting[$current_post_field] ); //get current post setting value
           $lastdate = date( 'F d, Y', strtotime($then) );
           $now = date( 'F d, Y' );
           $html = "<input type='hidden' name='ade_home_blog_corner_settings[$current_post_field]'  value='$then' class='ade-homepage-widgets-datefield' />";
           $html .= "<span class='current-choice'>This post was added to the homepage on $lastdate (Today is $now)</span>";
           echo $html;
         }

      function ade_home_blog_corner_box_1_4_callback() {
          $setting = (array) get_option( 'ade_home_blog_corner_settings');
          $current_post_field = 'ade_home_blog_corner_box_1_4'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_blog_corner_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'><i class='fa fa-".$current_post." fa-2x'></i></span>";
          echo $html;
        }

      function ade_home_blog_corner_box_1_5_callback() {
          $setting = (array) get_option( 'ade_home_blog_corner_settings');
          $current_post_field = 'ade_home_blog_corner_box_1_5'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_blog_corner_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
          echo $html;
        }

    // BLOG CORNER BOX 2

      function ade_home_blog_corner_box_2_callback() {
        }

        function ade_home_blog_corner_box_2_1_callback() {
          $setting = (array) get_option( 'ade_home_blog_corner_settings');
          $field = 'ade_home_blog_corner_box_2_1';
          $value = esc_attr( $setting[$field] );

          $html = "<select id='ade_home_blog_corner_box_2_1_blog_select' name='ade_home_blog_corner_settings[$field]' class='ade-homepage-widgets-choose-new'>";
          $html .= "<option id='no_blog' name='no_blog' value='no_blog'>Select Blog</option>";

          if( is_multisite() ) {
            $sitesarg = array( 'orderby' => 'path', 'order' => 'ASC', 'public' => 1, 'archived' => 0, 'deleted' => 0, 'number' => 150 );
            $all_sites = get_sites( $sitesarg );
            foreach($all_sites as $site) {
              $optval = $site->blogname . " (" . $site->blog_id . ")";
              $selected = ($optval === $value) ? 'selected="selected"' : '';
              $html .= '<option value="'.$optval.'" ' . $selected . '>'.$site->blogname.'</option>';
            }
          } else {
              $site = get_bloginfo( 'name');
              $html .= $site;
          }

          $html .= '</select>';
          $html .= "<span class='current-choice'>Current Blog:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <span class='boldtitle'>".$value."</span>";

            echo $html;

          }

        function ade_home_blog_corner_box_2_2_callback() {
            $setting = (array) get_option( 'ade_home_blog_corner_settings');

            $blog = 'ade_home_blog_corner_box_2_1'; //get current blog setting
            $blog = esc_attr( $setting[$blog] );  //get current blog setting value

            $blog = strchr($blog, "(", false); //parse string for post ID
            $blog = strchr($blog, ")", true); //parse again
            $blog = ltrim($blog, '(' ); //parse again

            $current_post_field = 'ade_home_blog_corner_box_2_2'; //get current post setting
            $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value

            //////// Query to get the current post's title
              global $originalblogid; //call global variable

              if ( is_multisite() ) {
                if ( strlen($blog) > 0 && $blog !== $originalblogid) {
                    $blog_id = $blog; //if so, then make that the blog_id
                  } else {
                    $blog_id = $originalblogid;
                  }
                switch_to_blog ($blog_id); // select correct blog, whether current or other
              }

              $current_post_object = get_post( $current_post, ARRAY_A );
              $current_post_title = $current_post_object['post_title'];

              if( is_multisite() ) {
                switch_to_blog ($originalblogid);
              }
            //end query

            $html = "<input type='text' name='ade_home_blog_corner_settings[$current_post_field]' value='$current_post'  class='ade-homepage-widgets-choose-new'/>";
            $html .= "<span class='current-choice'>Current Post: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post_title."</span>  (ID = ".$current_post.")";
            echo $html;
          }

          function ade_home_blog_corner_box_2_3_callback() {
              $setting = (array) get_option( 'ade_home_blog_corner_settings');
              $current_post_field = 'ade_home_blog_corner_box_2_3'; //get current post setting
              $then = esc_attr( $setting[$current_post_field] ); //get current post setting value
              $lastdate = date( 'F d, Y', strtotime($then) );
              $now = date( 'F d, Y' );
              $html = "<input type='hidden' name='ade_home_blog_corner_settings[$current_post_field]'  value='$then' class='ade-homepage-widgets-datefield' />";
              $html .= "<span class='current-choice'>This post was added to the homepage on $lastdate (Today is $now)</span>";
              echo $html;
            }

         function ade_home_blog_corner_box_2_4_callback() {
             $setting = (array) get_option( 'ade_home_blog_corner_settings');
             $current_post_field = 'ade_home_blog_corner_box_2_4'; //get current post setting
             $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
             $html = "<input type='text' name='ade_home_blog_corner_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
             $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'><i class='fa fa-".$current_post." fa-2x'></i></span>";
             echo $html;
           }

         function ade_home_blog_corner_box_2_5_callback() {
             $setting = (array) get_option( 'ade_home_blog_corner_settings');
             $current_post_field = 'ade_home_blog_corner_box_2_5'; //get current post setting
             $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
             $html = "<input type='text' name='ade_home_blog_corner_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
             $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
             echo $html;
           }

     // BLOG CORNER BOX 3

       function ade_home_blog_corner_box_3_callback() {
         }

         function ade_home_blog_corner_box_3_1_callback() {
           $setting = (array) get_option( 'ade_home_blog_corner_settings');
           $field = 'ade_home_blog_corner_box_3_1';
           $value = esc_attr( $setting[$field] );

           $html = "<select id='ade_home_blog_corner_box_3_1_blog_select' name='ade_home_blog_corner_settings[$field]' class='ade-homepage-widgets-choose-new'>";
           $html .= "<option id='no_blog' name='no_blog' value='no_blog'>Select Blog</option>";

           if( is_multisite() ) {
             $sitesarg = array( 'orderby' => 'path', 'order' => 'ASC', 'public' => 1, 'archived' => 0, 'deleted' => 0, 'number' => 150 );
$all_sites = get_sites( $sitesarg );
             foreach($all_sites as $site) {
               $optval = $site->blogname . " (" . $site->blog_id . ")";
               $selected = ($optval === $value) ? 'selected="selected"' : '';
               $html .= '<option value="'.$optval.'" ' . $selected . '>'.$site->blogname.'</option>';
             }
           } else {
               $site = get_bloginfo( 'name');
               $html .= $site;
           }

           $html .= '</select>';
           $html .= "<span class='current-choice'>Current Blog:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <span class='boldtitle'>".$value."</span>";

             echo $html;

           }

         function ade_home_blog_corner_box_3_2_callback() {
             $setting = (array) get_option( 'ade_home_blog_corner_settings');

             $blog = 'ade_home_blog_corner_box_3_1'; //get current blog setting
             $blog = esc_attr( $setting[$blog] );  //get current blog setting value

             $blog = strchr($blog, "(", false); //parse string for post ID
             $blog = strchr($blog, ")", true); //parse again
             $blog = ltrim($blog, '(' ); //parse again

             $current_post_field = 'ade_home_blog_corner_box_3_2'; //get current post setting
             $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value

             //////// Query to get the current post's title
               global $originalblogid; //call global variable

               if ( is_multisite() ) {
                 if ( strlen($blog) > 0 && $blog !== $originalblogid) {
                     $blog_id = $blog; //if so, then make that the blog_id
                   } else {
                     $blog_id = $originalblogid;
                   }
                 switch_to_blog ($blog_id); // select correct blog, whether current or other
               }

               $current_post_object = get_post( $current_post, ARRAY_A );
               $current_post_title = $current_post_object['post_title'];

               if( is_multisite() ) {
                 switch_to_blog ($originalblogid);
               }
             //end query

             $html = "<input type='text' name='ade_home_blog_corner_settings[$current_post_field]' value='$current_post'  class='ade-homepage-widgets-choose-new'/>";
             $html .= "<span class='current-choice'>Current Post: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post_title."</span>  (ID = ".$current_post.")";
             echo $html;
           }

           function ade_home_blog_corner_box_3_3_callback() {
               $setting = (array) get_option( 'ade_home_blog_corner_settings');
               $current_post_field = 'ade_home_blog_corner_box_3_3'; //get current post setting
               $then = esc_attr( $setting[$current_post_field] ); //get current post setting value
               $lastdate = date( 'F d, Y', strtotime($then) );
               $now = date( 'F d, Y' );
               $html = "<input type='hidden' name='ade_home_blog_corner_settings[$current_post_field]'  value='$then' class='ade-homepage-widgets-datefield' />";
               $html .= "<span class='current-choice'>This post was added to the homepage on $lastdate (Today is $now)</span>";
               echo $html;
             }

          function ade_home_blog_corner_box_3_4_callback() {
              $setting = (array) get_option( 'ade_home_blog_corner_settings');
              $current_post_field = 'ade_home_blog_corner_box_3_4'; //get current post setting
              $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
              $html = "<input type='text' name='ade_home_blog_corner_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
              $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'><i class='fa fa-".$current_post." fa-2x'></i></span>";
              echo $html;
            }

          function ade_home_blog_corner_box_3_5_callback() {
              $setting = (array) get_option( 'ade_home_blog_corner_settings');
              $current_post_field = 'ade_home_blog_corner_box_3_5'; //get current post setting
              $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
              $html = "<input type='text' name='ade_home_blog_corner_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
              $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
              echo $html;
            }

        // BLOG CORNER BOX 4

          function ade_home_blog_corner_box_4_callback() {
            }

            function ade_home_blog_corner_box_4_1_callback() {
              $setting = (array) get_option( 'ade_home_blog_corner_settings');
              $field = 'ade_home_blog_corner_box_4_1';
              $value = esc_attr( $setting[$field] );

              $html = "<select id='ade_home_blog_corner_box_4_1_blog_select' name='ade_home_blog_corner_settings[$field]' class='ade-homepage-widgets-choose-new'>";
              $html .= "<option id='no_blog' name='no_blog' value='no_blog'>Select Blog</option>";

              if( is_multisite() ) {
                $sitesarg = array( 'orderby' => 'path', 'order' => 'ASC', 'public' => 1, 'archived' => 0, 'deleted' => 0, 'number' => 150 );
                $all_sites = get_sites( $sitesarg );
                foreach($all_sites as $site) {
                  $optval = $site->blogname . " (" . $site->blog_id . ")";
                  $selected = ($optval === $value) ? 'selected="selected"' : '';
                  $html .= '<option value="'.$optval.'" ' . $selected . '>'.$site->blogname.'</option>';
                }
              } else {
                  $site = get_bloginfo( 'name');
                  $html .= $site;
              }

              $html .= '</select>';
              $html .= "<span class='current-choice'>Current Blog:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <span class='boldtitle'>".$value."</span>";

                echo $html;

              }

            function ade_home_blog_corner_box_4_2_callback() {
                $setting = (array) get_option( 'ade_home_blog_corner_settings');

                $blog = 'ade_home_blog_corner_box_4_1'; //get current blog setting
                $blog = esc_attr( $setting[$blog] );  //get current blog setting value

                $blog = strchr($blog, "(", false); //parse string for post ID
                $blog = strchr($blog, ")", true); //parse again
                $blog = ltrim($blog, '(' ); //parse again

                $current_post_field = 'ade_home_blog_corner_box_4_2'; //get current post setting
                $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value

                //////// Query to get the current post's title
                  global $originalblogid; //call global variable

                  if ( is_multisite() ) {
                    if ( strlen($blog) > 0 && $blog !== $originalblogid) {
                        $blog_id = $blog; //if so, then make that the blog_id
                      } else {
                        $blog_id = $originalblogid;
                      }
                    switch_to_blog ($blog_id); // select correct blog, whether current or other
                  }

                  $current_post_object = get_post( $current_post, ARRAY_A );
                  $current_post_title = $current_post_object['post_title'];

                  if( is_multisite() ) {
                    switch_to_blog ($originalblogid);
                  }
                //end query

                $html = "<input type='text' name='ade_home_blog_corner_settings[$current_post_field]' value='$current_post'  class='ade-homepage-widgets-choose-new'/>";
                $html .= "<span class='current-choice'>Current Post: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post_title."</span>  (ID = ".$current_post.")";
                echo $html;
              }

              function ade_home_blog_corner_box_4_3_callback() {
                  $setting = (array) get_option( 'ade_home_blog_corner_settings');
                  $current_post_field = 'ade_home_blog_corner_box_4_3'; //get current post setting
                  $then = esc_attr( $setting[$current_post_field] ); //get current post setting value
                  $lastdate = date( 'F d, Y', strtotime($then) );
                  $now = date( 'F d, Y' );
                  $html = "<input type='hidden' name='ade_home_blog_corner_settings[$current_post_field]'  value='$then' class='ade-homepage-widgets-datefield' />";
                  $html .= "<span class='current-choice'>This post was added to the homepage on $lastdate (Today is $now)</span>";
                  echo $html;
                }

             function ade_home_blog_corner_box_4_4_callback() {
                 $setting = (array) get_option( 'ade_home_blog_corner_settings');
                 $current_post_field = 'ade_home_blog_corner_box_4_4'; //get current post setting
                 $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
                 $html = "<input type='text' name='ade_home_blog_corner_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
                 $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'><i class='fa fa-".$current_post." fa-2x'></i></span>";
                 echo $html;
               }

             function ade_home_blog_corner_box_4_5_callback() {
                 $setting = (array) get_option( 'ade_home_blog_corner_settings');
                 $current_post_field = 'ade_home_blog_corner_box_4_5'; //get current post setting
                 $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
                 $html = "<input type='text' name='ade_home_blog_corner_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
                 $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
                 echo $html;
               }

   /* ---------------------------------------------------------- *
    * CALLBACKS - QUICK LINKS
    * ---------------------------------------------------------- */
    // Quick Link 1
      function ade_home_quicklinks_1_callback() {
        }
      function ade_home_quicklinks_1_1_callback() {
          $setting = (array) get_option( 'ade_home_quicklinks_settings');
          $current_post_field = 'ade_home_quicklinks_1_1'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_quicklinks_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'><i class='fa fa-".$current_post." fa-2x'></i></span>";
          echo $html;
        }
      function ade_home_quicklinks_1_2_callback() {
          $setting = (array) get_option( 'ade_home_quicklinks_settings');
          $current_post_field = 'ade_home_quicklinks_1_2'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_quicklinks_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
          echo $html;
        }
      function ade_home_quicklinks_1_3_callback() {
          $setting = (array) get_option( 'ade_home_quicklinks_settings');
          $current_post_field = 'ade_home_quicklinks_1_3'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_quicklinks_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
          echo $html;
        }

    // Quick Link 2
      function ade_home_quicklinks_2_callback() {
        }
      function ade_home_quicklinks_2_1_callback() {
          $setting = (array) get_option( 'ade_home_quicklinks_settings');
          $current_post_field = 'ade_home_quicklinks_2_1'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_quicklinks_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'><i class='fa fa-".$current_post." fa-2x'></i></span>";
          echo $html;
        }
      function ade_home_quicklinks_2_2_callback() {
          $setting = (array) get_option( 'ade_home_quicklinks_settings');
          $current_post_field = 'ade_home_quicklinks_2_2'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_quicklinks_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
          echo $html;
        }
      function ade_home_quicklinks_2_3_callback() {
          $setting = (array) get_option( 'ade_home_quicklinks_settings');
          $current_post_field = 'ade_home_quicklinks_2_3'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_quicklinks_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
          echo $html;
        }

    // Quick Link 3
      function ade_home_quicklinks_3_callback() {
        }
      function ade_home_quicklinks_3_1_callback() {
          $setting = (array) get_option( 'ade_home_quicklinks_settings');
          $current_post_field = 'ade_home_quicklinks_3_1'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_quicklinks_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'><i class='fa fa-".$current_post." fa-2x'></i></span>";
          echo $html;
        }
      function ade_home_quicklinks_3_2_callback() {
          $setting = (array) get_option( 'ade_home_quicklinks_settings');
          $current_post_field = 'ade_home_quicklinks_3_2'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_quicklinks_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
          echo $html;
        }
      function ade_home_quicklinks_3_3_callback() {
          $setting = (array) get_option( 'ade_home_quicklinks_settings');
          $current_post_field = 'ade_home_quicklinks_3_3'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_quicklinks_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
          echo $html;
        }

    // Quick Link 4
      function ade_home_quicklinks_4_callback() {
        }
      function ade_home_quicklinks_4_1_callback() {
          $setting = (array) get_option( 'ade_home_quicklinks_settings');
          $current_post_field = 'ade_home_quicklinks_4_1'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_quicklinks_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'><i class='fa fa-".$current_post." fa-2x'></i></span>";
          echo $html;
        }
      function ade_home_quicklinks_4_2_callback() {
          $setting = (array) get_option( 'ade_home_quicklinks_settings');
          $current_post_field = 'ade_home_quicklinks_4_2'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_quicklinks_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
          echo $html;
        }
      function ade_home_quicklinks_4_3_callback() {
          $setting = (array) get_option( 'ade_home_quicklinks_settings');
          $current_post_field = 'ade_home_quicklinks_4_3'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_quicklinks_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
          echo $html;
        }

    // Quick Link 5
      function ade_home_quicklinks_5_callback() {
        }
      function ade_home_quicklinks_5_1_callback() {
          $setting = (array) get_option( 'ade_home_quicklinks_settings');
          $current_post_field = 'ade_home_quicklinks_5_1'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_quicklinks_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'><i class='fa fa-".$current_post." fa-2x'></i></span>";
          echo $html;
        }
      function ade_home_quicklinks_5_2_callback() {
          $setting = (array) get_option( 'ade_home_quicklinks_settings');
          $current_post_field = 'ade_home_quicklinks_5_2'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_quicklinks_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
          echo $html;
        }
      function ade_home_quicklinks_5_3_callback() {
          $setting = (array) get_option( 'ade_home_quicklinks_settings');
          $current_post_field = 'ade_home_quicklinks_5_3'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_quicklinks_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
          echo $html;
        }

    // Quick Link 6
      function ade_home_quicklinks_6_callback() {
        }
      function ade_home_quicklinks_6_1_callback() {
          $setting = (array) get_option( 'ade_home_quicklinks_settings');
          $current_post_field = 'ade_home_quicklinks_6_1'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_quicklinks_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'><i class='fa fa-".$current_post." fa-2x'></i></span>";
          echo $html;
        }
      function ade_home_quicklinks_6_2_callback() {
          $setting = (array) get_option( 'ade_home_quicklinks_settings');
          $current_post_field = 'ade_home_quicklinks_6_2'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_quicklinks_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
          echo $html;
        }
      function ade_home_quicklinks_6_3_callback() {
          $setting = (array) get_option( 'ade_home_quicklinks_settings');
          $current_post_field = 'ade_home_quicklinks_6_3'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_quicklinks_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
          echo $html;
        }

  /* ---------------------------------------------------------- *
   * CALLBACKS - STATIC MESSAGE
   * ---------------------------------------------------------- */

    // Quick Link 6
      function ade_home_message_1_callback() {
        }
      function ade_home_message_1_1_callback() {
          $setting = (array) get_option( 'ade_home_message_settings');
          $current_post_field = 'ade_home_message_1_1'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_message_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
          echo $html;
        }
      function ade_home_message_1_2_callback() {
          $setting = (array) get_option( 'ade_home_message_settings');
          $current_post_field = 'ade_home_message_1_2'; //get current post setting
          $current_post = esc_attr( $setting[$current_post_field] ); //get current post setting value
          $html = "<input type='text' name='ade_home_message_settings[$current_post_field]' class='ade-homepage-widgets-choose-new' value='$current_post' />";
          $html .= "<span class='current-choice'>Current: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span class='boldtitle'>".$current_post."</span>";
          echo $html;
        }

  /* ---------------------------------------------------------- *
   * PAGE OUTPUT - FEATURES
   * ---------------------------------------------------------- */

  function ade_home_features_menu_output(){
  if  (!current_user_can('administrator')) { return; } //check user permissions
  ?>
  <div class="wrap">
  <h1><?php echo esc_html(get_admin_page_title() ); ?></h1>
  <p>This widget creates the Features box slider on the ADE homepage. It shows 4 blog posts in the order entered below. For each slot, you may select a different blog and post.</p>
  <p><strong>Important: Post 1 will be the post seen when the widget loads.</strong></p>
  <p><strong><em>Use the Post ID Lookup menu page to list posts for an ADE blog. Use the post IDs from that list for the Enter Post ID field below.</em></strong></p>
  <p><em>Configure each post slot as follows:
    <ol>
      <li>Use the dropdown to select the blog from which you want to pull posts. You must do this even if you are showing posts from this site.</li>
      <li>Enter the ID for the post you want to show. (Post IDs can be looked up via the Post ID Lookup admin screen.)</li>
    </em></ol></p>
    <form method="post" action="options.php" id="features-form" >
      <?php submit_button('Save Settings'); ?>
      <?php
         settings_fields( 'ade_home_features_settings' );
     ?>
      <?php
         do_settings_sections( 'ade_home_features_menu' );
     ?>
           <?php submit_button('Save Settings'); ?>
    </form>
  </div>
  <?php
  }

  /* ---------------------------------------------------------- *
   * PAGE OUTPUT - ANNOUNCEMENTS
   * ---------------------------------------------------------- */

  function ade_home_announcements_menu_output(){
  if  (!current_user_can('administrator')) { return; } //check user permissions
  ?>
  <div class="wrap">
  <h1><?php echo esc_html(get_admin_page_title() ); ?></h1>
  <p>This widget creates the Announcements box slider on the ADE homepage. It shows 4 blog or event posts in the order entered below. For each slot, you may select a different ADE blog and post.</p>
  <p><strong>Important: Post 1 will be the post seen when the widget loads.</strong></p>
  <p><strong><em>Use the Post ID Lookup menu page to list posts for an ADE blog. Use the post IDs from that list for the Enter Post ID field below.</em></strong></p>
  <p><em>Configure each post slot as follows:
    <ol>
      <li>Use the dropdown to select the blog from which you want to pull posts. You must do this even if you are showing posts from this site.</li>
      <li>Enter the ID for the post you want to show. (Post IDs can be looked up via the Post ID Lookup admin screen.)</li>
    </em></ol></p>
    <form method="post" action="options.php" id="announcements-form" >
          <?php submit_button('Save Settings'); ?>
      <?php
         settings_fields( 'ade_home_announcements_settings' );
     ?>
      <?php
         do_settings_sections( 'ade_home_announcements_menu' );
     ?>
           <?php submit_button('Save Settings'); ?>
    </form>
  </div>
  <?php
  }


  /* ---------------------------------------------------------- *
   * PAGE OUTPUT - Find Post ID
   * ---------------------------------------------------------- */

  function ade_home_post_id_menu_output(){
  if  (!current_user_can('administrator')) { return; } //check user permissions
  ?>
  <div class="wrap">
  <h1><?php echo esc_html(get_admin_page_title() ); ?></h1>
  <p><em>Use this page to get list of all blog posts and their IDs for an ADE blog.</em></p>
  <form method="post" action="options.php" id="post-id-form" >
       <?php submit_button('List Posts'); ?>
    <?php
       settings_fields( 'ade_home_post_id_settings' );
   ?>
    <?php
       do_settings_sections( 'ade_home_post_id_menu' );
   ?>
  </form>
  </div>
  <?php
  }


  /* ---------------------------------------------------------- *
   * PAGE OUTPUT - HEADLINES
   * ---------------------------------------------------------- */

  function ade_home_headlines_menu_output(){
  if  (!current_user_can('administrator')) { return; } //check user permissions
  ?>
  <div class="wrap">
  <h1><?php echo esc_html(get_admin_page_title() ); ?></h1>
  <p>This widget creates the a self-contained box with a dynamic list of posts from the indicated blog and category(ies). You may show posts from this site or you can choose a different ADE blog from the dropdown list. The posts will show in reverse chronological order (recent first) and consist of the post title and the publication date.<p>
  <p><em>Configure the Headlines Widget as follows:
    <ol>
      <li>Use the dropdown to select the blog from which you want to pull posts. You must do this even if you are showing posts from this site.</li>
      <li>Enter the slug for each category you want to include. Multiple categories must be separated by commas. (e.g. -> updates, news, profdev)</li>
      <li>Enter a numeral indicating how many posts you would like to show at a time. If the number is large, the widget will allow users to scroll through the posts.</li>
    </em></ol></p>
    <form method="post" action="options.php" id="headlines-form" >
      <?php
         settings_fields( 'ade_home_headlines_settings' );
     ?>
      <?php
         do_settings_sections( 'ade_home_headlines_menu' );
     ?>
      <?php submit_button('Save Settings'); ?>
    </form>
  </div>
  <?php
  }

  /* ---------------------------------------------------------- *
   * PAGE OUTPUT - BLOG CORNER
   * ---------------------------------------------------------- */

  function ade_home_blog_corner_menu_output(){
  if  (!current_user_can('administrator')) { return; } //check user permissions
  ?>
  <div class="wrap">
  <h1><?php echo esc_html(get_admin_page_title() ); ?></h1>
  <p>This page configures the four blog post boxes on the bottom half of the ADE homepage. Each box is configured independent of the other three.</p>
  <p><strong><em>Use the Post ID Lookup menu page to list posts for an ADE blog. Use the post IDs from that list for the Enter Post ID field below.</em></strong></p>
  <p><em>Configure each box as follows:
    <ol>
      <li>Use the dropdown to select the blog from which you want to pull posts. You must do this even if you are showing posts from this site.</li>
      <li>Enter the ID for the post you want to show. (Post IDs can be looked up via the Post ID Lookup admin screen.)</li>
      <li>If necessary, update the Banner Icon field with the name of a new <a href="http://fontawesome.io" target="_blank">Fontawesome icon.</a></li>
      <li>If desired, update the Banner Text field. Be careful to keep the text short.</li>
  <form method="post" action="options.php" id="blog-corner-form" >
       <?php submit_button('Save Settings'); ?>
    <?php
       settings_fields( 'ade_home_blog_corner_settings' );
   ?>
    <?php
       do_settings_sections( 'ade_home_blog_corner_menu' );
   ?>
         <?php submit_button('Save Settings'); ?>
  </form>
  </div>
  <?php
  }

  /* ---------------------------------------------------------- *
   * PAGE OUTPUT - QUICK LINKS
   * ---------------------------------------------------------- */

  function ade_home_quicklinks_menu_output(){
  if  (!current_user_can('administrator')) { return; } //check user permissions
  ?>
  <div class="wrap">
  <h1><?php echo esc_html(get_admin_page_title() ); ?></h1>
  <p>This widget creates a single row of 6 quicklinks in the center of the ADE homepage.
  <p><em>Configure the widget as follows:
      <ol>
        <li>Enter the name of the <a href="http://fontawesome.io" target="_blank">Fontawesome icon</a> you want to use.</li>
        <li>Enter the link (complete URL) for the quicklink.</li>
        <li>Enter a short title</li>
      </em></ol></p>
  <form method="post" action="options.php" id="quicklinks-form" >
       <?php submit_button('Save Settings'); ?>
    <?php
       settings_fields( 'ade_home_quicklinks_settings' );
   ?>
    <?php
       do_settings_sections( 'ade_home_quicklinks_menu' );
   ?>
      <?php submit_button('Save Settings'); ?>
  </form>
  </div>
  <?php
  }

  /* ---------------------------------------------------------- *
   * PAGE OUTPUT - STATIC MESSAGE
   * ---------------------------------------------------------- */

  function ade_home_message_menu_output(){
  if  (!current_user_can('administrator')) { return; } //check user permissions
  ?>
  <div class="wrap">
  <h1><?php echo esc_html(get_admin_page_title() ); ?></h1>
  <p><em>This controls the static text in the middle of the homepage, above the quick links section.</em></p>
  <form method="post" action="options.php" id="message-form" >
    <?php
       settings_fields( 'ade_home_message_settings' );
   ?>
    <?php
       do_settings_sections( 'ade_home_message_menu' );
   ?>
   <?php submit_button('Save Settings'); ?>

  </form>
  </div>
  <?php
  }

} // END admin_half()



/* ---------------------------------------------------------------------------*/
/* ---------------------------------------------------------------------------*/
/* ---------------------------------------------------------------------------*/



/* ---------------------------------------------------------- *
 * OUTPUT HALF OF PLUGIN
 * ---------------------------------------------------------- */
function ade_home_output_half(){


  /* ---------------------------------------------------------- *
   * ENQUEUE STYLES and SCRIPTS
   * ---------------------------------------------------------- */
   function ade_home_widgets_queue() {
     wp_enqueue_style( 'ade-home-widgets-style', plugins_url('ADE Homepage Widgets/ade-homepage-widgets-styles.css' ), array(), '1.4.0', 'all' );
     wp_enqueue_style( 'boxslider-style', plugins_url('ADE Homepage Widgets/jquery.bxslider/modified.jquery.bxslider.css' ) );
     wp_enqueue_script( 'boxslider-scripts' , plugins_url('ADE Homepage Widgets/jquery.bxslider/jquery.bxslider.min.js'), array( 'jquery' ), false, true );
     wp_enqueue_script( 'ade-homepage-widgets-scripts', plugins_url('ADE Homepage Widgets/ade-homepage-widgets-scripts.js'), array( 'boxslider-scripts' ), false, true );

   }
   add_action( 'wp_enqueue_scripts', 'ade_home_widgets_queue' );

  /* ---------------------------------------------------------- *
   * CALL OUTPUT FILE/FUNCTIONS
   * ---------------------------------------------------------- */
  include 'ade-homepage-widgets-output.php';

} // END output_half()

?>
