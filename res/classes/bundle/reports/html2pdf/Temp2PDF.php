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
        $cleanhtml = strip_tags($this->objTemp->data,'<div><p><table><tr><td><th><style><page><page_header><br><page_footer><hr><img><h1><h2><h3><h4><h5><h6><span><b><i>');
        $this->WriteHTML($cleanhtml);
        $this->Output($name,$dest);
   //echo $cleanhtml;
    }
}