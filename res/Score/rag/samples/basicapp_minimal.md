## 1️⃣ Application' Gate File

**`apps/HelloApp.gate.php`**

```php
<?php
use Sphp\tools\BasicGate;
use Sphp\tools\FrontFile;

class HelloApp extends BasicGate
{
    private $frtMain = null;

    public function onstart()
    {
        // Gate initialization only
        // FrontFile object created from __DIR__ . "/fronts/helloapp_main.front"
        $this->frtMain = new FrontFile('main');
    }

    /**
     * Default page request: index.html → page_new
     */
    public function page_new()
    {
        $this->setFrontFile($this->frtMain);
    }

    /**
     * AJAX example
     */
    public function page_event_getMessage($evtp)
    {
		// $this->JSServer == SphpBase::JSServer()
        $this->JSServer->addJSONReturnBlock("Hello from AJAX");
    }
}
```

✔ **Why correct**

* Uses `BasicGate`
* No rendering forced in `onstart` only Fornt File Object Create as Class Level
* FrontFile bound **only** in `page_new`
* AJAX handled via Page Event `page_event_*`

---

## 2️⃣ FrontFile

**`fronts/helloapp_main.front`**

```html
<title id="title1" runat="server">Hello SartajPHP</title>

<h1>Hello SartajPHP</h1>

<input
    id="txt1"
    type="text"
    value="North"
    runat="server"
/>

<button id="btnCall">AJAX Call</button>

<script runas="jsfunctioncode" function="ready">
$("#btnCall").on("click", function () {
    getAJAX(
        "##{getEventURL('getMessage')}#",
        {},
        false,
        function (ret) {
            alert(ret);
        }
    );
});
</script>

```

### ✔ Why This Is Correct

* ✅ No `html`, `head`, or `body` tags
* ✅ `.front` file
* ✅ Valid HTML + JS
* ✅ Expression tag used correctly
* ✅ Built-in AJAX helper (`getAJAX`)
* ✅ No fake attributes or PHP code

---

## 3️⃣ Register Gate File with SartajPHP reg.php

```php
// register Gate=hello so Browser URL=hello.html
registerGate("hello",__DIR__ ."/apps/HelloApp.gate.php");
```


## What This Sample Proves

| Rule                                  | Status |
| ------------------------------------- | ------ |
| FrontFile rendered only when required | ✅      |
| Event-driven (not controller-style)   | ✅      |
| Expression tags optional              | ✅      |
| AJAX via `page_event_*`               | ✅      |
| No invented lifecycle                 | ✅      |

---


## 🔒 Canonical Lifecycle (Final)

```
onstart        → setup only
page_new       → bind FrontFile
page_event_*   → logic / AJAX
```
