# Chapter 04 – Rules to Write FrontFile (`*.front`)

This chapter defines **strict rules and best practices** for writing SartajPHP FrontFiles.
FrontFiles are **not plain HTML** — they are **event-aware UI definitions** that interact directly with Apps, Components, authentication, permissions, and server-side events.

Following these rules ensures:

* Predictable rendering
* Clean App–UI communication
* Secure output control
* Proper AJAX and WebSocket behavior
* High compatibility with SartajPHP engine

---

## 4.1 Always Use Components for Form Controls

**Rule:**
All form controls **must be written as Components**, not raw HTML inputs.

Direct use of raw HTML form controls is discouraged because:

* Components provide validation hooks
* Components support server-side state
* Components integrate with App events

---

## HTML Tag → Built-in Component Mapping Table

When an HTML tag is converted into a Component using `runat="server"`, SartajPHP automatically assigns the corresponding **Component PHP class** and internal file path.

This table documents the default mappings.

---

### Input Elements

| HTML Tag | type attribute | Component Class                |
| -------- | -------------- | ------------------------------ |
| `input`  | `text`         | `Sphp\comp\html\TextField`     |
| `input`  | `password`     | `Sphp\comp\html\TextField`     |
| `input`  | `hidden`       | `Sphp\comp\html\TextField`     |
| `input`  | `submit`       | `Sphp\comp\html\TextField`     |
| `input`  | `button`       | `Sphp\comp\html\TextField`     |
| `input`  | `email`        | `Sphp\comp\html\TextField`     |
| `input`  | `number`       | `Sphp\comp\html\TextField`     |
| `input`  | `date`         | `Sphp\comp\html\DateField`     |
| `input`  | `file`         | `Sphp\comp\html\FileUploader`  |
| `input`  | `checkbox`     | `Sphp\comp\html\CheckBox`      |
| `input`  | `radio`        | `Sphp\comp\html\Radio`         |

---

### Form & Selection Elements

| HTML Tag   | Component Class            |
| ---------- | -------------------------- |
| `form`     | `Sphp\comp\html\HTMLForm`  |
| `select`   | `Sphp\comp\html\Select`    |
| `textarea` | `Sphp\comp\html\TextArea`  |

---

### Display & Utility Elements

| HTML Tag | Component Class                |
| -------- | ------------------------------ |
| `image`  | `Sphp\comp\html\Img`           |
| `title`  | `Sphp\comp\html\Title`         |
| `alert`  | `Sphp\comp\html\DisplayError`  |

---

### FrontFile Composition Components

| HTML Tag        | Component Class                |
| --------------- | ------------------------------ |
| `include`       | `Sphp\comp\html\IncludeFront`  |
| `include_place` | `Sphp\comp\html\IncludePlace`  |

---

### Default Fallback

| HTML Tag            | Component Class  |
| ------------------- | ---------------- |
| Any unsupported tag | `Sphp\comp\Tag`  |

---

> Each Component may support additional Fusion attributes.
> Refer to the Component documentation for advanced behavior and event handling.
> ❗ Raw HTML form elements should only be used if **no server-side interaction is required**.

---

## 4.2 Convert HTML Tag to Component Using `runat="server"`

Any HTML tag can be converted into a **Component** by adding:

* `runat="server"`
* `id` attribute

### Example

```html
<input id="txtUsername" runat="server"  type="text" />
```

Once converted:

* The tag becomes controllable from App
* It participates in events
* Its value is available on server side

---

## 4.3 Always Use ID Prefixes for Components

**Rule:**
Every Component ID **must use a meaningful prefix**.

Prefixes allow:

* Automatic type detection
* Cleaner server-side code
* Consistent data handling

### Component ID Prefix Table

| Prefix | Component Type     | PHP Data Type |
| ------ | ------------------ | ------------- |
| `txt`  | TextBox            | string        |
| `pwd`  | PasswordBox        | string        |
| `eml`  | EmailBox           | string        |
| `num`  | NumberBox          | int / float   |
| `dat`  | DateBox            | string        |
| `txa`  | TextArea           | string        |
| `chk`  | CheckBox           | boolean       |
| `rad`  | Radio              | string        |
| `slt`  | DropDown           | string / int  |
| `btn`  | Button             | event         |
| `lbl`  | Label              | string        |
| `div`  | Holder / Container | mixed         |

