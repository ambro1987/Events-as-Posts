<?php
// get options
$setting = get_option('eap_settings');
// get categories
$category = get_the_category();

// format the content
?>
<div id="post-<?php the_ID(); ?>" class="eap__event">
    <div class="eap__img">
      <?php the_post_thumbnail() ?>
    </div>
     <div>
       <header class="eap__header">
         <h2 class="eap__title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
         <span class="eap__category"><?php echo $category[0]->name ?></span>
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
