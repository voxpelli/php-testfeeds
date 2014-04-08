<?
# Deterministic random generator
# http://www.sitepoint.com/php-random-number-generator/

class Random {

  private static $RSeed;

  public static function seed($s = 0) {
    self::$RSeed = abs(intval($s)) % 9999999 + 1;
  }

  public static function num($min = 0, $max = 9999999) {
    self::$RSeed = (self::$RSeed * 125) % 2796203;
    return self::$RSeed % ($max - $min + 1) + $min;
  }

}
?>
