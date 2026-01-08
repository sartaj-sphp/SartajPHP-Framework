# AJAX Calculator with HTML only, No Components (BasicApp)

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
<form id="form2" action="##{getEventURL('calc')}#">
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

## 3️⃣ Register App File with SartajPHP reg.php

```php
// register Appgate=calculator So Browser URL=calculator.html
registerApp("calculator",__DIR__ ."/apps/calculator.app");
```
