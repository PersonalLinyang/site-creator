<?php

require_once get_template_directory() . '/inc/custom-classes/language_supporter.inc.php';

get_header();

$lang = new LanguageSupporter();
?>

<?php if(is_user_logged_in()): ?>
  <?php get_template_part( 'template-parts/error/404' ); ?>
<?php else: ?>
  <section class="form-section" id="pwdreset-reset">
    <h2><?php echo $lang->translate('Password Reset'); ?></h2>
    <form class="form" id="pwdreset-form">
      <div class="form-line">
        <p class="form-title"><?php echo $lang->translate('Loginid'); ?></p>
        <div class="form-input">
          <input id="pwdreset-loginid" type="text" name="loginid" placeholder="<?php echo $lang->translate('Username or Email'); ?>" />
          <p class="warning warning-loginid"></p>
        </div>
      </div>
      <div class="form-btnarea">
        <p class="button shine-active pwdreset-button" id="pwdreset-submit"><?php echo $lang->translate('Password Reset Submit'); ?></p>
        <p class="warning center warning-system"></p>
        <p class="warning center" id="pwdreset-warning-system"><?php echo $lang->translate('System Error'); ?></p>
      </div>
    </form>
  </section>
  
  <section class="form-section hidden" id="pwdreset-complete">
    <h2><?php echo $lang->translate('Password Reset Complete'); ?></h2>
    <p class="center"><?php echo $lang->translate('Password Reset Complete Text'); ?></p>
    <div class="form-btnarea">
      <p class="button pwdreset-button shine-active pwdreset-button-complete" id="pwdreset-button-complete">
        <a class="full-link" href="<?php echo get_site_url(); ?>/login/"><?php echo $lang->translate('Login'); ?></a>
      </p>
    </div>
  </section>
<?php endif; ?>

<?php
get_footer();
