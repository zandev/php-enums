<?php echo $namespace ?>
class <?php echo $class ?>
{
<?php foreach($enums as $enum):?>
  private static $<?php echo $enum ?>;

  public static function <?php echo $enum ?>()
  {
    return self::$<?php echo $enum ?> ? self::$<?php echo $enum ?> : self::$<?php echo $enum ?> = new self("<?php echo $enum ?>");
  }
<?php endforeach; ?>

  private $ordinal;

  public function getOrdinal()
  {
    return $this->ordinal;
  }

  private $value;

  public function getValue()
  {
    return $this->value;
  }

  private static $instancesCount = 0;

  private function __construct($value)
  {
    $this->ordinal = ++self::$instancesCount;
    $this->value = $value;
  }

  private static $instances = array();

  public static function iterator()
  {
    return self::$instances ? self::$instances : self::$instances = array(<?php echo $iterator ?>);
  }

  public function __toString()
  {
    return $this->getValue();
  }
}
