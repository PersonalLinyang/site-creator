<?php
get_header();

$lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
$lang_domain = 'site-creator-' . $lang_code;
?>

<?php if(is_user_logged_in()): ?>
  <?php get_template_part( 'template-parts/error/404' ); ?>
<?php else: ?>
  <section class="pwdreset" id="pwdreset-reset">
    <h2><?php echo __('Password Reset', $lang_domain); ?></h2>
    <form class="form" id="pwdreset-form">
      <div class="form-line">
        <p class="form-title"><?php echo __('Loginid', $lang_domain); ?></p>
        <div class="form-input">
          <input id="pwdreset-loginid" type="text" name="loginid" placeholder="<?php echo __('Username or Email', $lang_domain); ?>" />
          <p class="warning warning-loginid"></p>
        </div>
      </div>
      <div class="pwdreset-btnarea">
        <p class="button shine-active pwdreset-button" id="pwdreset-submit"><?php echo __('Password Reset Submit', $lang_domain); ?></p>
        <p class="warning center warning-system"></p>
        <p class="warning center" id="pwdreset-warning-system"><?php echo __('System Error', $lang_domain); ?></p>
      </div>
    </form>
  </section>
  <section class="pwdreset hidden" id="pwdreset-complete">
    <h2><?php echo __('Password Reset Complete', $lang_domain); ?></h2>
    <p class="center"><?php echo __('Password Reset Complete Text', $lang_domain); ?></p>
    <div class="pwdreset-btnarea">
      <p class="button button-link shine-active pwdreset-button pwdreset-button-complete" id="pwdreset-button-complete">
        <a class="full-link" href="<?php echo get_site_url(); ?>/login/"><?php echo __('Login', $lang_domain); ?></a>
      </p>
    </div>
  </section>
<?php endif; ?>

<?php
get_footer();
