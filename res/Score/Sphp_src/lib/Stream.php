<?php
class Stream{

private function isNothing($string) {
  if (!isset($string) ||
      $string == "" || 
      $string == false ||
      $string == "-")
    return true;
  
  return false;
}
 public function sendContentType($ext,$contentType="") {
     
if($contentType!=""){
\SphpBase::sphp_response()->addHttpHeader("Content-Type","$contentType");    
}else{
     switch (strtolower($ext)){
	  case "mp3":
	    \SphpBase::sphp_response()->addHttpHeader("Content-Type","audio/x-mp3");
	    break;
	  case "wav":
	    \SphpBase::sphp_response()->addHttpHeader("Content-Type","audio/x-wav");
	    break;
	  case "mpc":
	    \SphpBase::sphp_response()->addHttpHeader("Content-Type","application/mpc");
	    break;
	  case "wv":
	    \SphpBase::sphp_response()->addHttpHeader("Content-Type","application/wv");
	    break;
	  case ".ra":
	  case ".rm":
	    \SphpBase::sphp_response()->addHttpHeader("Content-Type","audio/x-pn-realaudio");
	    break;
	  case "flac":
	    \SphpBase::sphp_response()->addHttpHeader("Content-Type","application/flac");
	    break;
	  case "ogg":
	    \SphpBase::sphp_response()->addHttpHeader("Content-Type","application/ogg");
	    break;
	  case "avi":
	    \SphpBase::sphp_response()->addHttpHeader("Content-Type","video/x-msvideo");
	    break;
	  case "mpg":
	  case "mpeg":
	    \SphpBase::sphp_response()->addHttpHeader("Content-Type","video/x-mpeg");		
	    break;
	  case "asf":
	  case "asx":
	  case "wma":
	  case "wmv":
	    \SphpBase::sphp_response()->addHttpHeader("Content-Type","video/x-ms-asf");
	    break;
	  case "mov":
	    \SphpBase::sphp_response()->addHttpHeader("Content-Type","application/x-quicktimeplayer");
	    break;
		case "flv":
	    \SphpBase::sphp_response()->addHttpHeader("Content-Type","video/x-flv");
	    break; 
		case "m4v":
	    \SphpBase::sphp_response()->addHttpHeader("Content-Type","video/x-m4v");
	    break;
		case "mkv":
	    \SphpBase::sphp_response()->addHttpHeader("Content-Type","video/x-matroska");
	    break;
	  case "mid":
	  case "midi":
	    \SphpBase::sphp_response()->addHttpHeader("Content-Type","audio/midi");
	    break;
	  case "aac":
	  case "mp4":
	    \SphpBase::sphp_response()->addHttpHeader("Content-Type","application/x-quicktimeplayer");
	    break;
	  }
}
	}
private	function getContentRange($size) {
		$from = 0; $to = $size-1;
		
		if (\SphpBase::sphp_request()->isServer('HTTP_RANGE')) {
			$split = explode("=",\SphpBase::sphp_request()->server('HTTP_RANGE'));
			if (trim($split[0]) == "bytes") {
				if ($split[1][0] == '-') {
					if ($size !== false) {
						$val = trim(substr($split[1], 1));
						$from = $size - $val - 1; // TODO: VERIFY THE -1 HERE
					}
				}
				if (strpos($split[1], '-') !== false) {
					$split2 = explode("-",$split[1]);
					if (isset($split2[1]) && !$this->isNothing($split2[1])) {
						$to = trim($split2[1]);
					}
					
					$from = trim($split2[0]);
				} else {
					$from = trim($split[1]);
				}
				       			
       			if(empty($to)) {
           			$to = $size - 1;  // -1  because end byte is included
                     		          //(From HTTP protocol:
									 // 	'The last-byte-pos value gives the byte-offset of the 
									// last byte in the range; that is, the byte positions specified are inclusive')
       			}
       			
       			return array($from,$to);
			}
		}
		return false;
	}

        public	function sendMedia($path, $name,$resample=false,$buffersize=100,$limit=false,$chunktime=5) {
		// Let's get the extension from the file
		$extArr = explode(".",$path);
		$ext = $extArr[count($extArr)-1];
		
		// Now let's fix up the name
		if (substr($name,0-strlen($ext)-1) != "." . $ext) {
		  $name .= "." . $ext;
		}
stopOutput();		
		// First are we resampling?
		// If so no \SphpBase::sphp_response()->addHttpHeader here
		if ($resample !== false){
		  $this->sendContentType($ext);
		}		
		// TODO: resample.
		// probably make a different streamFile (streamResampled)
		$this->streamFile($path,$name,$buffersize,$limit,$chunktime);
	}

public	function streamFile($path,$name,$buffersize=100,$limit=false,$chunktime=5) {
			$speed_limit = $buffersize; 
		$size = filesize($path);
		
		$range = $this->getContentRange($size);
		if ($range !== false) {
			$range_from = $range[0];
			$range_to = $range[1];
		} else {
			$range_from = 0;
			$range_to = $size-1;
		}
		if ($range === false) {
		  // Content length has not already been sent
		  \SphpBase::sphp_response()->addHttpHeader("Content-length", (string)$size);
		} else {
				\SphpBase::sphp_response()->addHttpHeader("HTTP/1.1 206 Partial Content");
				\SphpBase::sphp_response()->addHttpHeader("Accept-Range", "bytes");
				\SphpBase::sphp_response()->addHttpHeader("Content-Length", ($size - $range_from));
				\SphpBase::sphp_response()->addHttpHeader("Content-Range", "bytes $range_from" . "-" . ($range_to) . "/$size");
		}
		
		\SphpBase::sphp_response()->addHttpHeader("Content-Disposition", "inline; filename=\"".$name."\"");
		\SphpBase::sphp_response()->addHttpHeader("Expires", gmdate("D, d M Y H:i:s", mktime(date("H")+2, date("i"), date("s"), date("m"), date("d"), date("Y")))." GMT");
		\SphpBase::sphp_response()->addHttpHeader("Last-Modified", gmdate("D, d M Y H:i:s", filemtime($path))." GMT");
		\SphpBase::sphp_response()->addHttpHeader("Cache-Control", "no-cache, must-revalidate");
		\SphpBase::sphp_response()->addHttpHeader("Pragma", "no-cache");
    $file = fopen($path, 'rb');
		if (isset($file)) {
		  @set_time_limit(0);
		  fseek($file, $range_from);				
		  while(!feof($file) and (connection_status()==0) and ($cur_pos = ftell($file)) < $range_to+1) {
		  	print(fread($file, min(1024*$speed_limit, $range_to + 1 - $cur_pos)));
		    flush();
                    ob_flush();
		    if ($limit !== false) {
		    	sleep($chunktime);
		    }
		  }
		 
//		  $status = connection_status();
		  fclose($file);
		  @set_time_limit(30);
		}

	}

}
