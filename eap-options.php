<?php

/**
 * Outputs the html for the options page
 */

function eap_settings_page_html() {
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    //
    $tab = 'tab1';
	  if (isset($_GET['tab'])) {
      $tab = $_GET['tab'];
    }
    ?>
    <div class="eap__settings-page">
      <h1><?= esc_html(get_admin_page_title()); ?></h1>
      <?php settings_errors();
      ?>
      <h2 class="nav-tab-wrapper">
         <a href="?post_type=eap_event&page=eap_settings&tab=tab1" class="nav-tab <?php echo $tab == 'tab1' ? 'nav-tab-active' : ''; ?>"><?php _e('List', 'events-as-posts'); ?></a>
         <a href="?post_type=eap_event&page=eap_settings&tab=tab2" class="nav-tab <?php echo $tab == 'tab2' ? 'nav-tab-active' : ''; ?>"><?php _e('Styles', 'events-as-posts'); ?></a>
      </h2>

      <?php
      // tab 1
      if ($tab == 'tab1') {
        ?>
        <form action="options.php" method="post">
          <?php
          // output security fields for the registered setting "eap_options"
          settings_fields('eap_settings');
          // output setting sections and their fields
          // (sections are registered for "eap_settings", each field is registered to a specific section)
          do_settings_sections('eap_settings');
          // output save settings button
          submit_button();
          ?>
        </form>
        <?php

      // tab 2
      } elseif ($tab == 'tab2') {
        ?>
        <form action="options.php" method="post"> <?php
          settings_fields('eap_settings_style');
          do_settings_sections('eap_settings_style');
          submit_button();
          ?>
        </form>
        <!-- reset button -->
        <form action="" method="post">
          <input type="submit" name="reset" title="<?php _e('Reset default values', 'events-as-posts'); ?>" value="<?php _e('Reset', 'events-as-posts'); ?>" class="button button-secondary">
        </form>
        <?php
        // deletes all options if the reset button is pressed
        if (isset($_POST['reset'])) {
          delete_option('eap_settings_style');
          ?>
          <script type="text/javascript">
            window.location.href = '?post_type=eap_event&page=eap_settings&tab=tab2';
          </script>
          <?php
        }
      }
      ?>
  </div>
  <?php
}

/**
 * Registers the options submenu
 */

function eap_settings_page() {
    add_submenu_page(
        'edit.php?post_type=eap_event', // slug name for the parent menu
        __('Settings', 'events-as-posts'), // page title
        __('Settings', 'events-as-posts'), // menu title
        'manage_options', // capability
        'eap_settings', // slug name to refer to this menu
        'eap_settings_page_html' // function to be called to output the content for this page
    );
}
add_action('admin_menu', 'eap_settings_page');

/**
 * Register list of events tab
 */

function eap_settings_init() {
  // register a new section
  add_settings_section(
      'eap_events_list', // id
      __('List of events', 'events-as-posts'), // section title
      'eap_events_list_cb', // callback
      'eap_settings' // slug-name of the settings page
  );
  add_settings_section(
      'eap_events_list_settings', // id
      __('List settings', 'events-as-posts'), // section title
      'eap_events_list_settings_cb', // callback
      'eap_settings' // slug-name of the settings page
  );

  // register new fields in the "eap_events_list_settings" section
  add_settings_field(
      'eap_number_of_events', // id
      __('Number of events', 'events-as-posts'), // field title
      'eap_number_of_events_cb', // callback
      'eap_settings', // slug-name of the settings page on which to show the section
      'eap_events_list_settings' // slug-name of the section of the settings page in which to show the box
  );
  add_settings_field(
      'eap_categories',
      __('Categories', 'events-as-posts'),
      'eap_categories_cb',
      'eap_settings',
      'eap_events_list_settings'
  );
  add_settings_field(
      'eap_period',
      __('Period', 'events-as-posts'),
      'eap_period_cb',
      'eap_settings',
      'eap_events_list_settings'
  );
  add_settings_field(
      'eap_shortcode',
      __('Shortcode', 'events-as-posts'),
      'eap_generate_shortcode_cb',
      'eap_settings',
      'eap_events_list_settings'
  );
  add_settings_field(
      'eap_excerpt',
      __('Excerpt', 'events-as-posts'),
      'eap_excerpt_cb',
      'eap_settings',
      'eap_events_list_settings'
  );

  // register a new setting
  register_setting(
    'eap_settings', // group name
    'eap_settings' // option name
  );
}
add_action('admin_init', 'eap_settings_init');


