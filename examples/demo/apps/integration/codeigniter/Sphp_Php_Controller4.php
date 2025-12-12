<?php
namespace App\Controllers{
/**
 * Uses:-
 * namespace App\Controllers{
include_once(start_path . "/vendor/sartajphp/sartajphp/examples/demo/apps/integration/codeigniter/Sphp_Php_Controller4.php");


class Home extends Sphp_App_Controller
{
    public function index(): string
    {
        return "Data:- " . $this->getSartajPhpTemp("temp1");
    }
}
}

 */
class Sphp_App_Controller extends BaseController {


    public function getSartajPhpTemp($fileview,$data = []) {
        foreach($data as $i=>$v){
            global $i;
        }
        $temp1 = new \Sphp\tools\TempFile(APPPATH . "Views/" .$fileview . ".php");
        $temp1->run();
        return $temp1->data;
        
    }

}

}
