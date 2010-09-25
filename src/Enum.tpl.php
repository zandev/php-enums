<?php 
/**
 * Copyright (C) 2010 Stéphane Robert Richard.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 3. Neither the name of the project nor the names of its contributors
 *    may be used to endorse or promote products derived from this software
 *    without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE PROJECT AND CONTRIBUTORS ``AS IS'' AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED.  IN NO EVENT SHALL THE PROJECT OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
 * OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
 * OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
 * SUCH DAMAGE.
 * 
 */
?>
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
