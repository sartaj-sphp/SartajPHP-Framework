<?php
require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

class Temp2PDF extends HTML2PDF{
    private $objTemp = null;
    
    public function __construct($tempobj,$orientation='P', $format='A4', $langue='en', $unicode=true, $encoding='UTF-8', $margins=array(5, 5, 5, 8),$pdfa = false) {
        $this->objTemp = $tempobj;
        parent::__construct($orientation, $format, $langue, $unicode, $encoding, $margins,$pdfa);
    }
    public function render($name='',$dest=false) {
		SphpBase::engine()->cleanOutput();
		SphpBase::sphp_response()->addHttpHeader("Content-Type","application/pdf");
        $this->objTemp->run();
        $this->WriteHTML($this->objTemp->data);
        $this->Output($name,$dest);
		//echo $this->objTemp->data;
    }
}