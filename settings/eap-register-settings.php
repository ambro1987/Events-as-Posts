<?php
// general settings
function eap_settings_init() {

    add_settings_section(
        'eap_date_settings',
        __( '<span class="dashicons dashicons-calendar-alt"></span> Date settings', 'events-as-posts' ),
        'eap_date_settings_cb',
        'eap_settings'
    );
    add_settings_section(
        'eap_list_settings',
        __( '<span class="dashicons dashicons-editor-ul"></span> List settings', 'events-as-posts' ),
        'eap_list_settings_cb',
        'eap_settings'
    );

    add_settings_field(
        'eap_date_format',
        __( 'Date format', 'events-as-posts' ),
        'eap_date_format_cb',
        'eap_settings',
        'eap_date_settings'
    );
    add_settings_field(
        'eap_time_format',
        __( 'Time format', 'events-as-posts' ),
        'eap_time_format_cb',
        'eap_settings',
        'eap_date_settings'
    );
    add_settings_field(
        'eap_number_of_events',
        __( 'Number of events', 'events-as-posts' ),
        'eap_number_of_events_cb',
        'eap_settings',
        'eap_list_settings'
    );
    add_settings_field(
        'eap_categories',
        __( 'Events by categories', 'events-as-posts' ),
        'eap_categories_cb',
        'eap_settings',
        'eap_list_settings'
    );
    add_settings_field(
        'eap_period',
        __( 'Period', 'events-as-posts' ),
        'eap_period_cb',
        'eap_settings',
        'eap_list_settings'
    );
    add_settings_field(
        'eap_shortcode',
        __( 'Shortcode', 'events-as-posts' ),
        'eap_generate_shortcode_cb',
        'eap_settings',
        'eap_list_settings'
    );
    add_settings_field(
        'eap_excerpt',
        __( 'Display excerpt', 'events-as-posts' ),
        'eap_excerpt_cb',
        'eap_settings',
        'eap_list_settings'
    );
    add_settings_field(
        'eap_more',
        __( 'Display read more link', 'events-as-posts' ),
        'eap_more_cb',
        'eap_settings',
        'eap_list_settings'
    );
    add_settings_field(
        'eap_cat',
        __( 'Display categories', 'events-as-posts' ),
        'eap_cat_cb',
        'eap_settings',
        'eap_list_settings'
    );

    $args = array(
        'sanitize_callback' => 'eap_setting_errors',
    );
    register_setting( 'eap_settings', 'eap_settings', $args );
}
add_action( 'admin_init', 'eap_settings_init' );


// style settings
function eap_settings_style_init() {

    add_settings_section(
        'eap_list_style',
        __( '<span class="dashicons dashicons-editor-ul"></span> List style', 'events-as-posts' ),
        'eap_list_style_cb',
        'eap_settings_style'
    );

    add_settings_field(
        'eap_layout',
        __( 'Layout', 'events-as-posts' ),
        'eap_layout_cb',
        'eap_settings_style',
        'eap_list_style'
    );
    add_settings_field(
        'eap_bg_color',
        __( 'Background color', 'events-as-posts' ),
        'eap_bg_color_cb',
        'eap_settings_style',
        'eap_list_style'
    );

    register_setting(
        'eap_settings_style',
        'eap_settings_style'
    );
}
add_action( 'admin_init', 'eap_settings_style_init' );
