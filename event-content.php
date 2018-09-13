<?php
// get options
$setting = get_option('eap_settings');
// get categories
$category = get_the_category();

// format the content
?>
<div id="post-<?php the_ID(); ?>" <?php post_class();?>>
  <div class="eap__img">
    <?php the_post_thumbnail() ?>
  </div>
  <div class="eap__text">
    <header class="eap__header">
      <h2 class="eap__title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
      <span class="eap__category">
        <?php
        // display categories
        for ($i = 0;$i < sizeof($category);$i++) {
          echo $category[$i]->name;
          // if has more than one category it displays a comma after each category apart the last one
          if (sizeof($category) > 1 && (sizeof($category) != ($i + 1))) {
            echo ', ';
          }
        }
        ?>
      </span>
      <?php include ( plugin_dir_path( __FILE__ ) . 'event-meta.php' ); ?>
    </header>
    <main class="eap__main">
      <p class="eap__excerpt">
        <?php if ( $setting['excerpt'] == 'true' ) {
          the_excerpt();
        } ?>
     </p>
    </main>
  </div>
</div>
