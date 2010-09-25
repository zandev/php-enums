<?php echo $namespace ?>
class <?php echo $class ?> implements Enum
{
<?php foreach($enums as $name => $value):?>
  private static $<?php echo $name ?>;

  public static function <?php echo $name ?>()
  {
    return self::$<?php echo $name ?> ? self::$<?php echo $name ?> : self::$<?php echo $name ?> = new self("<?php echo $name ?>", "<?php echo $value ?>");
  }
<?php endforeach; ?>

  private $name;

  public function getName()
  {
    return $this->name;
  }
  
  private $value;

  public function getValue()
  {
    return $this->value;
  }

  private $ordinal;

  public function getOrdinal()
  {
    return $this->ordinal;
  }
  
  private $binary;
  
  public function getBinary()
  {
    return $this->binary;
  }

  private static $instancesCount = 0;

  private function __construct($name, $value)
  {
    $this->name = $name;
    $this->value = $value;
    $this->ordinal = ++self::$instancesCount;
    $this->binary = pow(2, $this->getOrdinal() - 1);
  }

  private static $instances = array();

  public static function iterator()
  {
    return self::$instances ? self::$instances : self::$instances = array(<?php echo $iterator ?>);
  }

  public function __toString()
  {
    return $this->getName();
  }
}