### Example

```html
<input id="txtEmail" runat="server" type="text" fui-setEmail="" />
<input id="numAge" runat="server" type="text" fui-setNumeric="" />
<button id="btnSubmit">Submit</button>
```

---

## 4.4 Use `runas="holder"` for Runtime Content Placement

`runas="holder"` is used when an HTML tag must participate in **runtime content placement**, but does **not** need full Component behavior.

A holder tag allows SartajPHP to decide **what content appears inside the tag** and **how that content is generated**, while the **layout and structure remain defined in the FrontFile**.

`runas="holder"` does **not** create a server-side object and cannot be accessed later like a Component.

---

### 4.4.1 Which HTML Tags Can Be Holders

Only HTML tags that can contain **child nodes** should be used as holders:

* `div`
* `span`
* `section`
* `article`
* `header`
* `footer`
* `td`, `th`
* `li`

Self-closing or void tags **must not** be used as holders.

---

### 4.4.2 Design Question: What to Display, and Who Decides?

Before using `runas="holder"`, answer this question:

> **Who decides what content is displayed, and how it is rendered?**

This leads to two valid holder use cases.

---

### Case 1: FrontFile Controls Layout, Only InnerHTML Is Dynamic

If:

* **Layout and design are fixed**
* Only the **inner content** is dynamic
* You want to avoid expressions tags like:

  ```
  ##{$parentapp->test}#
  ```

Then use a holder to **inject property values as innerHTML**.

In this case:

* FrontFile controls **structure and styling**
* App or Component provides **data only**
* The holder reduces the need for expressions

**Result:**
Only `innerHTML` changes; the tag itself is static.

---

### Case 2: App or Component Controls the Entire Content

If:

* What to display **and** how to display it is decided at runtime
* The entire tag content must be generated dynamically

Then the holder tag is **passed to the `onholder` event**.

In this case:

* The FrontFile provides a placeholder node
* App or Component generates the complete output
* The original content is replaced during rendering

**Important limitations:**

* The output is generated **once per request**
* The holder cannot be updated or controlled later
* It is still **not as powerful as a Component**

---

### 4.4.3 Holder vs Component (Important Boundary)

| Feature                      | Holder (`runas="holder"`) | Component (`runat="server"`) |
| ---------------------------- | ------------------------- | ---------------------------- |
| Creates PHP object           | No                        | Yes                          |
| Controls innerHTML           | Yes                       | Yes                          |
| Controls full tag structure  | Limited (one-time)        | Yes                          |
| Accessible later from App    | No                        | Yes                          |
| Supports auth / permission   | No                        | Yes                          |
| Supports lifecycle & updates | No                        | Yes                          |

---

### 4.4.4 Holder Tags in Advanced Components

Some Components (e.g., **DataGrid**, **Pagination**) internally use **holder tags** to:

* Render field values
* Apply custom layouts
* Allow flexible HTML design inside repeating structures

In these cases:

* Holders are used to **place data**
* Components manage **iteration and logic**
* The FrontFile defines **visual structure**

Holder tags can also exist **outside Component child nodes**, allowing flexible layout composition.

---

### Summary

Use `runas="holder"` when:

* You need runtime content placement
* You want FrontFile-controlled layout
* You want to avoid expressions and PHP tags
* You need one-time dynamic rendering

If you need:

* Reusability
* Security control
* Lifecycle events
* Runtime updates

Then convert the tag into a **Component** instead.

---

## 4.5 Convert Tags to Components for Permission & Authentication Control

**Rule:**
If an element’s visibility depends on:

* User role as ADMIN,MEMBER or GUEST
* Authentication state
* Permission

Then it **must be converted to a Component**.

### Example: Admin-only UI

```html
<div id="divadmin1" runat="server" fur-setAuth="ADMIN">
  Admin Controls Here
</div>
```

