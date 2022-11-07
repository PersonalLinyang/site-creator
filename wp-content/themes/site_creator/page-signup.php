<?php
get_header();

global $lang_key_list;
global $lang_name_list;

$lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
$lang_domain = 'site-creator-' . $lang_code;
?>

<?php if(is_user_logged_in()): ?>
  <?php get_template_part( 'template-parts/error/404' ); ?>
<?php else: ?>
  <section class="signup">
    <h2><?php echo __('Sign Up', $lang_domain); ?></h2>
    <p class="attention"><?php echo __('Input with star mark is required', $lang_domain); ?></p>
    <form class="form" id="signup-form">
      <div class="form-line">
        <p class="form-title"><?php echo __('Username', $lang_domain); ?><span class="required">*</span></p>
        <div class="form-input">
          <input type="text" name="user_login" placeholder="<?php echo __('Username for Login', $lang_domain); ?>" />
          <p class="warning warning-user_login"></p>
        </div>
      </div>
      <div class="form-line">
        <p class="form-title"><?php echo __('Full Name', $lang_domain); ?><span class="required">*</span></p>
        <div class="form-input">
          <div class="input-group">
            <div class="form-input col2">
              <?php if(in_array($lang_code, ['ja', 'zh', 'tc'])): ?>
              <input type="text" name="family_name" placeholder="<?php echo __('Family Name', $lang_domain); ?>" />
              <p class="warning warning-family_name"></p>
              <?php else: ?>
              <input type="text" name="first_name" placeholder="<?php echo __('First Name', $lang_domain); ?>" />
              <p class="warning warning-first_name"></p>
              <?php endif; ?>
            </div>
            <div class="form-input col2">
              <?php if(in_array($lang_code, ['ja', 'zh', 'tc'])): ?>
              <input type="text" name="first_name" placeholder="<?php echo __('First Name', $lang_domain); ?>" />
              <p class="warning warning-first_name"></p>
              <?php else: ?>
              <input type="text" name="family_name" placeholder="<?php echo __('Family Name', $lang_domain); ?>" />
              <p class="warning warning-family_name"></p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="form-line">
        <p class="form-title"><?php echo __('Email', $lang_domain); ?><span class="required">*</span></p>
        <div class="form-input">
          <input type="email" name="email" placeholder="<?php echo __('Email for login and recieve', $lang_domain); ?>" />
          <p class="warning warning-email"></p>
        </div>
      </div>
      <div class="form-line">
        <p class="form-title"><?php echo __('Password', $lang_domain); ?><span class="required">*</span></p>
        <div class="form-input">
          <div class="password-group">
            <input type="password" name="password" placeholder="<?php echo __('Password for login', $lang_domain); ?>" />
            <p class="button password-show"></p>
          </div>
          <p class="warning warning-password"></p>
        </div>
      </div>
      <div class="form-line">
        <p class="form-title"><?php echo __('Language', $lang_domain); ?></p>
        <div class="form-input">
          <select name="language">
            <option value="<?php echo $lang_code; ?>"><?php echo $lang_name_list[$lang_code]; ?></option>
            <?php 
            foreach($lang_key_list as $lang_key): 
              if($lang_key != $lang_code):
            ?>
            <option value="<?php echo $lang_key; ?>"><?php echo $lang_name_list[$lang_key]; ?></option>
            <?php 
              endif;
            endforeach; 
            ?>
          </select>
          <p class="warning warning-language"></p>
        </div>
      </div>
      <div class="form-line">
        <div class="form-input center fullline">
          <div class="checkbox checkbox-center signup-agreement">
            <label class="checkbox-check"><input type="checkbox" name="agreement" id="signup-agreement" /></label>
            <label class="checkbox-text">
              <?php 
              echo sprintf(__('I agree with %s', $lang_domain), 
                  '<a href="' . get_site_url() . '/terms/" class="underline blue" target="_blank">' . __('terms of service', $lang_domain) . '</a>'); 
              ?>
            </label>
          </div>
          <p class="warning warning-agreement"></p>
        </div>
      </div>
      <div class="signup-btnarea">
        <p class="button shine-active signup-button" id="signup-submit"><?php echo __('Sign Up Submit', $lang_domain); ?></p>
        <p class="warning center" id="signup-warning-system"><?php echo __('System Error', $lang_domain); ?></p>
      </div>
    </form>
  </section>
<?php endif; ?>

<?php
get_footer();
