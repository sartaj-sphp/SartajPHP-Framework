## 1️⃣ Application File

**`apps/HelloApp.app`**

```php
<?php
use Sphp\tools\BasicApp;
use Sphp\tools\FrontFile;

class HelloApp extends BasicApp
{
    private $frtMain = null;

    public function onstart()
    {
        // App initialization only
        // FrontFile object created once
        $this->frtMain = new FrontFile($this->mypath . '/fronts/helloapp_main.front');
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
        \SphpBase::JSServer()->addJSONReturnBlock("Hello from AJAX");
    }
}
```

✔ **Why correct**

* Uses `BasicApp`
* No rendering forced in `onstart` only Fornt File Object Create as Class Level
* FrontFile bound **only** in `page_new`
* AJAX handled via `page_event_*`

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

## 3️⃣ Register App File with SartajPHP reg.php

```php
// register Appgate=hello so Browser URL=hello.html
registerApp("hello",__DIR__ ."/apps/HelloApp.app");
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