If permission fails:

* The tag will **not render**
* Its content is completely removed from output

This ensures **true server-side security**, not CSS-based hiding.

---

## 4.6 Custom Tags Must Always Have Closing Tags

**Rule:**
Custom or framework-aware tags **must always be explicitly closed**.

### Correct

```html
<mytag></mytag>
```

### Incorrect

```html
<mytag />
```

This prevents:

* Parsing errors
* Component initialization failures

---

## 4.7 Avoid Whitespace in Sensitive Components

Some Components are **whitespace-sensitive**.

**Rule:**
If a Component does not contain content, **do not add spaces or newlines between tags**.

### Correct

```html
<span id="lblMessage" runat="server"></span>
```

### Incorrect

```html
<span id="lblMessage" runat="server">
</span>
```

Whitespace may be interpreted as output content.

---
## Expression Tag Standard (Official)

In SartajPHP FrontFiles, **PHP tags are not used**.

Instead, SartajPHP uses an **Expression Tag** syntax:

```text
##{ EXPRESSION }#
```

### Purpose

Expression tags are used to:

* Execute PHP helper functions
* Generate URLs
* Output dynamic values
* Keep FrontFiles HTML-safe and engine-parsable

---

## Correct Example Usage

### ✅ Correct (Expression Tag)

```html
<a href="##{ getAppURL('index') }#">Home</a>
<a href="##{ getEventURL('logout','','signin') }#">Logout</a>
```

### ❌ Incorrect (PHP Short Tag – NOT ALLOWED)

```html
<a href="<?= getAppURL('index') ?>">Home</a>
```

---

## 4.8 Always Use Helper Functions to Generate URLs

**Rule:**
Never hardcode URLs in FrontFiles.

FrontFiles **must use Expression Tags**, not PHP tags.

Always use the following helper functions inside expression tags:

| Purpose                                 | Helper Function |
| --------------------------------------- | --------------- |
| App `page_new` Event                    | `getAppURL()`   |
| App user-defined Event (`page_event_*`) | `getEventURL()` |
| Current App `page_new` Event            | `getThisURL()`  |

### Correct Examples

```html
<a href="##{ getAppURL('index') }#">Home</a>
<a href="##{ getEventURL('logout','','signin') }#">Logout</a>
<a href="##{ getThisURL() }#">Refresh</a>
```

### Incorrect Examples

```html
<a href="/index">Home</a>
<a href="<?= getAppURL('index') ?>">Home</a>
```

**Why this matters:**

* Keeps FrontFiles PHP-free
* Allows the engine to preprocess safely
* Enables caching and static analysis
* Prevents execution leakage

---

## 4.9 AJAX Requests Must Match App Response Type

If a FrontFile sends an **AJAX request**, the App **must respond using `$this->JSServer`**.

### Correct Flow

* FrontFile → AJAX request
* App → `$this->JSServer->send(...)`

### Important Rule

> If you use **custom AJAX implementation** (not `getAJAX()`),
> then you **cannot** use `$this->JSServer`.

In that case:

* You must implement a **custom response handler**
* SartajPHP will not manage the response automatically

---

## 4.10 Always Use Bootstrap for Layout

**Rule:**
All layouts must be written using **Bootstrap classes**.

Benefits:

* Responsive design
* Consistent grid system
* Predictable UI structure

### Example

```html
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <input id="txtName" runat="server">
    </div>
  </div>
</div>
```

---

## 4.11 Always Write JavaScript Using jQuery

**Rule:**
FrontFile JavaScript must use **jQuery**, not raw JavaScript.

Reasons:

* Framework compatibility
* Simplified DOM access
* Unified event handling

---

## 4.12 Always Use Framework AJAX & WebSocket Helpers

### Allowed Methods

| Purpose                       | Method      |
| ----------------------------- | ----------- |
| AJAX Request without callback | `getURL()`  |
| AJAX request with callback    | `getAJAX()` |
| WebSocket call                | `callApp()` |

### Disallowed (Unless You Handle Everything Manually)

