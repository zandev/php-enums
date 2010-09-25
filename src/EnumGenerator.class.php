<?php

class EnumGenerator
{
  
  private static $contexts = array();
  
  public static function getInstance($context = 'default', $template = null, $cache_dir = null)
  {
    if(empty($context))
    {
      $context = 'default';
    }
    if(!@self::$contexts[$context])
    {
      self::$contexts[$context] = new self($template, $cache_dir);
    }
    return self::$contexts[$context];    
  }
  
  private function __construct($template = null, $cache_dir = null)
  {
    if(empty($template))
    {
      $template = __DIR__ . '/Enum.tpl.php';
    }
    $this->setTemplateFile($template);
    
    if(empty($cache_dir))
    {
      $cache_dir = __DIR__ . '/cache';
    }
    $this->setCachedClassesDir($cache_dir);
  }
  
  public function generate($class, array $instances, $namespace = null)
  {
    $enums = array_map(function($e){
      return strtoupper($e);
    }, $instances);
    
    $iterator = join(", ", array_map(function($e){
        return "$this->e()";
      }, $instances));
    
    $namespace = $namespace ? "namespace $namespace;\n" : "";
    
    ob_start();
    
    require (__DIR__ . '/Enum.tpl.php');
    $content = ob_get_contents();
    
    ob_end_clean();
    
    return $content;
  }

  public function build($class, array $instances, $namespace = null)
  {
    if (! file_exists($file = $this->getCachedClassesDir() . "{$class}Enum.class.php"))
    {
      $fh = fopen($file, 'w');
      fwrite($fh, '<?php' . "\n" . $this->generate($class, $instances, $namespace));
      fclose($fh);
    }
  }

  private $cachedClassesDir;

  public function setCachedClassesDir($dir)
  {
    if(!is_dir($dir))
    {
      throw new Exception("The directory $dir does not exist. You have to ensure it is created before calling " . __METHOD__);
    }
    return $this->cachedClassesDir = $dir;
  }

  public function getCachedClassesDir()
  {
    return $this->cachedClassesDir;
  }

  private $templateFile;
  
  public function setTemplateFile($file)
  {
    if(!file_exists($file))
    {
      throw new Exception("The file $file does not exist");
    }
    return $this->templateFile = $file;
  }
  
  public function getTemplateFile()
  {
    return $this->templateFile;
  }

}