<?php

require_once __DIR__ . '/Enum.interface.php';

class EnumGenerator
{

  private static $defaultTemplateFile;

  public static function setDefaultTemplateFile($file)
  {
    self::$defaultTemplateFile = $file;
  }

  public static function getDefaultTemplateFile()
  {
    if (! self::$defaultTemplateFile)
    {
      self::$defaultTemplateFile = __DIR__ . '/Enum.tpl.php';
    }
    return self::$defaultTemplateFile;
  }

  private static $defaultCachedClassesDir;

  public static function setDefaultCachedClassesDir($dir)
  {
    self::$defaultCachedClassesDir = $dir;
  }

  public static function getDefaultCachedClassesDir()
  {
    if (! self::$defaultCachedClassesDir)
    {
      self::$defaultCachedClassesDir = __DIR__ . '/cache';
    }
    return self::$defaultCachedClassesDir;
  }

  private static $contexts = array();

  /**
   * 
   * @param unknown_type $context
   * @param unknown_type $template
   * @param unknown_type $cache_dir
   * @return EnumGenerator
   */
  public static function getInstance($context = 'default', $template = null, $cache_dir = null)
  {
    if (empty($context))
    {
      $context = 'default';
    }
    if (! isset(self::$contexts[$context]))
    {
      self::$contexts[$context] = new self($template, $cache_dir);
    }
    return self::$contexts[$context];
  }

  private function __construct($template = null, $cache_dir = null)
  {
    if (empty($template))
    {
      $template = self::getDefaultTemplateFile();
    }
    $this->setTemplateFile($template);
    
    if (empty($cache_dir))
    {
      $cache_dir = self::getDefaultCachedClassesDir();
    }
    $this->setCachedClassesDir($cache_dir);
  }

  public function generate($class, array $instances, $namespace = null)
  {
    if (empty($instances))
    {
      throw new InvalidArgumentException('$instances parameter should not be empty');
    }
    
    $isHash = count(array_filter(array_keys($instances), function($e){
      return is_string($e);
    })) == count($instances);
    
    if(!$isHash)
    {
      $instances = array_combine($instances, $instances);
    }
    
    $enums = array();
    foreach ($instances as $k => $v)
    {
      $enums[strtoupper($k)] = $v;
    }
    unset($k, $v);
    
    $iterator = array();
    foreach ($enums as $k => $v)
    {
      $iterator[] = $k;
    }
    unset($k, $v);
    
    $iterator = join(", ", $iterator);
    
    $namespace = $namespace ? "namespace $namespace;\n" : "";
    
    ob_start();
    
    require (__DIR__ . '/Enum.tpl.php');
    $content = ob_get_contents();
    
    ob_end_clean();
    
    return $content;
  }

  public function compil($class, array $instances, $namespace = null)
  {
    $file = $this->getCachedClassesDir() . "/{$class}.enum.php";
    if (! file_exists($file))
    {
      $fh = fopen($file, 'w');
      fwrite($fh, '<?php' . "\n" . $this->generate($class, $instances, $namespace));
      fclose($fh);
    }
    return $file;
  }
  
  public function evaluate($class, array $instances, $namespace = null)
  {
    $r = $this->generate($class, $instances, $namespace);
    eval($r);
  }

  private $cachedClassesDir;

  protected function setCachedClassesDir($dir)
  {
    if (! is_dir($dir))
    {
      throw new InvalidArgumentException("The directory $dir does not exist. You have to ensure it is created before calling " . __METHOD__);
    }
    return $this->cachedClassesDir = $dir;
  }

  public function getCachedClassesDir()
  {
    return $this->cachedClassesDir;
  }

  private $templateFile;

  protected function setTemplateFile($file)
  {
    if (! file_exists($file))
    {
      throw new InvalidArgumentException("The file $file does not exist");
    }
    return $this->templateFile = $file;
  }

  public function getTemplateFile()
  {
    return $this->templateFile;
  }

}