<?php

class DateTimeRangeApp extends Sphp\tools\CompApp{

    private $temp1 = null;
    
    public function onstart(){
        $this->temp1 = $this->createTempFile($this->mypath . "/apps/forms/DateTimeRange.front",true); 
         $this->setTempFile($this->temp1);
    }
    
}
