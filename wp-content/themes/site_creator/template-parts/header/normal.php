<?php

global $lang_key_list;
global $lang_code_list;
global $lang_name_list;

$lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
$lang_domain = 'site-creator-' . $lang_code;

$current_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

?>

<header class="header">
  <div class="header-inner">
    <div class="header-logo"></div>
    <div class="header-menu">
      <?php if(is_user_logged_in()): ?>
      <div class="header-menu-btnarea sp-only">
        <p class="header-menu-button header-profile">
          <a class="full-link" href="<?php echo get_site_url(); ?>/profile/"><?php echo __( 'Profile', $lang_domain ); ?></a>
        </p>
        <p class="header-menu-button header-logout">
          <a class="full-link" href="<?php echo get_site_url(); ?>/logout/"><?php echo __( 'Logout', $lang_domain ); ?></a>
        </p>
      </div>
      <?php else: ?>
      <div class="header-menu-btnarea sp-only">
        <p class="header-menu-button header-signup">
          <a class="full-link" href="<?php echo get_site_url(); ?>/signup/"><?php echo __( 'Sign Up', $lang_domain ); ?></a>
        </p>
        <p class="header-menu-button header-login">
          <a class="full-link" href="<?php echo get_site_url(); ?>/login/"><?php echo __( 'Login', $lang_domain ); ?></a>
        </p>
      </div>
      <?php endif; ?>
    </div>
    <div class="header-controller">
      <div class="header-language pc-only">
        <div class="header-language-list">
        <?php 
        foreach($lang_key_list as $lang_key):
          if($lang_code != $lang_key):
        ?>
          <div class="header-language-item">
            <div class="header-language-code">
              <a class="header-language-link full-link" href="<?php echo qtranxf_convertURL($current_url, $lang_key, '', true);?>">
                <p class="header-language-code-text"><?php echo $lang_code_list[$lang_key]; ?></p>
              </a>
            </div>
            <a class="header-language-link" href="<?php echo qtranxf_convertURL($current_url, $lang_key, '', true);?>">
              <p class="header-language-name"><?php echo str_replace(' ', '<br/>', $lang_name_list[$lang_key]); ?></p>
            </a>
          </div>
        <?php 
          endif;
        endforeach; 
        ?>
        </div>
      </div>
      <div class="header-language sp-only">
        <div class="header-language-now header-language-item">
          <div class="header-language-code"><p class="header-language-code-text"><?php echo $lang_code_list[$lang_code]; ?></p></div>
          <p class="header-language-name"><?php echo str_replace(' ', '<br/>', $lang_name_list[$lang_code]); ?></p>
        </div>
        <div class="header-language-list">
        <?php 
        foreach($lang_key_list as $lang_key):
          if($lang_code != $lang_key):
        ?>
          <a class="header-language-link" href="<?php echo qtranxf_convertURL($current_url, $lang_key, '', true);?>">
            <div class="header-language-item">
              <div class="header-language-code">
                <p class="header-language-code-text"><?php echo $lang_code_list[$lang_key]; ?></p>
              </div>
              <p class="header-language-name"><?php echo str_replace(' ', '<br/>', $lang_name_list[$lang_key]); ?></p>
            </div>
          </a>
        <?php 
          endif;
        endforeach; 
        ?>
        </div>
      </div>
      <?php if(is_user_logged_in()): ?>
      <div class="header-button header-profile pc-only">
        <a class="full-link" href="<?php echo get_site_url(); ?>/profile/"><?php echo __( 'Profile', $lang_domain ); ?></a>
      </div>
      <div class="header-button header-logout pc-only">
        <a class="full-link" href="<?php echo get_site_url(); ?>/logout/"><?php echo __( 'Logout', $lang_domain ); ?></a>
      </div>
      <?php else: ?>
      <div class="header-button header-signup pc-only">
        <a class="full-link" href="<?php echo get_site_url(); ?>/signup/"><?php echo __( 'Sign Up', $lang_domain ); ?></a>
      </div>
      <div class="header-button header-login pc-only">
        <a class="full-link" href="<?php echo get_site_url(); ?>/login/"><?php echo __( 'Login', $lang_domain ); ?></a>
      </div>
      <?php endif; ?>
      <div class="header-menu-handler sp-only">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
</header>

<main class="main-normal">