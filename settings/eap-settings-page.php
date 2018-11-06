<?php
// settings page
function eap_settings_page_html() {

    if ( ! current_user_can( 'manage_options' ) ) {

        return;
    }

    // default tab
    $tab = 'tab1';

    if ( isset( $_GET['tab'] ) ) {

        $tab = $_GET['tab'];
    }
    ?>

    <div class="eap__settings-page">
        <h1><?= esc_html( get_admin_page_title() ); ?></h1>
        <?php settings_errors();
        ?>

        <h2 class="nav-tab-wrapper">
            <a href="?post_type=eap_event&page=eap_settings&tab=tab1" class="nav-tab <?php echo $tab == 'tab1' ? 'nav-tab-active' : ''; ?>"><?php _e( 'General', 'events-as-posts' ); ?></a>
            <a href="?post_type=eap_event&page=eap_settings&tab=tab2" class="nav-tab <?php echo $tab == 'tab2' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Style', 'events-as-posts' ); ?></a>
        </h2>

        <?php

        // tab 1
        if ( $tab == 'tab1' ) {
            ?>
            <form action="options.php" method="post">
                <?php
                settings_fields( 'eap_settings' );
                do_settings_sections( 'eap_settings' );
                submit_button();
                ?>
            </form>
            <?php

        // tab 2
        } elseif ($tab == 'tab2') {
            ?>
            <form action="options.php" method="post">
                <?php
                settings_fields( 'eap_settings_style' );
                do_settings_sections( 'eap_settings_style' );
                submit_button();
                ?>
            </form>
            <?php
        }
        ?>
    </div>
    <?php
}


// settings errors
function eap_settings_errors( $setting ) {

    $prev_valid_setting = get_option( 'eap_settings' );

    $type = 'updated';
    $message = __( 'Settings saved.', 'events-as-posts' );

    // settings validation
    if ( preg_match( '/[^-dDjFmMnYylS,.\/\s]+/' , $setting['date_format'] ) ) {

        $type = 'error';
        $message = __( 'Date format not valid: ', 'events-as-posts' );
        $message .= '"' . $setting['date_format'] . '"';

        // set the previous valid setting
        $setting['date_format'] = $prev_valid_setting['date_format'];

    } elseif ( preg_match( '/[^aAgGhHi:\s]+/' , $setting['time_format'] ) ) {

        $type = 'error';
        $message = __( 'Time format not valid: ', 'events-as-posts' );
        $message .= '"' . $setting['time_format'] . '"';

        // set the previous valid setting
        $setting['time_format'] = $prev_valid_setting['time_format'];

    } elseif ( ! empty( $setting['categories'] ) ) {

        $setting['categories'] = wp_strip_all_tags( $setting['categories'] );

    } elseif ( ! empty( $setting['custom_css'] ) ) {

        $setting['custom_css'] = wp_strip_all_tags( $setting['custom_css'] );

    }

    // add settings errors
    add_settings_error(
        'eap_settings_errors',
        esc_attr( 'settings-updated' ),
        $message,
        $type
    );

    return $setting;
}


// add settings page
function eap_settings_page() {

    add_submenu_page(
        'edit.php?post_type=eap_event',
        __( 'Settings', 'events-as-posts' ),
        __( 'Settings', 'events-as-posts' ),
        'manage_options',
        'eap_settings',
        'eap_settings_page_html'
    );
}
add_action( 'admin_menu', 'eap_settings_page' );
