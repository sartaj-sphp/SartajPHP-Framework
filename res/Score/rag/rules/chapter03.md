# Chapter 03 – FrontFile Runtime Syntax & Rules

## 3.0 FrontFile Organization Rule

Each App should place its related FrontFiles inside a `fronts` folder located
in the **same parent directory as the App class**.

This provides:

* Clear App → FrontFile ownership
* Predictable filesystem resolution
* Easy grouping of related Apps and views

For large projects:
apps/
  blog/
    BlogApp.php
    fronts/
      index.front
      view.front

For small projects:
apps/
  IndexApp.php
  ChatApp.php
  fronts/
    index.front
    chat.front

## 3.1 Purpose of FrontFile

`FrontFile` defines the **runtime execution layer** of SartajPHP. It allows HTML to participate in server-side execution through **runtime attributes**, without writing PHP directly inside templates.

FrontFile is responsible for:

* Parsing HTML at runtime
* Detecting runtime attributes
* Creating and managing Components
* Executing fusion attributes
* Coordinating rendering with the App

A FrontFile is **created during App startup** and **assigned during PageEvent execution**.

```php
class index extends Sphp\tools\BasicApp{
  public function onstart(){
      $this->frtMain = new FrontFile(
          $this->mypath . "/fronts/index_main.front"
      );
  }

  public function page_new(){
      $this->setFrontFile($this->frtMain);
  }
}
```

Apps access FrontFiles using $this->mypath, which always resolves to the App’s parent directory.
Calling `setFrontFile()` selects and enables the FrontFile for rendering,
but actual rendering occurs during the App render phase.
Calling `showNotFrontFile()` disables the selected FrontFile.
Calling `showFrontFile()` re-enables the selected FrontFile.
---

## 3.2 Reserved Path Keywords in FrontFile

Reserved path keywords are **not PHP variables**. They are resolved **only inside value of Runtime Tag attributes** and only inside FrontFile.

| Keyword      | Resolves To                               | App Equivalent                                      |
| ------------ | ----------------------------------------- | --------------------------------------------------- |
| `mypath`     | Filesystem path of current FrontFile      | $this->frtMain->mypath                              |
| `myrespath`  | Public URL of current FrontFile           | $this->frtMain->myrespath                           |
| `slibpath`   | Filesystem path of `res\Slib` Folder      | SphpBase::sphp_settings()->slib_path                |
| `slibrespath`| Public URL of `res\Slib` resources        | SphpBase::sphp_settings()->slib_res_path            |
| `phppath`    | Filesystem path of global `res` directory | SphpBase::sphp_settings()->php_path                 |
| `respath`    | Public URL of global `res` directory      | SphpBase::sphp_settings()->res_path                 |
| `components` | Filesystem path of `res/components`       | SphpBase::sphp_settings()->php_path . "/components" |

These keywords **do not exist in PHP scope** and cannot be accessed from App code.

**Example – use Reserved keywords in Component Runtime Tag**

```html
<div id="paglist" runat="server" path="slibpath/comp/data/Pagination.php" dtable="princategory"  fun-setFieldNames="aname,atype,price,des" >

</div>
```

---

## 3.3 Runtime Tags

A **Runtime Tag** is an HTML tag processed by FrontFile at runtime.

HTML tags are classified as:

* **Static Tags** – ignored by FrontFile
* **Runtime Tags** – processed due to runtime attributes

---

## 3.4 Runtime Attributes

Runtime attributes activate server-side behavior in FrontFiles.

These attributes determine **how FrontFile treats a tag at runtime**.

### Core Runtime Attributes

* `runat="server"`
* `runas="..."`
* `runcb="true"`

---

### Runtime Attribute Classification

| Attribute        | Creates Component | Creates PHP Object (Component) | Purpose                     |
| ---------------- | ---------------   | ------------------------------ | --------------------------- |
| `runat="server"` | Yes               | Yes (Component)                | Full server-side behavior   |
| `runas="..."`    | No                | No                             | Rendering transformation    |
| `runcb="true"`   | No                | No                             | Callback-based layout logic |

---

## 3.5 `runat="server"`

`runat="server"` converts an HTML tag into a **Component Runtime Tag**.

