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

// to avoid notices
if ( ! $from_time ) {
  $from_time = '';
} else {
  // add a comma in before if it's set
  $from_time = ' | ' . $from_time;
}

if (!$until_time) {
  $until_time = '';
}

// separation mark '-' between from day/time and until day/time
$separation_mark = ' – ';
// comma after year
$bar = ' | '; // dt = datetime

// logic for commas and separation mark...

// if until date AND until time are not set
if ( !$until_date && ($until_time == '') ) {
  $separation_mark = '';
  $bar = '';
  // if until date is set AND until time is not
} elseif ( $until_date && ($until_time == '') ) {
  // if dates are NOT the same day
  if ($until_date != $from_date) {
    $bar = '';
    // if dates ARE the same day
  } elseif ($until_date == $from_date) {

      $until_date = '';

    $separation_mark = '';
    $bar = '';
  }
  // until date AND until time are both set
} elseif ( $until_date && ($until_time != '') ) {
  // if same day
  if ($until_date == $from_date) {

      $until_date = '';
    
    $bar = '';
  }
  // until date is NOT set AND until time is set
} elseif ( !$until_date && ($until_time != '') ) {
  if ($until_time == $from_time) {
    $separation_mark = '';
    $until_time = '';
  }
  $bar = '';
}
?>

<!-- event meta -->
<p class="eap__meta">
  <span class="eap__date"><?php echo date_i18n( $setting['date_format'], strtotime( $from_date ) ); ?></span><span class="eap__time"><?php echo $from_time ?></span><?php echo $separation_mark ?>
  <span class="eap__date">
    <?php
    if ($until_date) {
      echo date_i18n( $setting['date_format'], strtotime( $until_date ) ) . $bar;
    }
    ?>
  </span>
  <span class="eap__time"><?php echo $until_time ?></span>
  <br>
  <?php if ($link_location) : ?>
    <a href="<?php echo $link_location ?>" target="_blank" class="eap__location"><?php echo $location ?></a>
  <?php else : ?>
    <span class="eap__location"><?php echo $location ?></span>
  <?php endif; ?>
  <!-- <?php echo $bar_loc ?> -->
  <?php
  if ($city) {
    ?>
    <span>, </span><span class="eap__city"><?php echo $city ?></span>
    <?php
  }
  if ($country) {
    ?>
    <span>, </span><span class="eap__country"><?php echo $country ?></span>
    <?php
  }
  ?>
</p>

<!-- additional information -->
<p class="eap__add-info">
  <?php echo $add_info; ?>
</p>