/**
 * Register styles tab
 */

function eap_settings_style_init() {
  // register a new section
  add_settings_section(
      'eap_events_style', // id
      __('List styles', 'events-as-posts'), // section title
      'eap_events_style_cb', // callback
      'eap_settings_style' // slug-name of the settings page
  );

  // // register new fields in the "eap_events_list_settings" section
  add_settings_field(
      'eap_layout', // id
      __('Layout', 'events-as-posts'), // field title
      'eap_layout_cb', // callback
      'eap_settings_style', // slug-name of the settings page on which to show the section
      'eap_events_style' // slug-name of the section of the settings page in which to show the box
  );
  add_settings_field(
      'eap_bg_color', // id
      __('Background color', 'events-as-posts'), // field title
      'eap_bg_color_cb', // callback
      'eap_settings_style', // slug-name of the settings page on which to show the section
      'eap_events_style' // slug-name of the section of the settings page in which to show the box
  );
  add_settings_field(
      'eap_title_color', // id
      __('Title color', 'events-as-posts'), // field title
      'eap_title_color_cb', // callback
      'eap_settings_style', // slug-name of the settings page on which to show the section
      'eap_events_style' // slug-name of the section of the settings page in which to show the box
  );
  add_settings_field(
      'eap_cat_color', // id
      __('Category color', 'events-as-posts'), // field title
      'eap_cat_color_cb', // callback
      'eap_settings_style', // slug-name of the settings page on which to show the section
      'eap_events_style' // slug-name of the section of the settings page in which to show the box
  );
  add_settings_field(
      'eap_meta_color', // id
      __('Meta color *', 'events-as-posts'), // field title
      'eap_meta_color_cb', // callback
      'eap_settings_style', // slug-name of the settings page on which to show the section
      'eap_events_style' // slug-name of the section of the settings page in which to show the box
  );
  add_settings_field(
      'eap_time_color', // id
      __('Time color', 'events-as-posts'), // field title
      'eap_time_color_cb', // callback
      'eap_settings_style', // slug-name of the settings page on which to show the section
      'eap_events_style' // slug-name of the section of the settings page in which to show the box
  );
  add_settings_field(
      'eap_loc_color', // id
      __('Location color', 'events-as-posts'), // field title
      'eap_loc_color_cb', // callback
      'eap_settings_style', // slug-name of the settings page on which to show the section
      'eap_events_style' // slug-name of the section of the settings page in which to show the box
  );
  add_settings_field(
      'eap_excerpt_color', // id
      __('Excerpt color', 'events-as-posts'), // field title
      'eap_excerpt_color_cb', // callback
      'eap_settings_style', // slug-name of the settings page on which to show the section
      'eap_events_style' // slug-name of the section of the settings page in which to show the box
  );

  // register a new setting
  register_setting(
    'eap_settings_style', // group name
    'eap_settings_style' // option name
  );
}
add_action('admin_init', 'eap_settings_style_init');


/**
 * List of events callback functions
 */

 // display the list of events section
