<?php

/**
 * Format the event date
 */

function eap_format_date($date) {
  // format event date
  $date = date('j F, Y', strtotime($date)); // strtotime transform date to unix time
  // split the date into an array with day, month and year
  $date = preg_split('/ /', $date);
  // strips the month from the comma at the end
  preg_match('/[a-z]+/i', $date[1], $match);
  $date[1] = $match[0];

  // returns the array with the three values
  return $date;
}

function eap_make_month_translatable($month) {
  switch ($month) {
    case 'January':
      $month = __('January', 'events-as-posts');
      break;
    case 'February':
      $month = __('February', 'events-as-posts');
      break;
    case 'March':
      $month = __('March', 'events-as-posts');
      break;
    case 'Abril':
      $month = __('Abril', 'events-as-posts');
      break;
    case 'May':
      $month = __('May', 'events-as-posts');
      break;
    case 'June':
      $month = __('June', 'events-as-posts');
      break;
    case 'July':
      $month = __('July', 'events-as-posts');
      break;
    case 'August':
      $month = __('August', 'events-as-posts');
      break;
    case 'September':
      $month = __('September', 'events-as-posts');
      break;
    case 'October':
      $month = __('October', 'events-as-posts');
      break;
    case 'November':
      $month = __('November', 'events-as-posts');
      break;
    case 'December':
      $month = __('December', 'events-as-posts');
  }
  return $month;
}

/**
 * Add event meta to the content
 */

function eap_add_meta_to_event_content( $content ) {

  ob_start();

  if( is_singular( 'eap_event' ) ) {
    include ( plugin_dir_path( __FILE__ ) . 'event-meta.php' );
  }

  $event_meta = ob_get_clean();
  $content = $event_meta . $content;
  return $content;
}
add_filter('the_content', 'eap_add_meta_to_event_content');

/**
 * Custom loops
 */

// display future events
function eap_display_events($atts) {
  ob_start();
  $actual_date = date('Y\-m\-d');
  // Shortcode attributes
  extract(shortcode_atts(array(
    'posts'          => '',
    'category'       => '',
    'order'          => 'ASC'
  ), $atts));

  $args = array (
     'posts_per_page' => $posts,
     'post_type'      => 'eap_event',
     'order'          => $order,
     'orderby'        => 'meta_value',
     'meta_key'       => 'eap_from_day',
     'category_name'  => $category,
     'meta_query'     => array(
       'key' => 'eap_from_day',
       'value' => $actual_date,
       'compare' => '>='
     ),
   );
   $custom_query = new WP_Query($args);
   if ($custom_query->have_posts()) : ?>
     <div class="eap__list">
       <?php while($custom_query->have_posts()) :
       // Post content
       $custom_query->the_post();
          // Displays event content
          include ( plugin_dir_path( __FILE__ ) . 'event-content.php' );
     endwhile; ?>
     </div>
     <br>
   <?php else :
     _e('There are no events', 'events-as-posts');
   endif;
   wp_reset_postdata();
   $loop_content = ob_get_clean();
   return $loop_content;
}

// display past events
function eap_display_past_events($atts) {
  ob_start();
  $actual_date = date('Y\-m\-d');
  // Shortcode attributes
  extract(shortcode_atts(array(
    'posts'          => '',
    'category'       => '',
    'order'          => 'DESC'
  ), $atts));

  $args = array (
     'posts_per_page' => $posts,
     'post_type'      => 'eap_event',
     'order'          => $order,
     'orderby'        => 'meta_value',
     'meta_key'       => 'eap_from_day',
     'category_name'  => $category,
     'meta_query'     => array(
       'key' => 'eap_from_day',
       'value' => $actual_date,
       'compare' => '<'
     ),
   );
   $custom_query = new WP_Query($args);
   if ($custom_query->have_posts()) : ?>
     <div class="eap__list">
     <?php while($custom_query->have_posts()) :
       // Post content
       $custom_query->the_post();
          // Displays event content
          include ( plugin_dir_path( __FILE__ ) . 'event-content.php' );
     endwhile; ?>
     </div>
     <br>
   <?php else :
     _e('There are no events', 'events-as-posts');
   endif;
   wp_reset_postdata();
   $loop_content = ob_get_clean();
   return $loop_content;
}

