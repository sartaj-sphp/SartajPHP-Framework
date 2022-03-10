<?php
/**
 * Description of ForLoop
 *
 * @author SARTAJ
 */
namespace Sphp\comp\html{


class ForLoop extends \Sphp\tools\Control{
public $counterMin = 0;
public $counterStep = 1;
public $counterMax = 0;
public $strFormat = '';

public function __construct($name='',$fieldName='',$tableName='') {
$this->init($name,'','');
$this->unsetrenderTag();
}

public function setLoopFrom($val){
$this->counterMin = $val;
}
public function setLoopTo($val){
$this->counterMax = $val;
}
public function setStep($val){
$this->counterStep = $val;
}

private function genrender(){
$stro = executePHPCode('<?php
for($index = $'. $this->name .'->counterMin;$index <= $'. $this->name .'->counterMax;$index += $'. $this->name .'->counterStep ){
?>'.$this->strFormat.'<?php
} ?>');
return $stro;

}


public function onrender(){
  $this->strFormat = $this->innerHTML;
    $this->innerHTML = $this->genrender();
}


}
}
