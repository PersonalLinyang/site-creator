<?php
get_header();

$lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
$lang_domain = 'site-creator-' . $lang_code;

// $site_uid = $_SESSION['site_uid'];
$site_uid = '8b302ce6e5b46f7c7c47d0a072259729';

?>

<section>
  <img class="image"/>
  <form action="#" class="image-form">
    <input type="file" name="file" class="file">
  </form>
</section>

<?php
get_footer();
