<?php
/**
 * Description of Counter
 *
 * @author SARTAJ
 * css class counter-box use jquery apear plugin to start counter.
 *  create only one component and then use class counter to run any other counters
 *     <div class="counter-box">
    <div class="icon">
    <img src="masters/assets/img/icon/project-done.svg" alt>
    </div>
    <div>
    <span data-count="+" data-to="2500" data-speed="3000" id="ct1" runat="server" path="libpath/comp/bundle/Counter.php">2500</span>
    <h6 class="title">+ Orders Done </h6>
    </div>
    </div>

 */



class Counter extends Sphp\tools\Component{
protected function oncreate($element){
    $this->setHTMLName("");
}

protected function onjsrender(){
    addFileLink($this->myrespath . '/res/jquery.appear.min.js');
    addFileLink($this->myrespath . '/res/counter-up.js');
    $this->element->appendAttribute('class', 'counter');
    if(!$this->element->hasAttribute('data-count')) $this->setAttribute('data-count', '+');
    if(!$this->element->hasAttribute('data-to')) $this->setAttribute('data-to', '500');
    if(!$this->element->hasAttribute('data-speed')) $this->setAttribute('data-speed', '3000');
    
addHeaderJSFunctionCode('ready','counter1','
    $(".counter").countTo();
    $(".counter-box").appear(
        function () {
            $(".counter").countTo();
        },
        { accY: -100 }
    );

    ');

}


}