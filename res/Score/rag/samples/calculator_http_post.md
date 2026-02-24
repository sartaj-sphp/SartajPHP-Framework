# Calculator HTTP Submit, No AJAX (BasicGate)

## 1️⃣ Application File

**`apps/uucalculatorGate.php`**

```php
class calculator extends Sphp\tools\BasicGate {
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
        $a = (int)$this->Client->post("numa"); 
        $b = (int)$this->Client->post("numb");
        $op = $this->Client->post("sltop");
        $res = 0;
        if($op=="+") $res = $a + $b;
        if($op=="-") $res = $a - $b;
        $this->frtMain->result->setInnerHTML($res);
        $this->setFrontFile($this->frtMain);
    }

}
```

## 2️⃣ FrontFile

**`fronts/calculator_main.front`**

```html
<div id="result" runat="server"></div>
<form  action="##{getEventURL('calc')}#" method="post" enctype="multipart/form-data">
    <input name="numa" type="number" />
    <input name="numb" type="number" />
    <select name="sltop">
        <option value="+">+</option>
        <option value="-">-</option>
    </select>
    <input type="submit" value="Calculate" />
</form>
```

## 3️⃣ Register Gate File with SartajPHP reg.php

```php
// register Gate=calculator So Browser URL=calculator.html
uuregisterGate("calculator",__DIR__ ."/apps/uucalculatorGate.php");
```