Effects:

* A `Component` object is created
* The HTML tag as a `Sphp\tools\NodeTag' Object is bound to that Component (`$this->element`)
* Fusion attributes become active
* The Component participates in lifecycle events
* Component can enable,disable and change HTML tag and it's children output

### Helper Attributes for `runat="server"`

These helper attributes are **only applicable when `runat="server"` is present**.
They control **Component identity, loading, binding, and behavior**, but **do not execute logic by themselves**.
Helper attributes **do not create runtime behavior by themselves**.

| Attribute  | Required | Purpose                  | Description                                                                                               |
| ---------- | -------- | ------------------------ | --------------------------------------------------------------------------------------------------------- |
| `id`       | ✅ Yes    | Component Identity       | Defines the **Component name** and the **PHP object variable name**. Must be unique within the FrontFile. |
| `path`     | No       | Component Class Path     | Filesystem path to the Component PHP class file. Used when Component is not in default load path.         |
| `pathres`  | No       | Component Resource URL   | Public browser URL of the Component’s resource folder (JS, CSS, images).                                  |
| `phpclass` | No       | Component Class Name     | Explicit PHP class name to instantiate for the Component.                                                 |
| `version`  | No       | Component Version        | Version identifier used for cache control and compatibility handling.                                     |
| `dtable`   | No       | Database Table Binding   | Binds the Component to a database table name for data-driven operations.                                  |
| `dfield`   | No       | Database Field Binding   | Binds the Component to a specific database field within `dtable`.                                         |
| `fun-*`    | No       | Fusion Method Binding    | Calls Component methods during **parse or execution phase** with deferred values.                         |
| `fui-*`    | No       | Fusion UI Initialization | Calls Component methods during **parse phase only** for static or initial setup.                          |
| `fur-*`    | No       | Fusion Render Execution  | Calls Component methods during **render phase only** with dynamic values.                                 |

---

### Important Rules

* `id` is **mandatory** — without it, a Component **cannot be created**
* Helper attributes:

  * ❌ Do not execute logic independently
  * ✅ Are **read during Component initialization**
* Fusion attributes:

  * Are parsed by **FrontFile**
  * Invoke **Component methods**
  * Respect parse vs render execution phases
* These attributes are **invalid without `runat="server"`**

---

### Summary (Model-Friendly)

> `runat="server"` creates a **Component**
> Helper attributes **configure the Component**
> Fusion attributes **invoke Component behavior**

---

## 3.6 `runas="..."`

`runas` modifies **how a Runtime Tag is rendered or executed**, without creating a Component.

Rules:

* Does **not** create a Component
* Cannot be combined with `runat="server"`
* Behavior depends on `runas` value

### Common `runas` Behaviors

| runas Value   | Applicable Tags | Purpose                 |
| ------------- | --------------- | ----------------------- |
| `filelink`    | link, script    | Resource relocation     |
| `holder`      | any             | Dynamic placeholder     |
| `jsfunction*` | script          | JS generation & binding |
| custom        | any             | Semantic tag mapping    |

Unknown values are treated as **HTML tag mappings**.
Each `runas` value may support **different helper attributes**.
Only `renderonce` is **globally supported** by all `runas` values.

---

## 3.6.1 Global Helper Attribute – `renderonce`

`renderonce` controls **browser-level output delivery**, not server execution frequency.

It is evaluated **per browser session and request type**, not per FrontFile execution.

### Definition

| Helper Attribute    | Applies To         | Purpose                                                                                                 |
| ------------------- | ------------------ | ------------------------------------------------------------------------------------------------------- |
| `renderonce="true"` | All `runas` values | Ensures the generated output is delivered **only once to the browser**, across subsequent AJAX requests |

---

### Runtime Behavior Rules (Authoritative)

| Request Type                   | Behavior when `renderonce="true"`                         |
| ------------------------------ | --------------------------------------------------------- |
| Initial **GET request**        | Output is **always sent** (full page: master + FrontFile) |
| Subsequent **AJAX requests**   | Output is **not sent again**                              |
| `renderonce="false"` (default) | Output is sent on **every execution and request**         |

---

### Important Notes

* `renderonce` **does not disable execution**
* Code **still runs on the server**
* Only **browser output delivery** is suppressed after the first response
* Used to prevent duplicate:

  * CSS includes
  * JavaScript functions
  * Global JS code blocks
  * Resource injections

---

### Typical Use Cases

* JavaScript function definitions
* Global JS libraries
* CSS file links
* One-time layout wrappers
* Framework-managed script injection

---

### What `renderonce` Is NOT

* ❌ Not a cache mechanism
* ❌ Not a server execution guard
* ❌ Not related to FrontFile parsing
* ❌ Not related to Component lifecycle

---

### Mental Model (For Developers & Models)

> **renderonce controls “what the browser receives again”, not “what the server runs again”.**

This distinction is critical when working with **AJAX-heavy applications**.

---

### Final Rule Summary

* `renderonce` is **request-aware**
* First full-page response → always rendered
* AJAX responses → suppressed if `renderonce="true"`
* Applies equally to all `runas` behaviors

---

## 3.6.2 Helper Attributes – Overview Table

| Helper Attribute | Used With `runas` | Purpose                                                |
| ---------------- | ----------------- | ------------------------------------------------------ |
| `renderonce`     | all               | Prevent duplicate output delivery across AJAX requests |
| `data-comp`      | `holder`          | Target a specific Component                            |
| `data-prop`      | `holder`          | Read a property value                                  |
| `function`       | jsfunction*       | JavaScript function name                               |
| `functionpara`   | jsfunction        | JavaScript function parameters                         |
| `binder`         | jsfunctionbnd*    | jQuery selector to bind event                          |
| `listenevent`    | jsfunctionbnd*    | JavaScript event name                                  |
| `handler`        | jsfunctionbnds    | Server-side PageEvent parameter                        |

---

## 3.6.3 `runas` Values and Their Helper Attributes

### 1️⃣ `runas="filelink"`

**Applies to:** `<link>`, `<script>`

**Purpose:**
Moves resource references to their correct semantic location for clean HTML output.

* CSS files → `<head>`
* JS files → bottom of `<body>`

**Helper Attributes:**

| Attribute    | Purpose                                                |
| ------------ | ------------------------------------------------------ |
| `renderonce` | Prevent duplicate output delivery across AJAX requests |

This allows developers to write assets **anywhere in FrontFile**, while the framework produces optimized output.

---

### 2️⃣ `runas="holder"`

**Applies to:** Any HTML tag

**Purpose:**
Acts as a **dynamic placeholder** resolved at runtime.

**Helper Attributes:**

| Attribute   | Purpose          |
| ----------- | ---------------- |
| `data-comp` | Target Component |
| `data-prop` | Target property  |

#### Resolution Rules (Authoritative)

| Used Attributes           | Runtime Behavior                                     |
| ------------------------- | ---------------------------------------------------- |
| `data-comp` + `data-prop` | Display **Component property value**                 |
| `data-prop` only          | Display **App property value**                       |
| `data-comp` only          | Trigger **Component `onholder` event**, pass NodeTag |
| none                      | Trigger **App `onholder` event**, pass NodeTag       |

This makes `holder` a **bridge between FrontFile and App/Component state**.

---

### 3️⃣ `runas="jsfunctionbnds"`

**Applies to:** `<script>`

**Purpose:**
Generate a JavaScript function, bind it to a client-side event, and **send AJAX request to server**.

**Helper Attributes:**

| Attribute     | Purpose                                                |
| ------------- | ------------------------------------------------------ |
| `renderonce`  | Prevent duplicate output delivery across AJAX requests |
| `function`    | JavaScript function name                               |
| `binder`      | jQuery selector                                        |
| `listenevent` | JavaScript event                                       |
| `handler`     | Server-side PageEvent parameter (`$evtp`)              |

#### Execution Flow

1. Framework creates JS function via `addHeaderJSFunction`
3. Script tag content becomes function body
3. Function is bound to `binder` + `listenevent`
4. On execution, AJAX request is sent using `getURL`
5. `handler` value is sent as `$evtp` to server

Used for **client → server event bridging**.

---

### 4️⃣ `runas="jsfunctionbnd"`

**Applies to:** `<script>`

**Purpose:**
Same as `jsfunctionbnds`, **without server communication**.

**Helper Attributes:**

| Attribute     | Purpose                                                |
| ------------- | ------------------------------------------------------ |
| `renderonce`  | Prevent duplicate output delivery across AJAX requests |
| `function`    | JavaScript function name                               |
| `binder`      | jQuery selector                                        |
| `listenevent` | JavaScript event                                       |

All logic remains **client-side only**.

---

### 5️⃣ `runas="jsfunction"`

**Applies to:** `<script>`

**Purpose:**
Create a standalone JavaScript function.

**Helper Attributes:**

| Attribute      | Purpose                                                |
| -------------- | ------------------------------------------------------ |
| `function`     | Function name                                          |
| `functionpara` | Parameter list                                         |
| `renderonce`   | Prevent duplicate output delivery across AJAX requests |

**Work:**

* Script tag content becomes the **function body**
* No automatic execution or binding

---

### 6️⃣ `runas="jsfunctioncode"`

**Applies to:** `<script>`

**Purpose:**
Insert script content **into an existing JavaScript function**.

**Helper Attributes:**

| Attribute    | Purpose                                                |
| ------------ | ------------------------------------------------------ |
| `function`   | Target function name                                   |
| `renderonce` | Prevent duplicate output delivery across AJAX requests |

**Example Use:**

```html
<script runas="jsfunctioncode" function="ready">
   console.log("Ready!");
