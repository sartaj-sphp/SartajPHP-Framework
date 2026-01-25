# 📘 Chapter 09 — Canonical Minimal Reference Applications

This chapter provides **gold-standard examples**.
Models **MUST imitate these patterns exactly**.

---

## 9.1 Minimal “Hello World” Application

### Application Code (`apps/Hello.app`)

```php
use Sphp\tools\BasicApp;
use Sphp\tools\FrontFile;

class Hello extends BasicApp
{
    private $frtMain = null;

    public function onstart()
    {
        // App initialization only
        // FrontFile object created once
        // Name of Front File "App Class Name" + "_" + "main" + ".front"
        // store inside fronts folder inside App folder
        $this->frtMain = new FrontFile($this->mypath . '/fronts/hello_main.front');
    }

    /**
     * Default page request: index.html → page_new
     * need register App File with SartajPHP inside reg.php 
     * use code registerApp("index",__DIR__ ."/apps/Hello.app");
     * index = Appgate = URL = index.html or index-*.html
     */
    public function page_new()
    {
        $this->setFrontFile($this->frtMain);
    }

}
```

---

### FrontFile (`apps/fronts/hello_main.front`)

```html
<h1>Hello SartajPHP</h1>
```

---

## 9.2 Application with Page Event

### Application

```php
use Sphp\tools\BasicApp;

class index extends BasicApp {

    private $frtMain = null;

    public function onstart()
    {
        // App initialization only
        // FrontFile object created once
        // Name of Front File "App Class Name" + "_" + "main" + ".front"
        // store inside fronts folder inside App folder
        $this->frtMain = new FrontFile($this->mypath . '/fronts/index_main.front');
    }

    /**
     * Default page request: index.html → page_new
     * need register App File with SartajPHP inside reg.php 
     * use code registerApp("index",__DIR__ ."/apps/index.app");
     * index = Appgate = URL = index.html or index-*.html
     */
    public function page_new()
    {
        // set Front File to send to Browser
        $this->setFrontFile($this->frtMain);
    }
    /**
     * PageEvent = ping Handler
     * URL = index-ping.html or index-ping-evtp.html
     */
    public function page_event_ping($evtp) {
        echo "pong";
    }
}
```

---

### FrontFile

```html
<a href="#{$this->getEventURL('ping')}#">
    Click
</a>
```

---

## 9.3 Minimal Component Usage

```html
<input id="txtname" runat="server"
       type="text"
       fui-setDefaultValue="Hello">
```

---

## 9.4 Reference Rules

* Always generate App + FrontFile together
* Never invent lifecycle methods
* Never mix PHP and FrontFile
* Never use `.php` as FrontFile
* Never assume MVC patterns
* When uncertain, **do less, not more**

