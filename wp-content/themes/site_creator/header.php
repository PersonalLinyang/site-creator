<?php

require_once get_template_directory() . '/inc/custom-classes/language_supporter.inc.php';

$lang = new LanguageSupporter();
$lang_code = $lang->code();

?><!doctype html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11" />
    <?php wp_head(); ?>
  </head>

  <body class="language-<?php echo $lang_code; ?>" data-lang="<?php echo $lang_code; ?>">

  <?php 
    require_once get_template_directory() . '/inc/custom-functions/check_editor_permission.inc.php';
    
    if(is_page() && get_field('editor_flag', $post->ID)) {
      $check_result = check_editor_permission();
      if($check_result['result']) {
        get_template_part( 'template-parts/header/editor', null, array('site_id' => $check_result['site_id']));
      } else {
        get_template_part( 'template-parts/header/normal' );
      }
    } else {
      get_template_part( 'template-parts/header/normal' );
    } 
  ?>