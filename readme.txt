=== ADE Homepage Widgets Plugin ===
Contributors: C. Walley, Arizona Department of Education
Version: 1.4.0
Updated: December 22, 2017
License: DO NOT USE THIS CODE WITHOUT PERMISSION

== Development Log ==

= December 22, 2017 =
  - changed version to 1.4.0
  - moved Message section to top of page template page-homepage.php (in ADE Theme 2016)
  - added clickable button to Message section, per exec team
  - adjusted styles & output file to account for moved Message and addition of button

= August 25, 2017 =
  - changed version to 1.3.0

= August 3, 2017 =
  - Tested new tags with GTM
  - Moving 1.2.0 into production

= July 31, 2017 (begin version 1.2.0) =
  * Added discrete classnames to as many clickable widget elements as possible to facilitate analytics with Google Tag Manager
    - .slider-features / .slider-announcements / .slider-features-thumb
    - .headlines-link
    - .boxwidget-post-thumb / .boxwidget-post-title
    - .quicklink-link / .staticmessage-link

= July 31, 2017 (end version 1.1.0) =
  * Tested successfully on live dev site against prod version of ADE Theme 2016
  * Merging back into production version

= July 28, 2017 =
  * Created DEV version duplicating original files at 11:30 a.m.
  * Added versioning to stylesheet and enqueue function to bust caching
  * Adjusted font size for headlines widget

= July 26, 2017 =
  * Added <section> and aria-labelledby references to increase web accessibility
  * Added 4 more slots to the Announcements widget
  * Rewrote widgets (Features, Announcements, Quick Links)
    - Replaced repetition with arrays
    - Added if/then logic to account for empty slots

= July 17, 2017 =
  * Updated Announcements widget with autoplay settings and controls
  * Refined some of CSS

= June 27, 2017 =
  * Removed empty top submenu page
  * Added instructions to admin pages
  * Removed date calculation and changed notice to read "This post was added on ____ (Today is ___)"

= June 19, 2017 =
  * Added script to update the hidden date field only when .choose-new field changes. Otherwise, the already-stored date is reposted to the database. This solves problem where all item dates changed whenever the page posted.

= June 15, 2017 =
  * Added optional link field to Announcements widget
  * Added item circles to Announcements widget custom pager

= June 8, 2017 =
  * Revamped styles to be more responsive

= June 7, 2017 =
  * Changed plugin name to ADE Homepage Widgets in preparation for creating separate ADE Widgets plugin for use with subsites
    - changed prefix to 'ade-home'

= May 26, 2017 =
  * Added admin screens for static message bar and quicklinks section of homepage template
  * Styled those sections

= May 25, 2017 =
  * Finished styling homepage template

= May 24, 2017 =
  * Changed plugin name to ADE Widgets, renamed files and changed prefixes accordingly
    - Prefix is now 'ade'
  * For now, homepage template is located in azdeptofed page templates folder and simply assigned to the page selected as static homepage
  * Twitter and Facebook widgets embedded directly in homepage template
  * Normalized image aspect ratios and containing widgets
    - Features uses 16:9
    - Announcements uses 4:3
    - Box widgets use 4:3

= May 23, 2017 =
  * Blog Corner sections (4 [boxwidget] instances ) created and styled, along with blog_corner_menu page
    - added to page-homepage.php by shortcode

= May 22, 2017 =
  * [headlines] widget created
  * Page template for ADE homepage created and styled for existing widgets
  * Admin screen for [headlines] created

= May 17, 2017 =
  * Managed to get multiple sliders on same page to work by moving the post_query function outside the shortcoded functions
  * Refined styles for [features] and [announcements]


= May 16, 2017 =
  * added if is_admin and pushed output functions to output.php
  * created features_widget() and [features] to wrap and call features widget via output.php
  * styled features_widget
  * integrated jQuery content slider 'bxSlider' (bxslider.com by Steven Wanderski)
  * added announcements_menu page settings

  Notes
    - [features] and [announcements] work independently, but not on same page

= May 15, 2017 =
  * can now show titles of current posts on features admin screen
  * added Post ID Lookup menu page to pull up list of posts with their IDs for selected blog
  * roughed out the features-query page template query and added as page template to azdeptofed (for testing)

= May 13, 2017 =
  * wp-admin.css successfully loading via native action admin_enqueue_scripts
  * ade16_homepage_menu successfully creates admin menu item ADE Homepage Settings and subitems Features and Announcements
  * ade16_features_init successfully registers features_post_1 section and fields
  * features_post_1_callback successfully posts and gets values from database
    - built blog select menu populated with list of all subsites
  * features_menu_output successfully outputs features settings and callback

  Notes
    - experimented with ajax to dynamically retrieve list of blog posts based on selected blog, but determined would be too unwieldy and require too many posts/page reloads

++++ To-Do List ++++
  > Populate all menu pages and fields
  > Create query to return name of current post (not new choice)
  > Create query using settings as arguments
  > Output query into shortcoded display widget
  > Style display widget, including working sliders

#### Plugin Concept ####
  ADE homepage will include various content widgets populated by blog posts originally published on various ADE subsites. Each widget's blog posts will be indicated via menu pages with settings or options inputs.
  Queries will run based on settings.

  >> TO DECIDE >>
    - Hardwire the settings page to the homepage template?
    - Create shortcodes that can also be used to embed posts elsewhere?
    - Truly widgetize code so can add similar widgets in other pages and sites?
    - Create way for person to recommend post for homepage inclusion, with link, blog name and post id sent to editor for easy input