// display all events
function eap_display_all_events($atts) {
  ob_start();
  // Shortcode attributes
  extract(shortcode_atts(array(
    'category'       => '',
    'order'          => 'ASC'
  ), $atts));

  $args = array (
     'posts_per_page' => '-1',
     'post_type'      => 'eap_event',
     'order'          => $order,
     'orderby'        => 'meta_value',
     'meta_key'       => 'eap_from_day',
     'category_name'  => $category,
   );

   $custom_query = new WP_Query($args);
   if ($custom_query->have_posts()) : ?>
     <div class="eap__list">
     <?php while($custom_query->have_posts()) :
       // Post content
       $custom_query->the_post();
          // Displays event content
          include ( plugin_dir_path( __FILE__ ) . 'event-content.php' );
     endwhile; ?>
     </div>
     <br>
   <?php else :
     _e('There are no events', 'events-as-posts');
   endif;
   wp_reset_postdata();
   $loop_content = ob_get_clean();
   return $loop_content;
}

/**
 * Registers shortcodes
 */

function eap_register_shortcodes() {
  // shortcodes to display events
  add_shortcode('display_events', 'eap_display_events');
  add_shortcode('display_past_events', 'eap_display_past_events');
  add_shortcode('display_all_events', 'eap_display_all_events');
}
add_action('init', 'eap_register_shortcodes');

/**
 * List styles
 */

function eap_events_style() {
  $setting = get_option('eap_settings_style');

  /* layout */

  // 1 column layout (default)
  if ( $setting['layout'] == 1 || !$setting['layout']) {
    ?>
    <style>
      .eap__list {
        grid-template-columns: 1fr;
      }
      .eap__event {
        display: grid;
        grid-template-columns: 1fr 2fr;
        grid-gap: 1.6em;
      }
      .eap__title {
        margin: 0 0 .8em !important;
      }
    </style>
    <?php

  // 2 columns layout
  } elseif ( $setting['layout'] == 2 ) {
    ?>
    <style>
      .eap__list {
        grid-template-columns: repeat(2, 1fr);
      }
      .eap__title {
        margin: .6em 0 .8em;
      }
    </style>
    <?php

  // 3 columns layout
  } elseif ( $setting['layout'] == 3 ) {
    ?>
    <style>
      .eap__list {
        grid-template-columns: repeat(3, 1fr);
      }
      .eap__title {
        margin: .6em 0 .8em;
      }
    </style>
    <?php
  }

  /* colors */

  ?>
  <style>
    /* background color */
    .eap__event {
      background: <?php echo $setting['bg_color']; ?>;
    }
    /* title color */
    .eap__title a, .eap__title:hover {
      color: <?php echo $setting['title_color']; ?>;
    }
    /* category color */
    .eap__category {
      color: <?php echo $setting['cat_color']; ?>;
    }
    /* meta color */
    .eap__meta {
      color: <?php echo $setting['meta_color']; ?>;
    }
    /* time color */
    .eap__time {
      color: <?php echo $setting['time_color']; ?>;
    }
    /* location color */
    .eap__location, .eap__location:hover {
      color: <?php echo $setting['loc_color']; ?>;
    }
    /* excerpt color */
    .eap__excerpt {
      color: <?php echo $setting['excerpt_color']; ?>;
    }
  </style>
  <?php
}
add_action('wp_head', 'eap_events_style');

// shows events in category pages
function eap_category_filter($query) {
  if ( !is_admin() && $query->is_main_query() ) {
    if ($query->is_category) {
      $query->set('post_type', array( 'post', 'eap_event' ) );
    }
  }
}
add_action('pre_get_posts','eap_category_filter');
