<?php
// register event post type
function eap_create_event_post_type() {

    $supports = array(
        'title',            // post title
        'editor',           // post content
        'author',           // post author
        'thumbnail',        // featured images
        'excerpt',          // post excerpt
        'comments',         // post comments
        'revisions',        // post revisions
    );

    $labels = array(
        'name'              => __( 'Events', 'events-as-posts' ),
        'singular_name'     => __( 'Event', 'events-as-posts' ),
        'menu_name'         => __( 'Events', 'events-as-posts' ),
        'name_admin_bar'    => __( 'Event', 'events-as-posts' ),
        'add_new'           => __( 'Add event', 'events-as-posts' ),

        'add_new_item'      => __( 'Add new event', 'events-as-posts' ),
        'new_item'          => __( 'New event', 'events-as-posts' ),
        'edit_item'         => __( 'Edit event', 'events-as-posts' ),
        'view_item'         => __( 'View event', 'events-as-posts' ),
        'all_items'         => __( 'All events', 'events-as-posts' ),
        'search_items'      => __( 'Search events', 'events-as-posts' ),
        'not_found'         => __( 'No events found.', 'events-as-posts' ),
    );

    $args = array(
        'supports'          => $supports,
        'labels'            => $labels,
        'public'            => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'events' ),
        'has_archive'       => true,
        'hierarchical'      => false,
        'menu_position'     => 5,
        'menu_icon'         => 'dashicons-calendar-alt',
        'taxonomies'        => array( 'category' ),
        'show_in_rest' => true
    );

    register_post_type( 'eap_event', $args );
}
add_action( 'init', 'eap_create_event_post_type' );


