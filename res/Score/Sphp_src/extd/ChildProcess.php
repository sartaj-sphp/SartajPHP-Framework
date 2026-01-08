<?php
namespace Sphp\tools{
/**
 * Experimental:- Create a Child process with PHP
 */
    class ChildProcess {
        private $cmd;
        private $cwd;
        private $env;
        private $options;
        //private $enhanceSigchildCompatibility;
        private $pipes;
        private $process = null;
        private $isRunning = false;

        /**
         * Constructor.
         *
         * @param string $cmd     Command line to run
         * @param string $cwd     Current working directory or null to inherit
         * @param array  $env     Environment variables or null to inherit
         * @param array  $options Options for proc_open()
         * @throws RuntimeException When proc_open() is not installed
         */
        public function __construct($cmd, $cwd = null, array $env = null, array $options = null) {
            if (!function_exists('proc_open')) {
                throw new \RuntimeException('The Process class relies on proc_open(), which is not available on your PHP installation.');
            }

            $this->cmd = $cmd;
            $this->cwd = $cwd;

            if (null !== $env) {
                $this->env = array();
                foreach ($env as $key => $value) {
                    $this->env[(binary) $key] = (binary) $value;
                }
            }

            $this->options = $options;
            
            //$this->enhanceSigchildCompatibility = $this->isSigchildEnabled();
            $cmd = $this->cmd;
            $fdSpec = array(
                array('pipe', 'r'), // stdin
                array('pipe', 'w'), // stdout
                array('pipe', 'w'), // stderr
            );


            $this->process = proc_open($cmd, $fdSpec, $this->pipes, $this->cwd, $this->env, $this->options);
            //echo "create process";
            if (!is_resource($this->process)) {
                throw new \RuntimeException('Unable to launch a new process.');
            } else {
                //stream_set_blocking($this->pipes[1], 0);
                $this->isRunning = true;
            }
        }

        public function write($msg) {
            if (is_resource($this->process)) {
                fwrite($this->pipes[0], $msg);
                //stream_write_contents();
            }
        }

        public function read() {
            if (is_resource($this->process)) {
                $msg = trim(fgets($this->pipes[1]));
		if($msg !== ""){
                    $msg = hex2bin($msg);
                    return $msg;
		}
            }
            return "";
        }

        public function readErr() {
            if (is_resource($this->process)) {
                $msg = stream_get_contents($this->pipes[2]);
                return $msg;
            }
            return "";
        }

        public function run() {
            while (1) {
                //usleep(300000);
                echo "wait \n";
                echo "read:- " . $this->read();
                //ondata()
                echo " done \n";
                if(! $this->getStatus()) break;
            }
            $errmsg = $this->readErr();
            $this->closeProcess();
        }

        public function closeProcess() {
            if (is_resource($this->process)) {
                fclose($this->pipes[0]);
                fclose($this->pipes[1]);
                fclose($this->pipes[2]);
                $return_value = proc_close($this->process);
                //echo "command returned $return_value\n";
                return $return_value;
            }
        }

        public function getStatus() {
            if (is_resource($this->process)) {
            return proc_get_status($this->process)['running'];
            }
            return 0;
        }

        public function __destruct() {
             if (is_resource($this->process)) {
                 $this->closeProcess();
             }
        }
    }

    
}
