<?php

require_once get_template_directory() . '/inc/custom-classes/language_supporter.inc.php';

get_header();

$lang = new LanguageSupporter();
?>

<?php if(is_user_logged_in()): ?>
  <?php get_template_part( 'template-parts/error/404' ); ?>
<?php else: ?>
  <section class="form-section">
    <h2><?php echo $lang->translate('Login'); ?></h2>
    <form class="form" id="login-form">
      <div class="form-line">
        <p class="form-title"><?php echo $lang->translate('Loginid'); ?></p>
        <div class="form-input">
          <input class="login-input" id="login-loginid" type="text" name="loginid" placeholder="<?php echo $lang->translate('Username or Email'); ?>" />
          <p class="warning warning-loginid"></p>
        </div>
      </div>
      <div class="form-line">
        <p class="form-title"><?php echo $lang->translate('Password'); ?></p>
        <div class="form-input">
          <div class="password">
            <input class="login-input" id="login-password" type="password" name="password" placeholder="<?php echo $lang->translate('Password'); ?>" />
            <div class="button password-show float-description">
              <p class="password-show-icon"><?php echo file_get_contents(get_template_directory() . '/assets/svg/normal/eye.svg'); ?></p>
              <p class="description"><?php echo $lang->translate('Change Password Display'); ?></p>
            </div>
          </div>
          <p class="warning warning-password"></p>
        </div>
      </div>
      <div class="form-line">
        <div class="form-input">
          <div class="checkbox checkbox-center login-remember">
            <label class="checkbox-check"><input type="checkbox" name="remember" /></label>
            <label class="checkbox-text"><?php echo $lang->translate('Remember Login'); ?></label>
          </div>
          <p class="warning warning-remember"></p>
        </div>
      </div>
      <div class="form-btnarea">
        <p class="button shine-active login-button" id="login-submit"><?php echo $lang->translate('Login Submit'); ?></p>
        <p class="warning center" id="login-warning-system"><?php echo $lang->translate('System Error'); ?></p>
      </div>
      <p class="login-pwdreset"><a href="<?php echo get_site_url(); ?>/password-reset/" class="underline blue"><?php echo $lang->translate('Forgot Password'); ?></a></p>
    </form>
  </section>
<?php endif; ?>

<?php
get_footer();
