<?php

class LanguageSupporter {
  private static $code;
  private static $domain;
  
  function __construct() {
    $default = get_option('qtranslate_default_language');
    if($default == false) {
      $default = 'en';
    }
    
    self::$code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : $lang_default;
    self::$domain = 'site-creator-' . self::$code;
  }

  public function code() {
    return self::$code;
  }

  public function name() {
    $name_list = get_option('qtranslate_language_names');
    return array_key_exists(self::$code, $name_list) ? $name_list[self::$code] : '';
  }

  public function domain() {
    return self::$domain;
  }

  public function translate($message) {
    return __($message, self::$domain);
  }

}