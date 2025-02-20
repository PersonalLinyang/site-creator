<?php

// ショートコードを登録
function register_custom_shortcode() {
    add_shortcode('normal_header_link', 'shortcode_normal_header_link');
    add_shortcode('normal_header_button', 'shortcode_normal_header_button');
}
add_action('init', 'register_custom_shortcode');

// ノーマルページヘッダリンク作成
function shortcode_normal_header_link($atts) {
    $atts = shortcode_atts([
        'key' => '',
        'text' => '',
    ], $atts, 'normal_header_link');
    
    $key = $atts['key'];
    $text = $atts['text'];
    
    $site_url = get_site_url();
    
    $html = <<<HEREDOC
<div class="header-menu-link">
  <a href="$site_url/$key/">$text</a>
</div>
HEREDOC;
    
    return $html;
}

// ノーマルページヘッダボタン作成
function shortcode_normal_header_button($atts) {
    $atts = shortcode_atts([
        'key' => '',
        'text' => '',
    ], $atts, 'normal_header_button');
    
    $key = $atts['key'];
    $text = $atts['text'];
    
    $site_url = get_site_url();
    $icon_svg = file_get_contents(get_template_directory() . '/assets/svg/normal/' . $key . '.svg');
    
    $html = <<<HEREDOC
<div class="header-menu-button">
  <a href="$site_url/$key/">
    <div class="header-menu-button-inner header-$key">
      <p class="header-menu-button-icon">$icon_svg</p>
      <p>$text</p>
    </div>
  </a>
</div>
HEREDOC;
    
    return $html;
}