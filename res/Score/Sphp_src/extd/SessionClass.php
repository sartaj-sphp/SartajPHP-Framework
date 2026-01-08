<?php
namespace Sphp\tools{
/**
 * Description of SessionClass
 *
 * @author Sartaj Singh
 */

class SessionClass{
    private $name = "propvt";
    public function __construct($name="propvt") {
        $this->name = $name;
        $this->restoreVals();
        $this->onstart();
    }
    private function session($name,$value="") {
        if($value!=""){
            \SphpBase::sphp_request()->session($name, $value);
        }else{
            return \SphpBase::sphp_request()->session($name);
        }
    }
    public function onstart() { }
    public function onend() { }
    private function restoreVals(){
        $vt = $this->session($this->name);
        if(is_array($vt)){
            foreach ($vt as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }
    private function saveVals(){
        $vt = array();
        $reflector = new \ReflectionClass($this);
        $properties = $reflector->getProperties();
        foreach($properties as $property){
            $propname = $property->getName();
            $vt[$propname] = $this->{$propname} ;
        }
        $this->session($this->name,$vt);
    }
    public function __destruct() {
        $this->onend();
        $this->saveVals();
    }

}
}
