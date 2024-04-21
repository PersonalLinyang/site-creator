<?php

require_once get_template_directory() . '/inc/custom-classes/language_supporter.inc.php';

$lang = new LanguageSupporter();
$lang_name_list = get_option('qtranslate_language_names');
$lang_key_list = function_exists('qtranxf_getSortedLanguages') ? qtranxf_getSortedLanguages() : array('en');

$current_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

?>

<header class="header">
  <div class="header-inner">
    <div class="header-logo"></div>
    
    <div class="header-menu">
      <div class="header-menu-line">
      </div>
      <div class="header-menu-line">
          <?php if(is_user_logged_in()): ?>
            <div class="header-menu-button">
              <a href="<?php echo get_site_url(); ?>/profile/">
                <div class="header-menu-button-inner header-profile">
                  <p class="header-menu-button-icon header-profile-icon"><?php echo file_get_contents(get_template_directory() . '/assets/svg/normal/profile.svg'); ?></p>
                  <p><?php echo $lang->translate('Profile'); ?></p>
                </div>
              </a>
            </div>
            <div class="header-menu-button">
              <a href="<?php echo get_site_url(); ?>/logout/">
                <div class="header-menu-button-inner header-logout">
                  <p class="header-menu-button-icon header-logout-icon"><?php echo file_get_contents(get_template_directory() . '/assets/svg/normal/logout.svg'); ?></p>
                  <p><?php echo $lang->translate('Logout'); ?></p>
                </div>
              </a>
            </div>
          <?php else: ?>
            <div class="header-menu-button">
              <a href="<?php echo get_site_url(); ?>/signup/">
                <div class="header-menu-button-inner header-signup">
                  <p class="header-menu-button-icon header-signup-icon"><?php echo file_get_contents(get_template_directory() . '/assets/svg/normal/signup.svg'); ?></p>
                  <p><?php echo $lang->translate('Sign Up'); ?></p>
                </div>
              </a>
            </div>
            <div class="header-menu-button">
              <a href="<?php echo get_site_url(); ?>/login/">
                <div class="header-menu-button-inner header-login">
                  <p class="header-menu-button-icon header-login-icon"><?php echo file_get_contents(get_template_directory() . '/assets/svg/normal/login.svg'); ?></p>
                  <p><?php echo $lang->translate('Login'); ?></p>
                </div>
              </a>
            </div>
          <?php endif; ?>
      </div>
    </div>

    <div class="header-menu-handler sp-only">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  
  <div class="header-language">
    <div class="header-language-current language-<?php echo $lang->code(); ?>">
      <p class="header-language-current-icon"><?php echo file_get_contents(get_template_directory() . '/assets/svg/normal/global.svg'); ?></p>
      <?php echo $lang->name(); ?>
    </div>
    <ul class="header-language-list">
      <?php 
      foreach($lang_key_list as $lang_code):
        if($lang->code() != $lang_code):
      ?>
        <li class="header-language-item language-<?php echo $lang_code; ?>">
          <a class="full-link" href="<?php echo qtranxf_convertURL($current_url, $lang_code, '', true);?>">
            <?php echo $lang_name_list[$lang_code]; ?>
          </a>
        </li>
      <?php 
        endif;
      endforeach; 
      ?>
    </ul>
  </div>
</header>

<main class="main-normal">