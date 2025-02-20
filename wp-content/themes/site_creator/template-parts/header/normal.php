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
        <?php 
          echo do_shortcode('[normal_header_link key="component" text="' . $lang->translate('Component') . '"]');
        ?>
      </div>
      <div class="header-menu-line">
        <?php 
          if(is_user_logged_in()) {
            echo do_shortcode('[normal_header_button key="profile" text="' . $lang->translate('Profile') . '"]');
            echo do_shortcode('[normal_header_button key="logout" text="' . $lang->translate('Logout') . '"]');
          } else {
            echo do_shortcode('[normal_header_button key="signup" text="' . $lang->translate('Sign Up') . '"]');
            echo do_shortcode('[normal_header_button key="login" text="' . $lang->translate('Login') . '"]');
          }
        ?>
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