* `fetch()`
* `XMLHttpRequest`
* Custom socket handlers

Using helpers ensures:

* Automatic routing
* Correct App execution
* Seamless `$this->JSServer` responses

---

## Important Design Rule (For Models & Developers)

> A FrontFile **describes UI intent**,
> an App **controls behavior**,
> and Components **bridge the two**.
> **FrontFiles must never contain PHP code.
> All dynamic output must use Expression Tags.**

Never mix business logic inside FrontFiles.

---

## 4.13 Use `runcb="true"` for Standardized Layout, Design & Effects

`runcb="true"` enables **CodeBlock-based layout processing** on any HTML tag.

A **CodeBlock** is a reusable, framework-managed layout or effect definition that transforms a tag at runtime **without creating a Component or PHP object**.

CodeBlocks are defined globally or at project level in `sphpcodeblock.php` and can be applied declaratively from FrontFiles.

---

### 4.13.1 Why Use CodeBlocks

CodeBlocks exist to solve a specific problem:

> **How to standardize layout, design, and effects across FrontFiles without duplicating HTML or creating Components.**

Using CodeBlocks:

* Reduces FrontFile HTML size
* Improves readability and focus on semantic structure
* Centralizes layout logic
* Allows late-stage design changes without editing FrontFiles

---

### 4.13.2 Core Benefits of CodeBlocks (Compared to Components)

CodeBlocks provide several advantages for layout-oriented logic:

1. **No PHP Object Creation**
   CodeBlocks do not create Components or runtime objects.

2. **Multiple CodeBlocks per Tag**
   You can apply **multiple CodeBlocks** to a single tag in any combination.

   ```html
   <div runcb="true"
        sphp-cb-card=""
        sphp-cb-border="2,primary">
   </div>
   ```

3. **Easily Overridable & Extendable**
   CodeBlocks can be:

   * Overwritten
   * Extended
   * Replaced

   without touching any FrontFile.

4. **Lightweight & Efficient**
   CodeBlocks operate directly on `NodeTag` and are faster than Components.

---

### 4.13.3 When to Convert Layout into a CodeBlock

Convert layout or effects into a CodeBlock when:

* The layout repeats across multiple FrontFiles
* The logic is purely presentational
* No lifecycle, state, or authentication is required
* The design may change later

**Good candidates:**

* Bootstrap cards
* Panels
* Wrappers
* Borders
* Shadows
* Layout helpers
* Visual effects

---

### 4.13.4 Example: Bootstrap Card as CodeBlock

Instead of writing long HTML repeatedly:

```html
<div class="card">
  <div class="card-body">
    Content
  </div>
</div>
```

Use a CodeBlock:

```html
<div runcb="true" sphp-cb-card="">
  Content
</div>
```

The actual layout is defined once in `sphpcodeblock.php`.

Later, if the design changes (e.g., card → accordion):

* Update the CodeBlock
* All FrontFiles update automatically
* No FrontFile edits required

---

### 4.13.5 Multiple CodeBlocks on the Same Tag

A single tag can apply multiple CodeBlocks:

```html
<div runcb="true"
     sphp-cb-card=""
     sphp-cb-border="3,primary"
     sphp-cb-shadow="">
  Content
</div>
```

Execution order is managed by the framework.

This allows **composable design**, similar to CSS utility classes, but with full structural control.

---

### 4.13.6 CodeBlocks vs Components (Design Rule)

| Use Case                      | Recommended Tool |
| ----------------------------- | ---------------- |
| Layout & visual structure     | CodeBlock        |
| Reusable design patterns      | CodeBlock        |
| UI effects & wrappers         | CodeBlock        |
| Authentication & permissions  | Component        |
| State, lifecycle, validation  | Component        |
| Dynamic interaction & updates | Component        |

---

### 4.13.7 Design Philosophy

> **Components control behavior.**
> **CodeBlocks control structure.**
> **FrontFiles describe intent.**

By moving layout and effects into CodeBlocks:

* FrontFiles stay clean and readable
* Design becomes centralized
* Applications become easier to refactor and maintain
