<?php 

class examples extends Sphp\tools\BasicGate{

    public function page_new(){
        $frtMain = new FrontFile("list");
        $this->setFrontFile($frtMain);
    }

    public function page_event_show($evtp){
        $p = "{$evtp}";
        if(file_exists($p)){
            $frtMain = new FrontFile($p);
        }else{
            $frtMain = new FrontFile('<h1>Example not found</h1>',true);
        }
        $this->setFrontFile($frtMain);

    }
}