<?php

class SphpProfiler extends Sphp\core\DebugProfiler{
    
    private function consoleMsg($msg,$type="log"){
        $msg = str_replace("\r", ' ',$msg);
        $msg = str_replace("\n", ' ',$msg);
        return 'console.info("' . str_replace('"', '\"',$msg) . '");';
    }
    public function render() { 
        $C = 0;
        $str1 = '';
        try{
           
        foreach ($this->msg as $key=>$value) { 
            if($C > 90){
                break ;
            }
            if($value[4]=="info"){
            //    $C += 1;
                //$firephp->info($value[0]);
            }else if($value[4]=="infoi"){
                $C += 1;
                 $str1 .= $this->consoleMsg($value[0],"infoi");
            }else{
                $C += 1;
                $str1 .= $this->consoleMsg("$value[2] - $value[0]" . " $value[1] - $value[3]");
            }
        }
        if(function_exists("getCheckErr") && getCheckErr()){
            $str1 .= traceError(false).' '.traceErrorInner(false);
        }
        }  catch (Exception $e){
            echo 'Debugger Failed: ',  $e->getMessage(), "\n";
        }
        //$str1 .= '</script>';
        addFooterJSCode("debugger1",$str1);
        
        
//        $firephp->log('Plain Message');     // or FB::
//        $firephp->warn('Warn Message');     // or FB::
    }
    
    }
    