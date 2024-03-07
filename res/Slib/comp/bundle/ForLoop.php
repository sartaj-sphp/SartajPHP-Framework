<?php

/**
 * Description of ForLoop
 *
 * @author SARTAJ
 */



    class ForLoop extends \Sphp\tools\Control {

        public $counterMin = 0;
        public $counterStep = 1;
        public $counterMax = 0;
        private $childrenroot = null;

        public function onaftercreate() {
            $this->unsetrenderTag();
            $this->childrenroot = $this->tempobj->getChildrenWrapper($this);
        }

        public function setLoopFrom($val) {
            $this->counterMin = $val;
        }

        public function setLoopTo($val) {
            $this->counterMax = $val;
        }

        public function setStep($val) {
            $this->counterStep = $val;
        }

        private function genrender() {
            $stro = '';
            for($c = $this->counterMin; $c < $this->counterMax; $c += $this->counterStep){
                $stro .= $this->tempobj->parseComponentChildren($this->childrenroot);
            }
            return $stro;
        }

        public function onrender() {
            $this->innerHTML = $this->genrender();
        }

    }


