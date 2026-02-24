# 📘 Chapter 07 — Canonical SartajPHP Application Structure

This chapter defines the **only valid way** to write a SartajPHP Application.

Any deviation is incorrect.

---

## 7.1 What Is an Application in SartajPHP

A SartajPHP Application:

* Is **NOT** an MVC controller
* Is **NOT** a router
* Is **NOT** a request parser
* Is a **lifecycle-driven execution unit**

An Application:

* Owns lifecycle events
* Coordinates Components
* Binds to a FrontFile
* Responds to Page Events

---

## 7.2 Valid Application Base Classes

An Application **MUST** extend exactly one of the following:

| Gate Type   | Parent Class            |
| ---------- | ----------------------- |
| Web Gate    | `Sphp\tools\BasicGate`   |
| Native Gate | `Sphp\tools\NativeGate`  |
| CLI Gate    | `Sphp\tools\ConsoleGate` |

❌ Extending any other class is invalid
❌ `Controller`, `App`, `Core\App`, or invented classes are invalid

---

## 7.3 Mandatory Application Lifecycle Methods

A valid Application **may** implement the following lifecycle methods:

```php
onstart()
onready()
onrun()
```

### Purpose

| Method      | Purpose                                           |
| ----------- | ------------------------------------------------- |
| `onstart()` | Bind FrontFile, preload configuration             |
| `onready()` | Application is initialized, safe to prepare state |
| `onrun()`   | Application execution phase                       |

❌ Applications must NOT invent lifecycle methods
❌ Lifecycle methods are **optional but standardized**

---

## 7.4 FrontFile Binding (Mandatory Pattern)

A Web Application **MUST** bind a FrontFile.

### Rules

* FrontFile extension is **`.front`**
* Binding occurs in `onstart()`
* FrontFile is **NOT PHP**

### Canonical Pattern

