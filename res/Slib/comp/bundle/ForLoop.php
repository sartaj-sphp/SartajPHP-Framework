<?php

/**
 * Description of ForLoop
 *
 * @author SARTAJ
 */



    class ForLoop extends \Sphp\tools\Component {

        private $counterMin = 0;
        private $counterStep = 1;
        private $counterMax = 0;
        private $childrenroot = null;
        public $counter = 0;

        protected function onaftercreate() {
            //$this->fu_unsetrenderTag();
            $this->childrenroot = $this->frontobj->getChildrenWrapper($this);
        }

        public function fu_setLoopFrom($val) {
            $this->counterMin = $val;
        }

        public function fu_setLoopTo($val) {
            $this->counterMax = $val;
        }

        public function fu_setStep($val) {
            $this->counterStep = $val;
        }
        
        private function genrender() {
            $stro = '';
            for($this->counter = $this->counterMin; $this->counter < $this->counterMax; $this->counter += $this->counterStep){
                $stro .= $this->frontobj->parseComponentChildren($this->childrenroot);              
            }
            return $stro;
        }

        protected function onprerender() {
            //delete all children nodes so stop also children Components Rendering also
            $this->innerHTML =  "";
        }        
        protected function onrender() {
            $this->innerHTML = $this->genrender();
        }

    }


