<?php
/**
 * @author Sartaj Singh <sartajphp.com>
 */
class makedist{

    private function prunePrefix( $files, $prefix ) {
        $newlist = array();
        $prefix_len = strlen( $prefix );
        foreach( $files as $file => $data ) {
            if( substr( $file, 0, $prefix_len ) !== $prefix ) {
                $newlist[$file] = $data;
            }
        }
        return $newlist;
    }
    private function pruneSuffix( $files, $suffix ) {
        $newlist = array();
        $suffix_len = strlen( $suffix );
        foreach( $files as $file => $data ) {
            if( substr( $file, -$suffix_len ) !== $suffix ) {
                $newlist[$file] = $data;
            }
        }
        return $newlist;
    }
    public function createExePhar($projpath){
        try{
        $p1 = basename($projpath);
        $filename = $p1 . "_exec.phar";
        $startfile = 'start.php';
        $buildRoot = realpath($projpath . "/dist");
        if(file_exists($buildRoot . "/" . $filename)) unlink($buildRoot . "/" . $filename);
        $phar = new Phar($buildRoot . "/" . $filename);
        $basedir = $projpath;
        $fileIter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($basedir, FileSystemIterator::SKIP_DOTS ));
        $files = iterator_to_array( $fileIter );
        $files = $this->prunePrefix( $files, $basedir . '/.git' );
        $files = $this->prunePrefix( $files, $basedir . '/dist' );
//        $files = $this->prunePrefix( $files, $basedir . '/composer' );
        $files = $this->prunePrefix( $files, $basedir . '/cache' );
//        $files = $this->prunePrefix( $files, $basedir . '/vendor' );
        //$files = $this->prunePrefix( $files, $basedir . '/test.txt' );
        $files = $this->pruneSuffix( $files, 'swp' );
        $files = $this->pruneSuffix( $files, '~' );
        
        $phar->startBuffering();
        $phar->buildFromIterator( new ArrayIterator($files), $basedir );
        $stub = "#!/usr/bin/env php
<?php 
define(\"PHARAPP\",'phar://' . __DIR__ . '/{$filename}');   
define(\"start_path\", __DIR__);   
Phar::interceptFileFuncs();
Phar::mapPhar('$filename');
set_include_path(get_include_path() . PATH_SEPARATOR . 'phar://'. __DIR__ .'/$filename' );" .
'
 global $argvm;
$argvm = array();
    $total = count($argv);
    for ($c = 0; $c < $total; $c++) {
        $next = $c + 1;
        if ($next >= $total) {
            $next = $total - 1;
        }
        if (strpos($argv[$c], "--") !== FALSE) {
            if (strpos($argv[$next], "--") !== FALSE) {
                $value = "";
                $argvm[$argv[$c]] = $value;
            } else {
                $value = $argv[$next];
                $argvm[$argv[$c]] = $value;
                $c++;
            }
        }
    }
    if(isset($argvm["--stfl"])){
' . "
require('phar://'. __DIR__ .'/{$filename}/' . \$argvm['--stfl']);
    }else{
require('phar://'. __DIR__ .'/{$filename}/$startfile');
 }
__HALT_COMPILER();
";
        # Set the stub.
        $phar->setStub($stub);

        # Wrap up.
        $phar->stopBuffering();
        //copy($buildRoot . "/" . $filename, $projpath . "/" . $filename);
        }catch (Exception $e) {
            // handle error here
            echo $e->getMessage();
            //setMsg("msg1", "Error:-" . $e->getMessage());
        }
            echo "Build Execuateble File:- " . $buildRoot . "/" . $filename;
            system( "chmod +x ". $buildRoot . "/" . $filename );
    }
}

$mk1 = new makedist();
$mk1->createExePhar($argv[1]);

