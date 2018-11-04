<?php
// events settings section
function eap_date_settings_cb() {
    ?>
    <hr />
    <?php
}

// list settings section
function eap_list_settings_cb() {
    ?>
    <hr />

    <p class="eap-option__about">
        <?php _e( '<b>Events as Posts</b> allows you to display a list of events everywhere on your site using a shortcode. Copy and paste in your posts or pages the following shortcode to display a list of events: *', 'events-as-posts' ) ?>
    </p>
    <span class="eap-option__shortcode">[display_events]</span>
    <p>
        <i><?php _e('* The above shortcode will only display future events', 'events-as-posts') ?></i>
    </p>
    <br />
    <?php
}


/* date settings */

// date format option
function eap_date_format_cb() {

    $setting = get_option( 'eap_settings' );
    ?>

    <p class="eap-option__date-format">
        <input type="text" name="eap_settings[date_format]" value="<?php echo $setting['date_format']; ?>" required /> <!-- pattern="[-dDjFmMnYylS,./\s]+" -->
        <p>
            <i><?php _e( 'Valid characters: ', 'events-as-posts' ); ?> d, D, j, l, S, F, m, M, n, Y, y</i>
        </p>
        <p>
            <i><?php _e( 'Reference: ', 'events-as-posts' )?><a href="https://secure.php.net/manual/function.date.php" target="_blank"><?php _e( 'PHP: date - Manual', 'events-as-posts' ); ?></a></i>
        </p>
    </p>
    <?php
}


// time format option
function eap_time_format_cb() {

    $setting = get_option( 'eap_settings' );
    ?>

    <p class="eap-option__date-format">
        <input type="text" name="eap_settings[time_format]" value="<?php echo $setting['time_format']; ?>" required /> <!-- pattern="[aAgGhHi:\s]+"  -->
        <p>
            <i><?php _e( 'Valid characters: ', 'events-as-posts' ); ?> a, A, g, G, h, H, i</i>
        </p>
        <p>
            <i><?php _e( 'Reference: ', 'events-as-posts' )?><a href="https://secure.php.net/manual/function.date.php" target="_blank"><?php _e( 'PHP: date - Manual', 'events-as-posts' ); ?></a></i>
        </p>
    </p>
    <?php
}


/* list settings */

// number of events option
function eap_number_of_events_cb() {

    $setting = get_option( 'eap_settings' );
    ?>

    <input type="number" min="0" max="1000" name="eap_settings[number_of_events]" value="<?php echo isset( $setting['number_of_events'] ) ? esc_attr( $setting['number_of_events'] ) : 0; ?>" />
    <p>
        <i><?php _e( 'Select the number of events you want to display or <b>0</b> (zero) to display all', 'events-as-posts' ) ?></i>
    </p>
    <?php
}


// categories option
function eap_categories_cb() {

    $setting = get_option( 'eap_settings' );
    ?>

    <input type="text" name="eap_settings[categories]" value="<?php echo isset( $setting['categories'] ) ? esc_attr( $setting['categories'] ) : ''; ?>" />
    <p>
        <i><?php _e( 'Separate the categories with a comma (category 1, category 2, etc.)', 'events-as-posts' ) ?></i>
    </p>
    <?php
}


// period option
function eap_period_cb() {

    $setting = get_option( 'eap_settings' );
    ?>

    <!-- future -->
    <label for="eap-period__future">
        <input id="eap-period__future" type="radio" name="eap_settings[period]" value="future" <?php if ( isset ( $setting['period'] ) ) checked( 'future', $setting['period'] ); ?> checked />
        <span><?php _e( 'Future events', 'events-as-posts' ) ?></span>
    </label>
    <br>

    <!-- past -->
    <label for="eap-period__past">
        <input id="eap-period__past" type="radio" name="eap_settings[period]" value="past" <?php if ( isset ( $setting['period'] ) ) checked( 'past', $setting['period'] ); ?> />
        <span><?php _e( 'Past events', 'events-as-posts' ) ?></span>
    </label>
    <br>

    <!-- all -->
    <label for="eap-period__all">
        <input id="eap-period__all" type="radio" name="eap_settings[period]" value="all" <?php if ( isset ( $setting['period'] ) ) checked( 'all', $setting['period'] ); ?> />
        <span><?php _e('All', 'events-as-posts') ?></span>
    </label>
    <br>
    <?php
}


// display shortcode
function eap_generate_shortcode_cb() {

    $setting = get_option( 'eap_settings' );

    $shortcode = '<span class="eap-option__shortcode">';

    // shortcode for future events
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

    // shortcode for past events
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

    // shortcode for all the events
    } elseif ( $setting['period'] == 'all' ) {

        if ( $setting['categories'] ) {

            $shortcode .= '[display_all_events category="' . $setting['categories'] . '"]';

        } else {

            $shortcode .= '[display_all_events]';
        }
    }

    $shortcode .= '</span>';

    echo $shortcode;
}


// display excerpt otption
function eap_excerpt_cb() {

    $setting = get_option( 'eap_settings' );
    ?>

    <input type="checkbox" id="eap_excerpt-checkbox" name="eap_settings[excerpt]" value="true" <?php if ( isset ( $setting['excerpt'] ) ) checked( 'true', $setting['excerpt'] ); ?> />
    <?php
}


// display read more link otption
function eap_more_cb() {

    $setting = get_option( 'eap_settings' );
    ?>

    <input type="checkbox" id="eap_more-checkbox" name="eap_settings[more]" value="true" <?php if ( isset ( $setting['more'] ) ) checked( 'true', $setting['more'] ); ?> />
    <?php
}

// display category otption
function eap_cat_cb() {

    $setting = get_option( 'eap_settings' );
    ?>

    <input type="checkbox" id="eap_more-checkbox" name="eap_settings[cat]" value="true" <?php if ( isset ( $setting['cat'] ) ) checked( 'true', $setting['cat'] ); ?> />
    <?php
}


// list style section
function eap_list_style_cb() {
  // write something here if you want
}

// layout option
function eap_layout_cb() {

    $setting = get_option( 'eap_settings_style' );
    ?>
    <p>
        <i><?php _e( 'Select the layout for the list of events', 'events-as-posts' ) ?></i>
    </p>
    <br>

    <!-- 1 column -->
    <label for="eap-layout__1-col">
        <input id="eap-layout__1-col" type="radio" name="eap_settings_style[layout]" value="1" <?php checked( '1', $setting['layout'] ); ?> checked />
        <span><?php _e('1 Column', 'events-as-posts') ?></span>
    </label>
    <br>

    <!-- 2 columns -->
    <label for="eap-layout__2-col">
        <input id="eap-layout__2-col" type="radio" name="eap_settings_style[layout]" value="2" <?php checked( '2', $setting['layout'] ); ?> />
        <span><?php _e('2 Columns', 'events-as-posts') ?></span>
    </label>
    <br>

    <!-- 3 columns -->
    <label for="eap-layout__3-col">
        <input id="eap-layout__3-col" type="radio" name="eap_settings_style[layout]" value="3" <?php checked( '3', $setting['layout'] ); ?> />
        <span><?php _e('3 Columns', 'events-as-posts') ?></span>
    </label>
    <br>
    <?php
}


// background color option
function eap_bg_color_cb() {

    $setting = get_option( 'eap_settings_style' );
    ?>

    <input type="text" class="eap__color-field" maxlength="7" name="eap_settings_style[bg_color]" value="<?php echo isset( $setting['bg_color'] ) ? esc_attr( $setting['bg_color'] ) : '#f4f4f4'; ?>" data-default-color="#f4f4f4" />
    <?php
}
