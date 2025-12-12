<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(BASEPATH ."core/Loader.php");
/**
uses:-
include_once(start_path . "/vendor/sartajphp/sartajphp/examples/demo/apps/integration/codeigniter/Sphp_Php_Controller2.php");
class Report1List extends Sphp_App_Controller {
	
	public function index($page = 0, $result = '', $action = '') {
		$this->data['result'] = $result;
		$this->load->view('base/header', $this->data); 
		$this->load->getSartajPhpTemp('report1userslist', $this->data);
		$this->load->view('base/footer', $this->data);
	}
}
*/
class Sphp_Php_Loader extends CI_Loader {
    /**
     * Simulates $this->load->view() but as TempFile.
	 load mytemp file from Views folder and pass $data key variabales
     * Usage: $this->load->getSartajPhpTemp('mytemp', $data);
     */
    public function getSartajPhpTemp($fileview,$data = []) {
        $ci =& get_instance(); // Get CI instance
        foreach($data as $i=>$v){
            global $i;
        }
        $temp1 = new TempFile(APPPATH . "views/" .$fileview . ".php");
        $temp1->run();
        $output = $temp1->data;
        
        // Inject output into CI's final render
        $ci->output->append_output($output);
    }

}


class Sphp_App_Controller extends CI_Controller {
    //protected $data = [];

    public function __construct() {
        parent::__construct();
        $this->load = new Sphp_Php_Loader();
    }
}

