# AJAX Calculator only Server Side Validation (BasicApp)

## App: calculator.app register with Appgate=calculator and URL=calculator.html

This sample Design UI with HTML in Front File and Calculate all mathematical 
calculations on Server Side in BasicApp. Finally result send as AJAX response 
with JSServer Object to <div> Tag with id=result. 

---

## 1️⃣ Application File

**`apps/calculator.app`**

```php
class calculator extends Sphp\tools\BasicApp {
    private $frtMain = null;

    public function onstart(){
        // create Front File Object
        $this->frtMain = new FrontFile(
            $this->mypath."/fronts/calculator_main.front"
        );
    }

    // URL = calculator.html handle by this
    public function page_new(){
        // enable FrontFile Object rendering
        $this->setFrontFile($this->frtMain);
    }
	
    // URL = calculator-calc.html handle this method
    public function page_event_calc($evtp){
        // read posted Components Values
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
<input id="numa" runat="server" type="text" placeholder="Number1" fui-setNumeric="" fun-submitAJAX="keyup,|##{getEventURL('calc')}#,|numb,sltop" />
<input id="numb" runat="server" type="text" placeholder="Number2" fui-setNumeric="" fun-submitAJAX="keyup,|##{getEventURL('calc')}#,|numa,sltop" />
<select id="sltop" runat="server" 
fun-submitAJAX="change,|##{getEventURL('calc')}#,|numa,numb" 
fun-setOptions="+,-"></select>
```

## 3️⃣ Register App File with SartajPHP reg.php

```php
// register Appgate=calculator So Browser URL=calculator.html
registerApp("calculator",__DIR__ ."/apps/calculator.app");
```
