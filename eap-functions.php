<?php
// enqueue admin scripts
function eap_enqueue_admin_scripts( $hook ) {

    if( is_admin() ) {
        // add the color picker css file
        wp_enqueue_style( 'wp-color-picker' );
        // include custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'eap-scripts', plugins_url( 'js/eap.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
    }
}
add_action( 'admin_enqueue_scripts', 'eap_enqueue_admin_scripts' );

// enqueue styles
function eap_enqueue_styles() {

    $setting = get_option( 'eap_settings_style' );

    wp_register_style( 'eap-styles', plugins_url( 'css/eap.css', __FILE__ ) );
    wp_enqueue_style( 'eap-styles' );

    $bg_color = ( isset( $setting['bg_color'] ) && ! empty ( $setting['bg_color'] ) ) ? $setting['bg_color'] : 'initial';
    $event_bg_color = ( isset( $setting['event_bg_color'] ) && ! empty ( $setting['event_bg_color'] ) ) ? $setting['event_bg_color'] : 'initial';
    
    $css = null;
    
    $css .= ".eap__event { padding: 1em; background: $event_bg_color; }";

    if ( $setting['layout'] == 1 || ! isset( $setting['layout'] ) ) {
        
        $css .= ".eap__list { display: -ms-grid; display: grid; grid-template-columns: 1fr; grid-gap: 1.6em; background: $bg_color; }" .
                ".eap__title { margin: 0 0 .6em !important;}" .
                "@media screen and (min-width: 576px) { .eap__event { display: -ms-grid; display: grid; grid-template-columns: 1fr 2fr; grid-gap: 1.6em; } }";

    } elseif ( $setting['layout'] == 2 ) {
       
        $css .= ".eap__list { display: -ms-grid; display: grid; grid-gap: 1.6em; background: $bg_color; }" .
                ".eap__title { margin: .6em 0 .6em; }" .
                "@media screen and (min-width: 576px) { .eap__list { grid-template-columns: repeat(2, 1fr); } }";

    } elseif ( $setting['layout'] == 3 ) {
            
        $css .= ".eap__list { display: -ms-grid; display: grid; grid-gap: 1.6em; background: $bg_color; }" .
                ".eap__title { margin: .6em 0 .6em; }" .
                "@media screen and (min-width: 576px) { .eap__list { grid-template-columns: repeat(3, 1fr); } }";
    }
    
    if ( isset( $setting['custom_css'] ) && ! empty ( $setting['custom_css'] ) ) {
        $css .= htmlentities( $setting['custom_css'] );
    }

    if ( ! empty ( $css ) ) {
        wp_add_inline_style( 'eap-styles', $css );
    }
}
add_action( 'wp_enqueue_scripts', 'eap_enqueue_styles' );

// load textdomain
function eap_load_textdomain() {

    $plugin_dir = basename(dirname( __FILE__ ) ) . '/languages';

    load_plugin_textdomain( 'events-as-posts', false, $plugin_dir );
}
add_action( 'plugins_loaded', 'eap_load_textdomain' );


// add meta to content
function eap_add_meta_to_event_content( $content ) {

    ob_start();

    if( is_singular( 'eap_event' ) ) {

        include ( plugin_dir_path( __FILE__ ) . 'event-meta.php' );
    }

    $event_meta = ob_get_clean();

    $content = $event_meta . $content;

    return $content;
}
add_filter( 'the_content', 'eap_add_meta_to_event_content' );


// display future events
function eap_display_events( $atts ) {

    $date_format = 'Y\-m\-d';

    ob_start();

    $date = date( $date_format );

    // shortcode attributes
    extract( shortcode_atts( array(
        'posts'          => -1,
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
            'value' => $date,
            'compare' => '>='
        ),
    );

    $custom_query = new WP_Query( $args );

    if ( $custom_query->have_posts() ) : ?>

        <div class="eap__list">
            <?php while( $custom_query->have_posts() ) :

                // post content
                $custom_query->the_post();

                    // Displays event content
                    include ( plugin_dir_path( __FILE__ ) . 'event-content.php' );

            endwhile; ?>
        </div>
        <br>

   <?php else :

       _e( 'There are no events', 'events-as-posts' );

   endif;

   wp_reset_postdata();

   $loop_content = ob_get_clean();

   return $loop_content;
}


// display past events
function eap_display_past_events( $atts ) {

    $date_format = 'Y\-m\-d';

    ob_start();

    $date = date( $date_format );

    // shortcode attributes
    extract( shortcode_atts( array(
        'posts'          => -1,
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
            'value' => $date,
            'compare' => '<'
        ),
    );

    $custom_query = new WP_Query( $args );

    if ( $custom_query->have_posts() ) : ?>

        <div class="eap__list">
            <?php while( $custom_query->have_posts() ) :

                // post content
                $custom_query->the_post();

                    // displays event content
                    include ( plugin_dir_path( __FILE__ ) . 'event-content.php' );

            endwhile; ?>
        </div>
        <br>

   <?php else :

       _e( 'There are no events', 'events-as-posts' );

   endif;

   wp_reset_postdata();

   $loop_content = ob_get_clean();

   return $loop_content;
}


// display all events
function eap_display_all_events( $atts ) {

    ob_start();

    // shortcode attributes
    extract( shortcode_atts( array(
        'category'       => '',
        'order'          => 'ASC'
    ), $atts));

    $args = array (
        'posts_per_page' => -1,
        'post_type'      => 'eap_event',
        'order'          => $order,
        'orderby'        => 'meta_value',
        'meta_key'       => 'eap_from_day',
        'category_name'  => $category,
    );

    $custom_query = new WP_Query( $args );

    if ( $custom_query->have_posts() ) : ?>

        <div class="eap__list">
            <?php while( $custom_query->have_posts() ) :

                // post content
                $custom_query->the_post();

                    // displays event content
                    include ( plugin_dir_path( __FILE__ ) . 'event-content.php' );

            endwhile; ?>
        </div>
        <br>

   <?php else :

       _e( 'There are no events', 'events-as-posts' );

   endif;

   wp_reset_postdata();

   $loop_content = ob_get_clean();

   return $loop_content;
}


// shows events in category pages
function eap_category_filter( $query ) {

    if ( ! is_admin() && $query->is_main_query() ) {

        if ( $query->is_category ) {

            $query->set( 'post_type', array( 'post', 'eap_event' ) );
        }
    }
}
add_action( 'pre_get_posts','eap_category_filter' );


// register shortcodes
function eap_register_shortcodes() {

    add_shortcode( 'display_events', 'eap_display_events' );
    add_shortcode( 'display_past_events', 'eap_display_past_events' );
    add_shortcode( 'display_all_events', 'eap_display_all_events' );
}
add_action( 'init', 'eap_register_shortcodes' );