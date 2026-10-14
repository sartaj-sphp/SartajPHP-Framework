# AJAX Calculator with HTML only, No Components (BasicGate)

## 1️⃣ Application' Gate File

**`apps/calculator.gate.php`**

```php
class calculator extends Sphp\tools\BasicGate {

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
	
    // URL = calculator-calc.html handle this method
    public function page_event_calc($evtp){
        $a = (int)$this->Client->post("numa"); 
        $b = (int)$this->Client->post("numb");
        $op = $this->Client->post("sltop");
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
<form id="form2" action="##{getEventURL('calc','','calculator')}#">
<input id="numa" type="number" />
<input id="numb" type="number" />
<select id="sltop">
    <option value="+">+</option>
    <option value="-">-</option>
</select>
<input type="submit" value="Calculate" />
</form>
<script runas="jsfunctioncode" function="ready">
    $('#form2').on('submit', function(e){
        e.preventDefault();
        var url = $(this).attr('action');
        var data = {};
        data['numa'] = $('#numa').val();
        data['numb'] = $('#numb').val();
        data['sltop'] = $('#sltop').val();
        getURL(url, data);
     });
</script>
```

## 3️⃣ Register Gate File with SartajPHP reg.php

```php
// register Gate=calculator So Browser default URL=calculator.html
registerGate("calculator",__DIR__ ."/apps/calculator.gate.php");
```
