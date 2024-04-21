<?php
get_header();

require_once get_template_directory() . '/inc/custom-classes/language_supporter.inc.php';

$lang = new LanguageSupporter();
$lang_code = $lang->code();
$lang_name_list = get_option('qtranslate_language_names');
$lang_key_list = function_exists('qtranxf_getSortedLanguages') ? qtranxf_getSortedLanguages() : array('en');

?>

<?php if(is_user_logged_in()): ?>
  <?php get_template_part( 'template-parts/error/404' ); ?>
<?php else: ?>
  <section class="form-section signup">
    <h2><?php echo $lang->translate('Sign Up'); ?></h2>
    <p class="attention"><?php echo $lang->translate('Input with star mark is required'); ?></p>
    <form class="form" id="signup-form">
      <div class="form-line">
        <p class="form-title"><?php echo $lang->translate('Username'); ?><span class="required">*</span></p>
        <div class="form-input">
          <input type="text" name="user_login" placeholder="<?php echo $lang->translate('Username for Login'); ?>" />
          <p class="warning warning-user_login"></p>
        </div>
      </div>
      <div class="form-line">
        <p class="form-title"><?php echo $lang->translate('Full Name'); ?><span class="required">*</span></p>
        <div class="form-input form-input-group">
          <div class="form-input-item">
            <?php if(in_array($lang_code, ['ja', 'zh', 'tc'])): ?>
            <input type="text" name="family_name" placeholder="<?php echo $lang->translate('Family Name'); ?>" />
            <p class="warning warning-family_name"></p>
            <?php else: ?>
            <input type="text" name="first_name" placeholder="<?php echo $lang->translate('First Name'); ?>" />
            <p class="warning warning-first_name"></p>
            <?php endif; ?>
          </div>
          <div class="form-input-item">
            <?php if(in_array($lang_code, ['ja', 'zh', 'tc'])): ?>
            <input type="text" name="first_name" placeholder="<?php echo $lang->translate('First Name'); ?>" />
            <p class="warning warning-first_name"></p>
            <?php else: ?>
            <input type="text" name="family_name" placeholder="<?php echo $lang->translate('Family Name'); ?>" />
            <p class="warning warning-family_name"></p>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="form-line">
        <p class="form-title"><?php echo $lang->translate('Email'); ?><span class="required">*</span></p>
        <div class="form-input">
          <input type="email" name="email" placeholder="<?php echo $lang->translate('Email for login and recieve'); ?>" />
          <p class="warning warning-email"></p>
        </div>
      </div>
      <div class="form-line">
        <p class="form-title"><?php echo $lang->translate('Password'); ?><span class="required">*</span></p>
        <div class="form-input">
          <div class="password">
            <input type="password" name="password" placeholder="<?php echo $lang->translate('Password for login'); ?>" />
            <div class="button password-show float-description">
              <p class="password-show-icon"><?php echo file_get_contents(get_template_directory() . '/assets/svg/normal/eye.svg'); ?></p>
              <p class="description"><?php echo $lang->translate('Change Password Display'); ?></p>
            </div>
          </div>
          <p class="warning warning-password"></p>
        </div>
      </div>
      <div class="form-line">
        <p class="form-title"><?php echo $lang->translate('Language'); ?></p>
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
        <div class="form-input center">
          <div class="checkbox checkbox-center signup-agreement">
            <label class="checkbox-check"><input type="checkbox" name="agreement" id="signup-agreement" /></label>
            <label class="checkbox-text">
              <?php 
              echo sprintf($lang->translate('I agree with %s'), 
                  '<a href="' . get_site_url() . '/terms/" class="underline blue" target="_blank">' . $lang->translate('terms of service') . '</a>'); 
              ?>
            </label>
          </div>
          <p class="warning warning-agreement"></p>
        </div>
      </div>
      <div class="form-btnarea">
        <p class="button shine-active signup-button" id="signup-submit"><?php echo $lang->translate('Sign Up Submit'); ?></p>
        <p class="warning center" id="signup-warning-system"><?php echo $lang->translate('System Error'); ?></p>
      </div>
    </form>
  </section>
<?php endif; ?>

<?php
get_footer();
