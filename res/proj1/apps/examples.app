<?php 

class examples extends Sphp\tools\BasicGate{

    public function page_new(){
        $temp1 = new FrontFile($this->mypath . "/forms/example_list.front");
        $this->setFrontFile($temp1);
    }

    public function page_event_show($evtp){
        $p = $this->mypath . "/forms/example_{$evtp}.front";
        if(file_exists($p)){
            $temp1 = new FrontFile($p);
        }else{
            $temp1 = new FrontFile('<h1>Example not found</h1>',true);
        }
        $this->setFrontFile($temp1);

    }
}