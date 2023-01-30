<?php
class Stream{
public function sendContentType($ext,$contentType="") {}
public	function sendMedia($path, $name,$resample=false,$buffersize=100,$limit=false,$chunktime=5) {}
public	function streamFile($path,$name,$buffersize=100,$limit=false,$chunktime=5) {}
}
