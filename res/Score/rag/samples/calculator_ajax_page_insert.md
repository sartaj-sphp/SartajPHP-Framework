# AJAX Calculator Client and Server Side Validation with page_insert event (BasicGate)

## 1️⃣ Application's Gate File

**`apps/Calculator.gate.php`**

```php
class Calculator extends Sphp\tools\BasicGate {

    private $frtMain = null;

    public function onstart(){
        // create Front File Object
		// $this->mypath."/fronts/calculator_main.front"
        $this->frtMain = new Sphp\tools\FrontFile("main");
    }

    // URL = calculator.html handle by this
    public function page_new(){
        // enable FrontFile Object rendering
        $this->setFrontFile($this->frtMain);
    }
		
    public function page_insert(){
        $a = (int)$this->frtMain->getComponent("numa")->value;
        $b = (int)$this->frtMain->getComponent("numb")->value;
        $op = $this->frtMain->getComponent("sltop")->value;
        $res = 0;
        if($op=="+") $res = $a + $b;
        if($op=="-") $res = $a - $b;
        $this->JSServer->addJSONHTMLBlock("result",$res);
    }
	
}
```

## 2️⃣ FrontFile

**`fronts/calculator_main.front`**

```html
<div id="result"></div>
<form id="form2" runat="server" fun-setAJAX="" action="##{getThisGateURL()}#">
<input id="numa" runat="server" type="text" placeholder="Number1" fui-setNumeric="" fui-setForm="form2" />
<input id="numb" runat="server" type="text" placeholder="Number2" fui-setNumeric="" fui-setForm="form2" />
<select id="sltop" runat="server" fui-setForm="form2" fun-setOptions="+,-"></select>
<input type="submit" value="Calculate" />
</form>
```

## 3️⃣ Register Gate File with SartajPHP reg.php

```php
// register Gate=calculator So Browser default URL=calculator.html
registerGate("calculator",__DIR__ ."/apps/Calculator.gate.php");
```
