<?php 

class examples extends Sphp\tools\BasicApp{

    public function page_new(){
        $temp1 = new TempFile($this->mypath . "/forms/example_list.front");
        $this->setTempFile($temp1);
    }

    public function page_event_show($evtp){
        $p = $this->mypath . "/forms/example_{$evtp}.front";
        if(file_exists($p)){
            $temp1 = new TempFile($p);
        }else{
            $temp1 = new TempFile('<h1>Example not found</h1>',true);
        }
        $this->setTempFile($temp1);

    }
}