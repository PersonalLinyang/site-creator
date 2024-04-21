<?php
require_once get_template_directory() . '/inc/custom-classes/language_supporter.inc.php';

$lang = new LanguageSupporter();
?>
<section>
  <div>
    <h2><?php echo $lang->translate( 'Page Not Found' ); ?></h2>
    <p><?php echo $lang->translate( 'Please check your url is correct' ); ?></p>
  </div>
</section>
