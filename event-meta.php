<?php
// retrieves the stored values from the database
$from_date = get_post_meta( get_the_ID(), 'eap_from_day', true );
$from_time = get_post_meta( get_the_ID(), 'eap_from_time', true );
$until_date = get_post_meta( get_the_ID(), 'eap_until_day', true );
$until_time = get_post_meta( get_the_ID(), 'eap_until_time', true );
$location = get_post_meta( get_the_ID(), 'eap_location', true );
$link_location = get_post_meta( get_the_ID(), 'eap_link_location', true );
$city = get_post_meta( get_the_ID(), 'eap_city', true );
$country = get_post_meta( get_the_ID(), 'eap_country', true );
$add_info = get_post_meta( get_the_ID(), 'eap_add_info', true );
$setting = get_option( 'eap_settings' );

// date and time icons
$date_icon = '<span class="dashicons dashicons-calendar-alt"></span>';
$time_icon = '<span class="dashicons dashicons-clock"></span>';

// separation mark '–' between from day/time and until day/time
$sepmark_date = ' – ';
// separation mark between date and time
$sepmark_time = ' | ';
$comma = ', ';
?>

<!-- event meta -->
<p class="eap__meta">
    <?php
    // from date
    if ( $from_date ) {
        ?>
        <span class="eap__date no-wrap">
            <?php
            if ( isset( $setting['date_icon'] ) ) {

                echo $date_icon . ' ';
            }

            echo date_i18n( $setting['date_format'], strtotime( $from_date ) );
            ?>
        </span>
        <?php
    }

    // from time
    if ( $from_time ) {

        echo $sepmark_time;
        ?>
        <span class="eap__time no-wrap">
            <?php
            if ( isset( $setting['time_icon'] ) ) {

                echo $time_icon . ' ';
            }

            echo date( $setting['time_format'], strtotime( $from_date . $from_time ) );
            ?>
        </span>
        <?php
    }

    // until date
    if ( $until_date && ( $until_date != $from_date ) ) {

        echo $sepmark_date;
        ?>
        <span class="eap__date no-wrap">
            <?php
            if ( isset( $setting['date_icon'] ) ) {

                echo $date_icon . ' ';
            }

            echo date_i18n( $setting['date_format'], strtotime( $until_date ) );
            ?>
        </span>
        <?php
    }

    // until time
    if ( $until_time ) {

        if ( $until_date ) {

            if ( $until_date != $from_date ) {

                echo $sepmark_time;

            } else {

                echo $sepmark_date;
            }
            ?>
            <span class="eap__time no-wrap">
                <?php
                // time icon
                if ( isset( $setting['time_icon'] ) && ( $from_date != $until_date ) ) {

                    echo $time_icon . ' ';
                }

                echo date( $setting['time_format'], strtotime( $until_date . $until_time ) );
                ?>
            </span>
            <?php

        // until date not set
        } else {

            if ( $from_time && ( $from_time != $until_time ) ) {

                echo $sepmark_date;
                ?>
                <span class="eap__time no-wrap">
                    <?php
                    echo date( $setting['time_format'], strtotime( $until_date . $until_time ) );
                    ?>
                </span>
                <?php
            }
        }
    }
    ?>

    <br>

    <?php
    // location
    if ( $link_location ) {
        ?>
        <a href="<?php echo $link_location ?>" target="_blank" class="eap__location"><?php echo $location ?></a>
        <?php

        if ( $city ) {
            echo $comma . $city;
        }

        if ( $country ) {
            echo $comma . $country;
        }

    } else {
        
        echo $location; 
       
        if ( $city ) {
            echo $comma . $city;
        }

        if ( $country ) {
            echo $comma . $country;
        }
    }
    ?>
</p>

<?php
// additional information
if ( $add_info ) {
    ?>
    <!-- additional information -->
    <p class="eap__add-info"><?php echo $add_info; ?></p>
    <?php
}