function eap_events_list_cb() {
  ?>
  <p><?php _e('<b>Events as Posts</b> allows you to display a list of events
              everywhere on your site using a shortcode. <br> Copy and paste
              in your posts or pages the following shortcode to display
              a list of events: *', 'events-as-posts') ?> </p>
  <span style="color:red;">[display_events]</span>
  <p><i><?php _e('* The above shortcode will only display future events', 'events-as-posts') ?></i></p>
  <br>
  <?php
}
// list settings section
function eap_events_list_settings_cb() {
  // write something here if you want
}

// display input for selecting the number of events in the list
function eap_number_of_events_cb() {
  // get the value of the setting we've registered with register_setting()
  $setting = get_option('eap_settings');
  ?>
  <input type="number" min="0" max="1000" name="eap_settings[number_of_events]" value="<?php echo isset( $setting['number_of_events'] ) ? esc_attr( $setting['number_of_events'] ) : 0; ?>">
  <p><i><?php _e('Select the number of events you want to display or <b>0</b> (zero) to display all', 'events-as-posts') ?></i></p>
  <?php
}

// display input to select categories for the list
function eap_categories_cb() {
  // get the value of the setting
  $setting = get_option('eap_settings');
  ?>
  <input type="text" name="eap_settings[categories]" value="<?php echo isset( $setting['categories'] ) ? esc_attr( $setting['categories'] ) : ''; ?>">
  <p><i><?php _e('Separate the categories with a comma (category 1, category 2, etc.)', 'events-as-posts') ?></i></p>
  <?php
}

// display radio buttons to select future, past or all the events for the list
function eap_period_cb() {
  // get the value of the setting
  $setting = get_option('eap_settings');
  ?>
  <input type="radio" name="eap_settings[period]" value="future" <?php checked('future', $setting['period']); ?> checked>
  <label for="eap_settings[period]"><?php _e('Future events', 'events-as-posts') ?></label><br>
	<input type="radio" name="eap_settings[period]" value="past" <?php checked('past', $setting['period']); ?>>
  <label for="eap_settings[period]"><?php _e('Past events', 'events-as-posts') ?></label><br>
  <input type="radio" name="eap_settings[period]" value="all" <?php checked('all', $setting['period']); ?>>
  <label for="eap_settings[period]"><?php _e('All', 'events-as-posts') ?></label><br>
  <?php
}

// display the shortcode for the event list
function eap_generate_shortcode_cb() {
  // get the value of the setting
  $setting = get_option('eap_settings');
  // shortcode
  $shortcode = '<span style="color:red;">';
  // default
  if ( !$setting ) {
    $shortcode .= '[display_events]';
  }
  // generates shortcode for future events
  if ( $setting['period'] == 'future' ) {
    if ( $setting['number_of_events'] == 0 && !$setting['categories'] ) {
      $shortcode .= '[display_events]';
    } elseif ( $setting['number_of_events'] == 0 && $setting['categories'] ) {
      $shortcode .= '[display_events category="' . $setting['categories'] . '"]';
    } else {
      $shortcode .= '[display_events posts="' . $setting['number_of_events'];

      if ( $setting['categories'] ) {
        $shortcode .= '" category="' . $setting['categories'];
      }
      $shortcode .= '"]';
    }
  // generates shortcode for past events
  } elseif ( $setting['period'] == 'past' ){
    if ( $setting['number_of_events'] == 0 && !$setting['categories'] ) {
      $shortcode .= '[display_past_events]';
    } elseif ( $setting['number_of_events'] == 0 && $setting['categories'] ) {
      $shortcode .= '[display_past_events category="' . $setting['categories'] . '"]';
    } else {
      $shortcode .= '[display_past_events posts="' . $setting['number_of_events'];

      if ( $setting['categories'] ) {
        $shortcode .= '" category="' . $setting['categories'];
      }
      $shortcode .= '"]';
    }
  // generates shortcode for all the events
  } elseif ( $setting['period'] == 'all' ) {
    if ( $setting['categories'] ) {
      $shortcode .= '[display_all_events category="' . $setting['categories'] . '"]';
    } else {
      $shortcode .= '[display_all_events]';
    }
  }
  $shortcode .= '</span>';
  // prints shortcode
  echo $shortcode;
}

// display otption for the excerpt
function eap_excerpt_cb() {
  // get option
  $setting = get_option('eap_settings');
  // to avoid notices
  if (empty($setting['excerpt'])) {
    $setting['excerpt'] = '';
  }
  ?>
  <input type="checkbox" id="eap_excerpt-checkbox" name="eap_settings[excerpt]" value="true" <?php checked('true', $setting['excerpt']); ?>>
  <label for="eap_excerpt-checkbox"><?php _e('Select to show the excerpt *', 'events-as-posts') ?></label>
  <br><br>
  <span><i><?php _e('* Independent of shortcode (it applies to all the lists)', 'events-as-posts') ?></i></span>
  <?php
}


/**
* Style callback functions
*/

// list style section
function eap_events_style_cb() {
  // write something here if you want
}

// display options for list layout
function eap_layout_cb() {
  // get the value of the setting
  $setting = get_option('eap_settings_style');
  ?>
  <p><i><?php _e('Select the layout for the list of events', 'events-as-posts') ?></i></p>
  <br>
  <input type="radio" name="eap_settings_style[layout]" value="1" <?php checked('1', $setting['layout']); ?> checked>
  <label for="eap_settings_style[layout]"><?php _e('1 Column', 'events-as-posts') ?></label><br>
	<input type="radio" name="eap_settings_style[layout]" value="2" <?php checked('2', $setting['layout']); ?>>
  <label for="eap_settings_style[layout]"><?php _e('2 Columns', 'events-as-posts') ?></label><br>
  <input type="radio" name="eap_settings_style[layout]" value="3" <?php checked('3', $setting['layout']); ?>>
  <label for="eap_settings_style[layout]"><?php _e('3 Columns', 'events-as-posts') ?></label><br>
  <?php
}

// display option for the background color
function eap_bg_color_cb() {
  // get the value of the setting
  $setting = get_option('eap_settings_style');
  ?>
  <input type="text" class="eap__color-field" maxlength="7" name="eap_settings_style[bg_color]" value="<?php echo isset( $setting['bg_color'] ) ? esc_attr( $setting['bg_color'] ) : '#f4f4f4'; ?>" data-default-color="#f4f4f4">
  <?php
}

// display option for the title color
function eap_title_color_cb() {
  // get the value of the setting
  $setting = get_option('eap_settings_style');
  ?>
  <input type="text" class="eap__color-field" maxlength="7" name="eap_settings_style[title_color]" value="<?php echo isset( $setting['title_color'] ) ? esc_attr( $setting['title_color'] ) : '#333333'; ?>" data-default-color="#333333">
  <?php
}

// display option for the category color
function eap_cat_color_cb() {
  // get the value of the setting
  $setting = get_option('eap_settings_style');
  ?>
  <input type="text" class="eap__color-field" maxlength="7" name="eap_settings_style[cat_color]" value="<?php echo isset( $setting['cat_color'] ) ? esc_attr( $setting['cat_color'] ) : '#333333'; ?>" data-default-color="#333333">
  <?php
}

// display option for the meta color
function eap_meta_color_cb() {
  // get the value of the setting
  $setting = get_option('eap_settings_style');
  ?>
  <input type="text" class="eap__color-field" maxlength="7" name="eap_settings_style[meta_color]" value="<?php echo isset( $setting['meta_color'] ) ? esc_attr( $setting['meta_color'] ) : '#333333'; ?>" data-default-color="#333333">
  <p><i><?php _e('<b>*</b> Date, time and location', 'events-as-posts') ?></i></p>
  <?php
}

// display option for the time color
function eap_time_color_cb() {
  // get the value of the setting
  $setting = get_option('eap_settings_style');
  ?>
  <input type="text" class="eap__color-field" maxlength="7" name="eap_settings_style[time_color]" value="<?php echo isset( $setting['time_color'] ) ? esc_attr( $setting['time_color'] ) : '#333333'; ?>" data-default-color="#333333">
  <?php
}

// display option for the location color
function eap_loc_color_cb() {
  // get the value of the setting
  $setting = get_option('eap_settings_style');
  ?>
  <input type="text" class="eap__color-field" maxlength="7" name="eap_settings_style[loc_color]" value="<?php echo isset( $setting['loc_color'] ) ? esc_attr( $setting['loc_color'] ) : '#333333'; ?>" data-default-color="#333333">
  <?php
}

// display option for excerpt color
function eap_excerpt_color_cb() {
  // get the value of the setting
  $setting = get_option('eap_settings_style');
  ?>
  <input type="text" class="eap__color-field" maxlength="7" name="eap_settings_style[excerpt_color]" value="<?php echo isset( $setting['excerpt_color'] ) ? esc_attr( $setting['excerpt_color'] ) : '#333333'; ?>" data-default-color="#333333">
  <?php
}
