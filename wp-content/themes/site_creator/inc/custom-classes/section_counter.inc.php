<?php

class SectionCounter {
  private static $counter;
  
  public function get() {
    if( is_null( self::$counter ) ) {
      self::$counter = 0;
    } else {
      self::$counter++;
    }
    
    return self::$counter;
  }
}