</script>
```

This inserts code into the framework-managed `ready()` function.

---

### 7️⃣ `runas="jscode"`

**Applies to:** `<script>`

**Purpose:**
Insert script content as **global JavaScript code**, managed by the framework.

**Helper Attributes:**

| Attribute    | Purpose                                                |
| ------------ | ------------------------------------------------------ |
| `renderonce` | Prevent duplicate output delivery across AJAX requests |

Used to keep HTML clean while still allowing dynamic JS generation.

---

### 8️⃣ Custom `runas` Tag Mapping

If `runas` value **does not match any predefined behavior**, it is treated as a **target HTML tag name**.

**Purpose:**
Improve FrontFile readability using semantic or custom tags.

**Example:**

```html
<panel1 runas="div">
   Content
</panel1>
```

**Browser Output:**

```html
<div>
   Content
</div>
```

This allows **custom tags in FrontFile** while generating valid HTML.

---

## 3.6.4 Key Rules (Model-Critical)

* `runas` **never creates a Component**
* Helper attributes are **context-dependent**
* `renderonce` is universally supported
* Unknown `runas` values act as **HTML tag mappings**
* `runas` and `runat="server"` **cannot be combined**

---

## 3.7 `runcb="true"` — Code Block Runtime Processing

`runcb="true"` enables **Code Block–based runtime manipulation** of an HTML tag using **predefined reusable logic blocks**.

Code blocks allow **layout, class, wrapper, and structural transformations** **without creating a Component** and **without writing PHP inside FrontFile**.

---

## 3.7.1 Code Block Attributes

When `runcb="true"` is present, FrontFile scans for attributes with the prefix:

```
sphp-cb-*
```

### Syntax

```html
<tag runcb="true" sphp-cb-blockName="arg1,arg2,...">...</tag>
```

* `blockName` → Registered code block name
* Attribute value → Comma-separated argument list
* Arguments are passed **as array** to the code block callback

Multiple code blocks **can be applied to the same tag**.

---

## 3.7.2 Code Block Helper Attribute Table

| Helper Attribute Prefix | Applies To | Purpose                                       |
| ----------------------- | ---------- | --------------------------------------------- |
| `sphp-cb-*`             | Any tag    | Invoke a registered Code Block with arguments |

> `runcb="true"` is the **only required runtime attribute** for code block execution.

---

## 3.7.3 What Is a Code Block?

A **Code Block** is a reusable runtime transformation registered globally or per project using the `SphpCodeBlock` API.

* Code Blocks:

  * Do **not** create Components
  * Do **not** create PHP objects per tag
  * Operate directly on the **NodeTag element**
* Designed for:

  * Layout control
  * Class injection
  * Wrapper generation
  * UI consistency
  * Declarative FrontFile design

---

## 3.7.4 Code Block Registration (Server Side)

Code blocks are registered in:

* Global `sphpcodeblock.php`
* Or Project-level `sphpcodeblock.php`

### Example: Registering a Code Block

```php
SphpCodeBlock::addCodeBlock(
  'border',
  function($element, $args, $lst1){
    if(isset($args[0])){
      if(is_numeric($args[0])){
        $element->appendAttribute('class', ' border border-' . $args[0]);
      }else{
        $element->appendAttribute('class', ' border-' . $args[0]);
      }
    }else{
      $element->appendAttribute('class', ' border');
    }

    if(isset($args[1])){
      $element->appendAttribute('class', ' border-' . $args[1]);
    }else{
      $element->appendAttribute('class', ' border-primary');
    }
  }
);
```

---

## 3.7.5 Using Code Blocks in FrontFile

### Example FrontFile Usage

```html
<div runcb="true" sphp-cb-border="4,white">
    text data
