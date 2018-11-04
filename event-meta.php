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

// separation mark '–' between from day/time and until day/time
$sepmark_date = '<span class="eap__sepmark-date"> – </span>';
// separation mark between date and time
$sepmark_time = '<span class="eap__sepmark-time"> | </span>';
$comma = '<span class="eap__comma">, </span>'
?>

<!-- display event meta -->
<p class="eap__meta">
    <span class="eap__date"><?php echo date_i18n( $setting['date_format'], strtotime( $from_date ) ); ?></span>
    <span class="eap__time"><?php if ( $from_time ) echo $sepmark_time . date( $setting['time_format'], strtotime( $from_date . $from_time ) ); ?>
    <span class="eap__date"><?php if ( $until_date && ( $until_date != $from_date ) ) echo $sepmark_date . date_i18n( $setting['date_format'], strtotime( $until_date ) ); ?></span>
    <span class="eap__time">
        <?php
        if ( ! empty( $until_time ) ) {

            if ( $until_date ) {

                if ( $until_date != $from_date ) {

                    echo $sepmark_time;

                } else {

                    echo $sepmark_date;
                }

                echo date( $setting['time_format'], strtotime( $until_date . $until_time ) );

            // until date not set
            } else {

                if ( $from_time && ( $from_time != $until_time ) ) {

                    echo $sepmark_date;
                    echo date( $setting['time_format'], strtotime( $until_date . $until_time ) );
                }
            }
        }
        ?>
    </span>
    <br>

    <!-- location -->
    <?php if ( $link_location ) : ?>

        <a href="<?php echo $link_location ?>" target="_blank" class="eap__location"><?php echo $location ?></a>

    <?php else : ?>

        <span class="eap__location"><?php echo $location ?></span>

    <?php endif; ?>

    <!-- city and country -->
    <span class="eap__city"><?php if ( ! empty ( $city ) ) echo $comma . $city ?></span>
    <span class="eap__country"><?php if ( ! empty ( $country ) ) echo $comma . $country ?></span>
</p>

<!-- additional info -->
<p class="eap__add-info">
    <?php if ( ! empty ( $add_info ) ) echo $add_info; ?>
</p>