```php
use Sphp\tools\BasicGate;

class index extends BasicGate {
    private $frtMain = null;
    // -----------------------------
    // Application life cycle events onstart, onready, onrun, onrender
    // -----------------------------

        /**
         * onstart=1
         * Gate Life Cycle Event
         * override this event handler in your application to handle it.
         * trigger when application start
         */
        public function onstart() {
            echo "app start <br />"; 
        }

        /**
         * onready=4
         * Gate Life Cycle Event
         * override this event handler in your application to handle it.
         * trigger after FrontFile Initialization and ready to Run App.
         */
        public function onready() {
            echo "Gate is ready to process <br />";
        }

        /** 
         * onrun=5
         * Gate LifeCycle Event
         * override this event handler in your application to handle it.
         * trigger when application run after ready event and before trigger any PageEvent
         */
        public function onrun() {
            echo "Gate is Ready to Process PageEvents <br />";
        }
        
        /** 
         * onrender=10
         * Gate Life Cycle Event
         * override this event handler in your application to handle it.
         * trigger when application render after run FrontFile but before start master
         * file process. You can't manage FrontFile output here but you can replace FrontFile
         * output in SphpBase::$dynData or change master file or add front place for master filepath
         */
        public function onrender() {
            echo "Trigger At Last when Gate Ready to render <br />";            
        }

    // -----------------------------
    // Front File events onfrontinit, onfrontprocess
    // -----------------------------
        /**
         * onfrontinit=2
         * Only Trigger if Front File is used with App
         * Trigger After FrontFile Parse Phase, Component oninit and oncreate 
         * Events and before Components onaftercreate event. Trigger for 
         *  each Front File use with BasicGate
         * override this event handler in your application to handle it.
         * @param \Sphp\tools\FrontFile $frontobj
         */
        public function onfrontinit($frontobj) {
            echo "Front file ". $frontobj->getFilePath() ." is initialize <br />";            
        }

        /** 
         * onfrontprocess=3
         * Only Trigger if Front File is used with App
         * Trigger after onaftercreate Event of Component and before 
         * BasicGate onready and onrun Events 
         * and also before onappevent Event of Component 
         * override this event handler in your application to handle it.
         * @param \Sphp\tools\FrontFile $frontobj
         */
        public function onfrontprocess($frontobj) {
            echo "Front file ". $frontobj->getFilePath() ." is initialized and Ready to Process <br />";              
        }

    // -------------------------------------
    // PageEvent Database Handling Events delete, view, insert, update, submit
    // -------------------------------------
        /** 
         * PageEvent Delete
         * Trigger only when Browser access URL is matched with PageEvent
         * Trigger only one PageEvent per request.
         * Trigger after onrun Event and before on render.
         * override this event handler in your application to handle it.
         * trigger when browser get (url=index-delete.html)
         * where index is Gate of application and application path is in reg.php file 
         */
        public function page_delete() {
            echo "you open in browser " . getEventURL("delete",1) .
                " to delete record with id=1";

            // Example DB operation:
            // $this->dbEngine->executeQueryQuick("SELECT FROM tbl1 WHERE id=1");
            
        }

        /** 
         * PageEvent View
         * Trigger only when Browser access URL is matched with PageEvent
         * Trigger only one PageEvent per request.
         * Trigger after onrun Event and before on render.
         * override this event handler in your application to handle it.
         * trigger when browser get (url=index-view-19.html)
         * where index is Gate of application and application path is in reg.php file 
         * view = event name 
         * 19 = recid of database table or any other value.
         */
        public function page_view() {
            // Auto-fill components from database and send page to browser
            $this->page->viewData($this->frtMain->getComponent('frmcustomer'));
            $this->setFrontFile($this->frtMain);            
        }

        /** 
         * PageEvent Submit
         * Trigger only when Browser access URL is matched with PageEvent
         * Trigger only one PageEvent per request.
         * Trigger after onrun Event and before on render.
         * override this event handler in your application to handle it.
         * trigger when browser post Filled Form Components (url=index.html)
         * where index is Gate of application and application path is in reg.php file 
         */
        public function page_submit() {
            echo "you submit form to " . getThisGateURL();
        }

        /** 
         * PageEvent Insert
         * Trigger only when Browser access URL is matched with PageEvent
         * Trigger only one PageEvent per request.
         * Trigger after onrun Event and before on render.
         * override this event handler in your application to handle it.
         * trigger when browser post Filled Empty Form Components (url=index.html)
         * where index is Gate of application and application path is in reg.php file 
         */
        public function page_insert() {
            echo "you open in browser " . getThisGateURL() . 
                " and form submit to " . getThisGateURL() . " url";
            
        }

        /** 
         * PageEvent Update
         * Trigger only when Browser access URL is matched with PageEvent
         * Trigger only one PageEvent per request.
         * Trigger after onrun Event and before on render.
         * override this event handler in your application to handle it.
         * trigger when browser post Edited Form Components Which Filled with 
         * \SphpBase::page()->viewData() (url=index.html) 
         * from database with view_data function
         * where index is Gate of application and application path is in reg.php file 
         */
        public function page_update() {
            echo "you open in browser " . getEventURL("view",1) .
                " and edited form submit to " . getThisGateURL() . " url";
            
        }

    // -------------------------------------
    // PageEvent Default Landing Event New
    // -------------------------------------
        /** 
         * PageEvent New
         * Trigger only when Browser access URL is matched with PageEvent
         * Trigger only one PageEvent per request.
         * Trigger after onrun Event and before on render.
         * override this event handler in your application to handle it.
         * trigger when browser get URL (url=index.html) first time
         * where index is Gate of application and application path is in reg.php file 
         */
        public function page_new() {
            echo "you open in browser " . getThisGateURL();            
        }

    // -------------------------------------
    // PageEvent Custom User-defined Events, Create as many as required
    // -------------------------------------
        // URL: index-page-myevent1.html
        public function page_event_myevent1($evtp){
            // getEventURL("myevent1")
        }

        public function page_event_myevent2($evtp){
            // getEventURL("myevent2")
        }

}
```

❌ `.php`, `.html`, `.tpl` FrontFiles are invalid
❌ FrontFile creation outside `onstart()` is invalid

---

## 7.5 Page Events (Required for Interaction)

User actions and AJAX calls **MUST** be handled via Page Events.

### Syntax

```php
public function page_event_<name>($evtp) {}
```

### Example

```php
public function page_event_calc($evtp) {
    // logic
}
```

❌ Direct request parsing is forbidden
❌ `$_GET`, `$_POST`, `$_REQUEST` inside FrontFile is forbidden

---

## 7.6 Absolute Prohibitions (AI-SAFE)

An Application **MUST NEVER**:

* Call `render()`
* Output HTML
* Read request manually
* Act like MVC Controller
* Invent routing logic
* Embed UI logic