// add date metabox
function eap_create_date_metabox() {

    add_meta_box( 'eap_date_metabox', __( 'Date', 'events-as-posts' ), 'eap_date_metabox_callback', 'eap_event', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'eap_create_date_metabox' );


// add location metabox
function eap_create_location_metabox() {

  add_meta_box( 'eap_location_metabox', __( 'Location', 'events-as-posts' ), 'eap_location_metabox_callback', 'eap_event', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'eap_create_location_metabox' );


// add additional info metabox
function eap_create_add_info_metabox() {

    add_meta_box( 'eap_add_info_metabox', __( 'Additional information', 'events-as-posts' ), 'eap_add_info_metabox_callback', 'eap_event', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'eap_create_add_info_metabox' );


// date metabox
function eap_date_metabox_callback( $post ) {

    wp_nonce_field( basename( __FILE__ ), 'eap_nonce' );

    $eap_stored_meta = get_post_meta( $post->ID );
    ?>

    <!-- from date and time -->
    <h4><?php _e( 'From', 'events-as-posts' ) ?></h4>

    <p class="eap-add-event__custom-field">
        <label for="eap__from-day"><span style="vertical-align:middle;" class="dashicons dashicons-calendar-alt"></span> <?php _e( 'Day', 'events-as-posts' )?></label>
        <input type="date" required name="eap_from_day" id="eap__from-day" value="<?php if ( isset ( $eap_stored_meta['eap_from_day'] ) ) echo $eap_stored_meta['eap_from_day'][0]; ?>" />
        <br>
        <label for="eap__from-time"><span style="vertical-align:middle;" class="dashicons dashicons-clock"></span> <?php _e( 'Time', 'events-as-posts' )?></label>
        <input type="time" name="eap_from_time" id="eap__from-time" value="<?php if ( isset ( $eap_stored_meta['eap_from_time'] ) ) echo $eap_stored_meta['eap_from_time'][0]; ?>" />
    </p>

    <!-- until date and time -->
    <h4><?php _e('Until', 'events-as-posts') ?></h4>

    <p class="eap-add-event__custom-field">
        <label for="eap__until-day"><span style="vertical-align:middle;" class="dashicons dashicons-calendar-alt"></span> <?php _e( 'Day', 'events-as-posts' )?></label>
        <input type="date" name="eap_until_day" id="eap__until-day" value="<?php if ( isset ( $eap_stored_meta['eap_until_day'] ) ) echo $eap_stored_meta['eap_until_day'][0]; ?>" />
        <br>
        <label for="eap__until-time"><span style="vertical-align:middle;" class="dashicons dashicons-clock"></span> <?php _e( 'Time', 'events-as-posts' )?></label>
        <input type="time" name="eap_until_time" id="eap__until-time" value="<?php if ( isset ( $eap_stored_meta['eap_until_time'] ) ) echo $eap_stored_meta['eap_until_time'][0]; ?>" />
    </p>
<?php
}


// location metabox
function eap_location_metabox_callback( $post ) {

    wp_nonce_field( basename( __FILE__ ), 'eap_nonce' );

    $eap_stored_meta = get_post_meta( $post->ID );
    ?>

    <!-- event location -->
    <p class="eap-add-event__custom-field">
        <label for="eap__location"><?php _e( 'Event location', 'events-as-posts' )?></label>
        <br>
        <input type="text" required maxlength="60" name="eap_location" id="eap__location" value="<?php if ( isset ( $eap_stored_meta['eap_location'] ) ) echo $eap_stored_meta['eap_location'][0]; ?>" />
    </p>

    <!-- link to location -->
    <p class="eap-add-event__custom-field">
        <label for="eap__link-location"><?php _e( 'Link to location', 'events-as-posts' )?></label>
        <span> | </span>
        <a href="https://www.google.com/maps" target="_blank">Google Maps</a>
        <br>
        <input type="url" name="eap_link_location" id="eap__link-location" value="<?php if ( isset ( $eap_stored_meta['eap_link_location'] ) ) echo $eap_stored_meta['eap_link_location'][0]; ?>" />
    </p>

    <!-- city -->
    <p class="eap-add-event__custom-field">
        <label for="eap__city"><?php _e( 'City', 'events-as-posts' )?></label>
        <br>
        <input type="text" maxlength="40" name="eap_city" id="eap__city" value="<?php if ( isset ( $eap_stored_meta['eap_city'] ) ) echo $eap_stored_meta['eap_city'][0]; ?>" />
    </p>

    <!-- country -->
    <p class="eap-add-event__custom-field">
        <label for="eap__country"><?php _e( 'Country', 'events-as-posts' )?></label>
        <br>
        <input type="text" maxlength="40" name="eap_country" id="eap__country" value="<?php if ( isset ( $eap_stored_meta['eap_country'] ) ) echo $eap_stored_meta['eap_country'][0]; ?>" />
    </p>
    <?php
}


// additional info metabox
function eap_add_info_metabox_callback( $post ) {

    wp_nonce_field( basename( __FILE__ ), 'eap_nonce' );

    $eap_stored_meta = get_post_meta( $post->ID );
    ?>

    <p>
        <input type="text" maxlength="80" name="eap_add_info" id="eap__add-info" value="<?php if ( isset ( $eap_stored_meta['eap_add_info'] ) ) echo $eap_stored_meta['eap_add_info'][0]; ?>" />
    </p>
    <?php
}


// save metaboxes data
function eap_metaboxes_save( $post_id ) {
        // checks save status
        $is_autosave = wp_is_post_autosave( $post_id );
        $is_revision = wp_is_post_revision( $post_id );
        $is_valid_nonce = ( isset( $_POST[ 'eap_nonce' ] ) && wp_verify_nonce( $_POST[ 'eap_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
        // exits script depending on save status
        if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {

            return;
        }

        /* checks for input and sanitizes/saves if needed */

        $setting = get_option( 'eap_settings' );

        // from day
        if ( isset( $_POST[ 'eap_from_day' ] ) ) {

            update_post_meta( $post_id, 'eap_from_day', sanitize_text_field( $_POST[ 'eap_from_day'] ) );

            if ( $_POST[ 'eap_from_day' ] != '' ) {

                update_post_meta( $post_id, 'eap_from_day_custom_format', sanitize_text_field( date_i18n( $setting['date_format'], strtotime( $_POST[ 'eap_from_day'] ) ) ) );

            } else {

                update_post_meta( $post_id, 'eap_from_day_custom_format', '' );
            }
        }

        // from time
        if ( isset( $_POST[ 'eap_from_time' ] ) ) {

            update_post_meta( $post_id, 'eap_from_time', sanitize_text_field( $_POST[ 'eap_from_time'] ) );

            if ( $_POST[ 'eap_from_time' ] != '' ) {

                update_post_meta( $post_id, 'eap_from_time_custom_format', sanitize_text_field( date_i18n( $setting['time_format'], strtotime( $_POST[ 'eap_from_time'] ) ) ) );

            } else {

                update_post_meta( $post_id, 'eap_from_time_custom_format', '' );
            }
        }

        // until day
        if ( isset( $_POST[ 'eap_until_day' ] ) ) {

            update_post_meta( $post_id, 'eap_until_day', sanitize_text_field( $_POST[ 'eap_until_day'] ) );

            if ( $_POST[ 'eap_until_day' ] != '' ) {

                update_post_meta( $post_id, 'eap_until_day_custom_format', sanitize_text_field( date_i18n( $setting['date_format'], strtotime( $_POST[ 'eap_until_day'] ) ) ) );

            } else {

                update_post_meta( $post_id, 'eap_until_day_custom_format', '' );
            }
        }

        // until time
        if ( isset( $_POST[ 'eap_until_time' ] ) ) {

            update_post_meta( $post_id, 'eap_until_time', sanitize_text_field( $_POST[ 'eap_until_time'] ) );

            if ( $_POST[ 'eap_until_time' ] != '' ) {

                update_post_meta( $post_id, 'eap_until_time_custom_format', sanitize_text_field( date_i18n( $setting['time_format'], strtotime( $_POST[ 'eap_until_time'] ) ) ) );

            } else {

                update_post_meta( $post_id, 'eap_until_time_custom_format', '' );
            }
        }

        // location input
        if ( isset( $_POST[ 'eap_location' ] ) ) {
            update_post_meta( $post_id, 'eap_location', sanitize_text_field( $_POST[ 'eap_location' ] ) );
        }
        if ( isset( $_POST[ 'eap_link_location' ] ) ) {
            update_post_meta( $post_id, 'eap_link_location', sanitize_text_field( $_POST[ 'eap_link_location' ] ) );
        }
        if ( isset( $_POST[ 'eap_city' ] ) ) {
            update_post_meta( $post_id, 'eap_city', sanitize_text_field( $_POST[ 'eap_city' ] ) );
        }
        if ( isset( $_POST[ 'eap_country' ] ) ) {
            update_post_meta( $post_id, 'eap_country', sanitize_text_field( $_POST[ 'eap_country' ] ) );
        }

        // additional information input
        if ( isset( $_POST[ 'eap_add_info' ] ) ) {
            update_post_meta( $post_id, 'eap_add_info', sanitize_text_field( $_POST[ 'eap_add_info'] ) );
        }
}
add_action( 'save_post', 'eap_metaboxes_save' );


/* admin edit screen event post type */

// display featured img in columns
function eap_get_featured_image( $post_ID ) {

    $post_thumbnail_id = get_post_thumbnail_id( $post_ID );

    if ($post_thumbnail_id) {

        $post_thumbnail_img = wp_get_attachment_image_src( $post_thumbnail_id, 'featured_preview' );

        return $post_thumbnail_img[0];
    }
}


// set a new columns and unset the author and date column
function eap_event_columns( $columns ) {
    // unset author, publication date and comment columns
    unset( $columns['author'] );
    unset( $columns['date'] );
    unset( $columns['comments'] );
    // add columns
    $columns['event_date'] = __( 'Event date', 'events-as-posts' );
    $columns['featured'] = __( 'Featured image', 'events-as-posts' );

    return $columns;
}
add_filter( 'manage_eap_event_posts_columns' , 'eap_event_columns' );


// display the content of the event date column
function eap_event_columns_content( $column_name, $post_ID ) {

    if ( $column_name == 'event_date' ) {

        $setting = get_option( 'eap_settings' );

        // get event date
        $from_date = get_post_meta( $post_ID, 'eap_from_day', true );
        $until_date = get_post_meta( $post_ID, 'eap_until_day', true );

        echo date_i18n( $setting['date_format'], strtotime( $from_date ) );

        if ( $until_date ) {

            if ( $until_date != $from_date ) {

                echo ' – ' . date_i18n( $setting['date_format'], strtotime( $until_date ) );
            }
        }
    }

    // display the featured imgs
    if ( $column_name == 'featured' ) {

        $post_featured_image = eap_get_featured_image( $post_ID );

        if ($post_featured_image) {

            echo '<img src="' . $post_featured_image . '" width="120px"/>';
        }
    }
}
add_action( 'manage_eap_event_posts_custom_column', 'eap_event_columns_content', 10, 2 );


// orders columns by event date
function eap_event_columns_sort_columns_by( $query ) {

    if ( ! is_admin() ) {

        return;
    }

    $orderby = $query->get( 'orderby');

    if( 'event_date' == $orderby ) {

        $query->set( 'meta_key', 'eap_from_day' );
        $query->set( 'orderby','meta_value' );
    }
}
add_filter( 'pre_get_posts', 'eap_event_columns_sort_columns_by' );


// set which columns are sortable (ASC DESC)
function eap_event_columns_set_sortable_columns( $columns ) {

    unset( $columns['title'] );
    // set the event date as sortable
    $columns['event_date'] = 'event_date';

    return $columns;
}
add_filter( 'manage_edit-eap_event_sortable_columns', 'eap_event_columns_set_sortable_columns' );
