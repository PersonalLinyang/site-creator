<?php
get_header();

$lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
$lang_domain = 'site-creator-' . $lang_code;
?>

<?php if(is_user_logged_in()): ?>
  <?php get_template_part( 'template-parts/error/404' ); ?>
<?php else: ?>
  <section class="login">
    <h2><?php echo __('Login', $lang_domain); ?></h2>
    <form class="form" id="login-form">
      <div class="form-line">
        <p class="form-title"><?php echo __('Loginid', $lang_domain); ?></p>
        <div class="form-input">
          <input class="login-input" id="login-loginid" type="text" name="loginid" placeholder="<?php echo __('Username or Email', $lang_domain); ?>" />
          <p class="warning warning-loginid"></p>
        </div>
      </div>
      <div class="form-line">
        <p class="form-title"><?php echo __('Password', $lang_domain); ?></p>
        <div class="form-input">
          <div class="password-group">
            <input class="login-input" id="login-password" type="password" name="password" placeholder="<?php echo __('Password', $lang_domain); ?>" />
            <p class="button password-show"></p>
          </div>
          <p class="warning warning-password"></p>
        </div>
      </div>
      <div class="form-line">
        <div class="form-input center fullline">
          <div class="checkbox checkbox-center login-remember">
            <label class="checkbox-check"><input type="checkbox" name="remember" /></label>
            <label class="checkbox-text"><?php echo __('Remember Login', $lang_domain); ?></label>
          </div>
          <p class="warning warning-remember"></p>
        </div>
      </div>
      <div class="login-btnarea">
        <p class="button shine-active login-button" id="login-submit"><?php echo __('Login Submit', $lang_domain); ?></p>
        <p class="warning center" id="login-warning-system"><?php echo __('System Error', $lang_domain); ?></p>
      </div>
      <p class="login-pwdreset"><a href="<?php echo get_site_url(); ?>/password-reset/" class="underline blue"><?php echo __('Forgot Password', $lang_domain); ?></a></p>
    </form>
  </section>
<?php endif; ?>

<?php
get_footer();
