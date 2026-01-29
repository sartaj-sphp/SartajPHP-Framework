<?php
require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

class Front2PDF extends HTML2PDF{
    private $objFront = null;
    
    public function __construct($frontobj,$orientation='P', $format='A4', $langue='en', $unicode=true, $encoding='UTF-8', $margins=array(5, 5, 5, 8),$pdfa = false) {
        $this->objFront = $frontobj;
        parent::__construct($orientation, $format, $langue, $unicode, $encoding, $margins,$pdfa);
    }
    public function render($name='',$dest=false) {
		SphpBase::engine()->cleanOutput();
		SphpBase::sphp_response()->addHttpHeader("Content-Type","application/pdf");
        $this->objFront->run();
        $cleanhtml = strip_tags($this->objFront->data,'<div><p><table><tr><td><th><style><page><page_header><br><page_footer><hr><img><h1><h2><h3><h4><h5><h6><span><b><i>');
        $this->WriteHTML($cleanhtml);
        $this->Output($name,$dest);
   //echo $cleanhtml;
    }
}