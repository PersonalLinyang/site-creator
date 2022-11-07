<?php
get_header();

$lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
$lang_domain = 'site-creator-' . $lang_code;
?>

<p class="button button-link"><a class="full-link" href="<?php echo get_site_url(); ?>/create-site/"><?php echo _e( 'Try to create site now', $lang_domain ); ?></a></p>

<?php
get_footer();