</div>
```

### Argument Mapping

| Argument Index | Value   |
| -------------- | ------- |
| `$args[0]`     | `4`     |
| `$args[1]`     | `white` |

---

## 3.7.6 Multiple Code Blocks on Same Tag

You may apply **multiple code blocks** to a single tag:

```html
<div runcb="true"
     sphp-cb-border="3,primary"
     sphp-cb-padding="2"
     sphp-cb-shadow="sm">
    Content
</div>
```

Execution order follows **attribute parsing order**.

---

## 3.7.7 Code Block Execution Flow

When FrontFile encounters a tag with `runcb="true"`:

```
1. FrontFile detects runcb="true"
3. Scan all attributes with prefix sphp-cb-*
3. For each code block attribute:
   ├─ Extract block name
   ├─ Parse argument list
   ├─ Resolve block definition
   ├─ Invoke callback($element, $args, $context)
4. NodeTag is modified (classes, wrappers, structure)
5. Modified NodeTag participates in normal render flow
```

---

## 3.7.8 Code Block Resource Loading

On first use of any Code Block:

* `sphpcodeblocks.css` is automatically injected
* Injection respects:

  * `renderonce="true"`
  * Request type (GET vs AJAX)

This guarantees **clean output** and **no duplicate resource delivery**.

---

## 3.7.9 Rules & Constraints

* `runcb="true"`:

  * ❌ Does NOT create a Component
  * ❌ Does NOT bind lifecycle events
  * ✅ Can be combined with `renderonce`
* Code blocks:

  * Can modify:

    * Classes
    * Wrappers
    * Inner HTML boundaries
  * Cannot access Component APIs
* Multiple `sphp-cb-*` attributes are allowed
* If a block name is not registered → silently ignored (recommended)

---

## 3.7.10 When to Use `runcb` vs `runat`

| Use Case                              | Recommended      |
| ------------------------------------- | ---------------- |
| Structural/layout transformation      | `runcb="true"`   |
| Reusable UI patterns                  | `runcb="true"`   |
| Server-side state, events, validation | `runat="server"` |
| JS/CSS resource management            | `runas`          |

---

## 3.8 Fusion Attributes

Fusion attributes of FrontFile call **Component methods**.
Fusion attributes are parsed during FrontFile parsing,
but executed according to their defined phase.

Fusion attributes are valid **only on Component Runtime Tags**.

### Fusion Attribute Prefixes

| Prefix | Execution Phase | Purpose               |
| ------ | --------------- | --------------------- |
| `fun-*` | init / render   | Deferred execution    |
| `fui-*` | init only       | Immediate execution   |
| `fur-*` | render only     | Render-time execution |

Fusion attributes are ignored on non-Component tags.
Fusion attributes (fun-*, fui-*, fur-*) are the only bridge between FrontFiles and Components.
They map exclusively to fu_* methods and define both what is callable and when it executes.
Fusion attributes:

* Apply **only to Components**
* Are parsed by FrontFile
* Invoke methods on Component objects

---

## 3.9 Runtime Rules Summary

* Runtime behavior is attribute-driven
* Only `runat="server"` creates Components
* Fusion attributes apply only to Components
* `runas` and `runcb` do not create objects
