<?php
namespace Sphp\tools{

        class SphpThread{
	private $ffi = null;
	private $sphpT = null;
	
	public function __construct(){
		if($this->ffi == null){
			$this->ffi = \FFI::load(__DIR__ . '/SphpThread.h');
		}
		$this->sphpT = $this->ffi->SphpThread2__create();
	}
	
	public function startT($strName1,$onrunhandler){
		$this->ffi->addThread($this->sphpT,$strName1);
		$this->ffi->on_thread_run($this->sphpT,$onrunhandler);
		$this->ffi->runThreadAll($this->sphpT);
	}
	
	public function readStdinAsync(){
        	return $this->ffi->readStdinAsync($this->sphpT);
	}
	public function onTRun($str){
			echo $str . "\n";
	}
	public function isRunning(){
		return $this->ffi->isRunning($this->sphpT);;
	}
	
	public function __destruct(){
		if($this->sphpT !== null){
			$this->ffi->SphpThread2__destroy($this->sphpT);
		}
	}
}

    
}
