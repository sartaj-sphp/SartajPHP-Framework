<?php

/**
 * Description of ForLoop
 *
 * @author SARTAJ
 * <div id="usersLoop" runat="server"
     path="slibpath/comp/server/ForEachLoop.php"
     fun-setObject="users">
    <div class="user">
        Name: ##{$usersLoop->getItem('name')}##<br />
        Email: ##{$usersLoop->getItem('contact_email')}##
    </div>
</div>

 */



    class ForEachLoop extends \Sphp\tools\Component {

        public $key = "";
        public $item = "";
        private $childrenroot = null;
        private $loopobj = null;
        public $counter = 0;

        protected function onaftercreate() {
            //$this->fu_unsetrenderTag();
            $this->loopobj = array();
            $this->childrenroot = $this->frontobj->getChildrenWrapper($this);
        }

        /**
         *  Set Object for Loop, direct read declared variables in Front File. 
         *  Example:- pass 'a' mean $a
         * @param string $name Name of Variable declare in Front File
         */
        public function fu_setObject($val) {
            $this->loopobj = $this->frontobj->getMetaData($val);
        }
        /** read if item is object
         * 
         */
        public function getItem($v){
            if(is_array($this->item)){
                return $this->item[$v];
            }else if(is_object($this->item)){
                return $this->item->{$v};                
            }else{
                return $this->item;
            }
        }
        private function genrender() {
            $stro = '';
            foreach($this->loopobj as $key=>$val){
                $this->key = $key;
                $this->item = $val;
                $this->counter += 1;
                $stro .= $this->frontobj->parseComponentChildren($this->childrenroot);              
            }
            return $stro;
        }

        protected function onprerender() {
            //delete all children nodes so stop also children Components Rendering also
            $this->innerHTML =  "";
        }        
        protected function onrender() {
            $this->counter = 0;
            $this->innerHTML = $this->genrender();
        }

    }


