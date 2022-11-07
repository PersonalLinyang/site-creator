<?php
$lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
$lang_domain = 'site-creator-' . $lang_code;
?>
<section class="e404">
  <div class="e404-inner">
    <h2><?php esc_html_e( 'Page Not Found', $lang_domain ); ?></h2>
    <p><?php esc_html_e( 'Please check your url is correct', $lang_domain ); ?></p>
  </div>
</section>
