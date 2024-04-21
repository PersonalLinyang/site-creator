<?php

require_once get_template_directory() . '/inc/custom-classes/language_supporter.inc.php';

$lang = new LanguageSupporter();

get_header();

?>

<p class="button"><a class="full-link" href="<?php echo get_site_url(); ?>/create-site/"><?php echo $lang->translate('Try to create site now'); ?></a></p>

<?php
get_footer();
