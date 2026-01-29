# Chapter 06 — Fusion Attributes and FrontFile Process Flow

Fusion attributes do **not add new capabilities** to FrontFiles.
They control **when** a Component method or expression is executed and **how often**.

The engine behavior is **deterministic** and **top-down**.

---

## 6.1 Correct Render & Execution Order

### ✅ Correct behavior

* Components are rendered in **FrontFile Execute Phase**
* Rendering follows **Top-Down DOM order**
* **Sibling order matters**
* **Parent–child relation matters**

### Rendering rules

1. **Top components render first**
2. **Child Components render before their parent**
3. A parent Component (like `Form`) renders **after all its children**
4. For same DOM level → **left to right**

So rendering order is:

> **Top → Down, Children → Parent**

---

## 6.2 FrontFile Has Three Logical Passes

### Pass 1 — Parse Phase (Initialization Time)

This is **Component Initialization Time**.

During this phase:

* NodeTags are created
* Components are instantiated
* NodeTag is bound to Component
* **Early Fusion attributes are executed**

#### Executed here:

* `fui-*`
* `fun-*` with **fi_ methods Call**
* `fi_*` Fusion methods (forced)

Think of this phase as:

> “Component exists, structure is known, server-side setup happens”

---

### Pass 2 — Execute Phase (Runtime / Render Preparation)

This phase:

* Triggers App lifecycle events
* Prepares Components for output
* Applies runtime mutations

#### Executed here:

* `fur-*`
* `fun-*` with **fu_ Function Call**

This phase **prepares rendering**, but rendering itself happens *inside* this phase.

---

### Pass 3 — Final Expression Resolution

After all Components are processed:

* Expression tags outside Fusion attributes
* Expression tags inside normal HTML

are executed **last**.

---

### Summary Table

| Phase         | What Happens                           |
| ------------- | -------------------------------------- |
| Parse Phase   | Component initialization, early Fusion |
| Execute Phase | Runtime Fusion, render preparation     |
| Final         | Remaining expression output            |

---

## 6.3 Two Types of Component Configuration (Critical Distinction)

Components have **two different configuration categories**.

### 1️⃣ Server-Side Configuration (Parse-Only)

These configurations:

* Affect server logic
* Affect validation, file handling, DB logic
* Must exist **before request processing**

Examples:

* File upload save path
* Server validation rules
* Data binding instructions

#### Component rule

Component developers mark these methods with:

```
fi_*
```

#### FrontFile rule

These methods **can only be called by**:

```
fui-*
```

This is **enforced by design**.

> `fi_` means:
> “These Fusion Methods of Component can only called by fui-*.”

---

### 2️⃣ Client-Side Configuration (Flexible Timing)

These configurations:

* Affect HTML output
* Affect JS, CSS, attributes
* Can change per render

Examples:

* value
* class
* style
* checked
* src

These can be set:

* During parse
* By App
* During execute
* On each render

⚠ Rule of thumb:

> **Last write wins**

---

## 6.4 Fusion Attributes Prefixes

### `fun-` 

Use this **if you are not sure**.

Behavior:

* fi_ Call → parse phase
* fu_ Call → execute phase

This prefix **auto-decides timing**.

---

### `fui-` (Parse Phase)

Use when:

* Component method uses `fi_`
* Server-side configuration is required
* Dynamic value must resolve early

✔ Forces execution **during parse**
✔ Required for fi_ prefix Fusion methods

---

### `fur-` (Safe Default / Render Phase)

Use when:

* Configuration must apply **at render time**
* Component may render multiple times
* Output must change per render

✔ Executes **every render**
✔ Recommended default

---

## 6.5 `_` — The Special Fusion Method

`_` is a **generic Fusion method**.

It means:

> “Set this attribute using Fusion execution rules”

Example:

```html
<p id="p1" runat="server" fur-_style="##{$a='color:red'; $b='color:green'; $a}#"></p>
```

Internally:

* `_` receives `style`
* Expression is evaluated **on each render**
* Attribute is set dynamically with $a value

---

### Difference from normal attribute

```html
<p id="p1" runat="server" style="##{$a='color:red'; $b='color:green'; $a}#"></p>
```

* Expression is evaluated once at FrontFile Final Phase, after render event of Component
* No render awareness
* Attribute is set dynamically with $a value

Fusion `_` exists **only to control execution timing**.

---

## 6.6 When `fur-*` Is Work (And When It Isn’t)

### ✅ Work (Most Common)

Modifying **same Component**:

```html
<input id="txt1" runat="server" type="text" 
       fur-setMsgName="First Name" />
```

✔ Component controls its own render

---

### ❌ Not Work (Different Component Above On Top)

```html
<input id="txt1" runat="server" type="text" />

<div id="div1" runat="server"
     fur-_style="color-red; #{$frontobj->getComponent('txt1')->fu_setMsgName('Last Name')}#">
</div>
```

Why it fails:

* `txt1` already rendered and setMsgName configure placeholder attribute and other Labels
* before render component. So it is already write down in NodeTag. 
* Top-down rule violated

---

## 6.7 Why `fur-` Is Important for Data-Driven Components

Example: Pagination, Grid, Image Generator

* Data may not be needed if App exits early (AJAX)
* Fetching data in parse phase is wasteful
* `fur-` ensures work happens **only if rendering happens**

Also:

* Works with multi-render Components
* Allows same Component to produce different HTML outputs

---

## 6.8 Runtime Attributes & CodeBlocks (Correct Placement)

These always execute in **Execute Phase**:

* `runas="holder"`
* `runcb="true"`

Execution order:

* Top → Down
* Left → Right (for CodeBlocks)

All **client-side HTML output** is finalized here.

---

## 6.9 Final Rule of Thumb (Very Important)

> *fi_ → Parse Phase*
> *fu_ → Execute Phase*
> *Server logic → `fui-` + `fi_`*
> *Render logic → `fur-` + `fu_`*

If unsure:

➡ **Use `fun-`**

> `fi_` methods are **restricted to parse phase execution**, but **Components will not break** if they are not called.
> Components may use **default server-side configuration** when `fi_` methods are not invoked from the FrontFile.

---

# 6.10 Fusion Prefix Selection Chart (When to Use What)

### Fusion Attribute Prefix Decision Table

| Prefix | When to Use               | Value Type        | Execution Phase      | Notes              |
| ------ | ------------------------- | ----------------- | -------------------- | ------------------ |
| `fun-` | Default / unsure          | Static or Dynamic | Auto-decided         | **Safe default**   |
| `fui-` | Need parse-time execution | Static or Dynamic | **Parse Phase**      | Required for `fi_` |
| `fur-` | Render-time mutation      | Static or Dynamic | **Execute / Render** | Runs every render  |

---

### Practical Guidance

| Situation                                       | Recommended Prefix |
| ----------------------------------------------- | ------------------ |
| Simple attribute assignment                     | No Fusion          |
| Calling Component method, unsure timing         | `fun-`             |
| Server-side setup (upload, validation, binding) | `fui-`             |
| Render-dependent value                          | `fur-`             |
| Multi-render Component Value                    | `fur-`             |
| Override default expression timing              | `fui-` or `fur-`   |

---

# 6.11 Fusion Method Prefix Compatibility

| Component Method Prefix | Allowed FrontFile Prefix | Phase                |
| ----------------------- | ------------------------ | -------------------- |
| `fi_`                   | `fui-`, `fun-`           | Parse                |
| `fu_`                   | `fun-`, `fur-`, `fui-`   | Auto / Forced        |
| `_`                     | `fun-`, `fur-`, `fui-`   | Set attribute        |

---

# 6.12 Expression Tag Priority Order (Chart)

### Definition (Important)

**Expression Tags** mean only:

* `##{ ... }#`
* `#{ ... }#`

These:

* Can be written **only in FrontFile**
* Are **not allowed** in App or Component PHP code
* Execute according to FrontFile processing order
* Are affected by Fusion attribute prefixes

---

### Expression Evaluation Priority (Top → Bottom)

| Priority | Expression Category                                             | Phase   |
| -------- | --------------------------------------------------------------- | ------- |
| 1️⃣      | Expression tags inside `fui-*` Fusion attributes                | Parse   |
| 2️⃣      | Expression tags inside `fur-*` Fusion attributes                | Execute |
| 3️⃣      | Expression tags inside `fun-*` Fusion attributes (dynamic only) | Execute |
| 4️⃣      | Expression tags inside runtime attributes (`runas`, `runcb`)    | Execute |
| 5️⃣      | All remaining expression tags (`##{}#`, `#{}#`) in FrontFile    | Final   |

---

### Simplified Rule (Human-Friendly)

```
Expression Tags run LAST
↓
Unless Fusion attributes pull them EARLIER
↓
fui-*  → Parse Phase
fur-*  → Render Phase
fun-*  → Auto (fi_ = parse, fu_ = render)
```

---

### One-Line Mental Model

> **Expression tags always want to execute at the end —
> Fusion attributes decide if they are allowed to run earlier.**

### Simplified Mental Model

```
Parse Phase
 ├─ fui-*
 ├─ fun-(fi_ Call)
 └─ Component initialization

Execute Phase
 ├─ fur-*
 ├─ fun-(fu_ call)
 ├─ runtime attributes
 └─ rendering

Final
 └─ remaining expression tags
```

---

# AI-Safe Rules for Fusion Attributes & Expression Tags

## Core Mental Model (Must Be Clear)

**Fusion attributes are equivalent to calling a Component’s methods.**

Just like in PHP:

```php
$component->fi_setDefaultValue(($x>2)?'Hello world':'Hello Moon');
```

In FrontFile:

```html
<input id="txt1" runat="server" type="text" fui-setDefaultValue="##{($x>2)?'Hello world':'Hello Moon'}#" />
```

Fusion attributes:

* **Call Component methods**
* **Pass values**
* **Change Component output**
* Are **optional**, not mandatory

Components **do not break** if a Fusion method is not called — they use defaults.

---

## Expression Tags ≠ Fusion Attributes

**Expression Tags**

```
##{ ... }#
#{ ... }#
```

* Exist **only in FrontFile**
* Execute PHP-like logic
* Can interact **between Components**
* Execution time depends on **where they are used**

**Fusion Attributes**

```
fui-*, fun-*, fur-*
```

* Decide **when** an expression is evaluated
* Decide **when** a Component method is called

---

## Correct Interaction Model Between Components

When expression tag priority is involved:

> **Components can interact with each other only through execution order.**

Example:

```html
<p id="p1" runat="server" fur-_style="##{$frontobj->getComponent('txt1')->getValue()}#"></p>
```

This works **only if**:

* The execution phase allows it
* You understand render order
* Or you force timing using Fusion attributes

Fusion attributes are the **timing controller**.

---

## FINAL UNIVERSAL STRATEGY (IMPORTANT)

### ✅ One Rule That Works in ALL Situations

> **Use `fui-` for ALL `fi_` Fusion methods
> Use `fur-` for ALL `fu_` Fusion methods
> Use `fun-` for ANY Fusion Method**

---

## Why This Strategy Is Correct

### 1️⃣ `fi_` Methods (Server-Side Configuration)

* Required **before execution**
* Used for:

  * File upload paths
  * Server validation rules
  * Data preparation
* Must execute at **parse time**

✔ Correct usage:

```html
<input id="flea1" runat="server" type="file" fui-setFileSavePath="temp/imgs/##{$frontobj->flea1->getFileName() . '.' . $frontobj->flea1->getFileExtension()}#" />
```

✔ Rule:

```
fi_  →  fui-
```

---

### 2️⃣ `fu_` Methods (Client / Output Configuration)

* Affect rendering, JS, HTML output
* Can safely run at execute/render time
* Can run multiple times (multi-render)

✔ Correct usage:

```html
<input id="txt1" runat="server" type="text" fur-setValue="##{$val}#" />
```

✔ Rule:

```
fu_  →  fur-
```

---

### 3️⃣ Why `fun-` Is Optional

`fun-` auto-decides:

| Fusion Method        | Execution |
| -------------------- | --------- |
| fi_*                 | Parse     |
| fu_*                 | Execute   |

This **is not readable** when:

* Components are nested
* Parent/child render order should readable and identified

✔ Safe rule:

> **Use `fun-` only if you do not know about type of Fusion Method**
> **You want to make sure Fusion Method call only once in multiple render**

✔ Correct and Work RefComp can change Value:

```html
<input id="txt1" runat="server" type="text" fur-setValue="This is Original Component Tag">
<input id="txt1" runat="server" type="text" fur-setValue="This is Reference Component Tag">
```

❌ Wrong, RefComp can't change value, Output "This is Original Component Tag" in all textbox:

```html
<input id="txt1" runat="server" type="text" fun-setValue="This is Original Component Tag">
<input id="txt1" runat="server" type="text" fun-setValue="This is Reference Component Tag">
<input id="txt1" runat="server" type="text" fun-setValue="##{This is Dynamic Value}#">
```

---

## Child Component Rule (CRITICAL)

> **When a Component is a child, always use `fur-` for `fu_` methods.**

Why?

* Parent controls render order and output
* Children render before parent render and after parent pre-render (onprerender)
* Parent can render its children more then one
* `fur-` is also work with RefComp (Share Multiple NodeTag with Component Object)
* `fur-` guarantees execution at each render

✔ Correct always Work, `fun-` set value and in loop `fur` over write it:

```html
<input id="txta" type="text" runat="server" fun-setValue="Enter Name" />

<div id="div1" runat="server" path="slibpath/comp/server/ForLoop.php" fun-setLoopTo="2">
    <input id="txta" type="text" runat="server" fur-_id="##{'txt' . $div1->counter}#" 
        fur-_name="##{'txt' . $div1->counter}#" 
        fur-setValue="##{'Enter Name' . $div->counter}#" />
    <br />
</div>
```

✔ Correct always Work, `fur-` set value and in loop `fur` over write it:

```html
<input id="txta" type="text" runat="server" fur-setValue="Enter Name" />

<div id="div1" runat="server" path="slibpath/comp/server/ForLoop.php" fun-setLoopTo="2">
    <input id="txta" type="text" runat="server" fur-_id="##{'txt' . $div->counter}#" 
        fur-_name="##{'txt' . $div->counter}#" 
        fur-setValue="##{'Enter Name' . $div->counter}#" />
    <br />
</div>
```

❌  Wrong `fun-` (fun-setValue) will be call Method Once, So not Call on Reference Component Tag:

```html
<input id="txta" type="text" runat="server" fun-setValue="Enter Name" />

<div id="div1" runat="server" path="slibpath/comp/server/ForLoop.php" fun-setLoopTo="2">
    <input id="txta" type="text" runat="server" fur-_id="##{'txt' . $div->counter}#" 
        fur-_name="##{'txt' . $div->counter}#" 
        fun-setValue="##{'Enter Name' . $div->counter}#" />
    <br />
</div>
```

❌  Wrong `fun-` will be call Fusion Method Once, So value will not update after first loop:

```html
<div id="div1" runat="server" path="slibpath/comp/server/ForLoop.php" fun-setLoopTo="2">
    <input id="txta" type="text" runat="server" fur-_id="##{'txt' . $div->counter}#" 
        fur-_name="##{'txt' . $div->counter}#" 
        fun-setValue="##{'Enter Name' . $div->counter}#" />
    <br />
</div>
```

❌ Wrong `fun-` can call `fi_` type methods but `fur-` can not call `fi_` method:

```html
<input id="txta" type="text" runat="server" fun-setDefaultValue="Enter Name" />

<div id="div1" runat="server" path="slibpath/comp/server/ForLoop.php" fun-setLoopTo="2">
    <input id="txta" type="text" runat="server" fur-_id="##{'txt' . $div->counter}#" 
        fur-_name="##{'txt' . $div->counter}#" 
        fur-setDefaultValue="##{'Enter Name' . $div->counter}#" />
    <br />
</div>
```

❌ Wrong `fun-` and `fui-` can call `fi_` type methods but only in parse phase:

```html
<input id="txta" type="text" runat="server" fun-setDefaultValue="Enter Name" />

<div id="div1" runat="server" path="slibpath/comp/server/ForLoop.php" fun-setLoopTo="4">
    <input id="txta" type="text" runat="server" fur-_id="##{'txt' . $div->counter}#" 
        fur-_name="##{'txt' . $div->counter}#" 
        fui-setDefaultValue="##{'Enter Name' . $div->counter}#" />
    <br />
</div>
```

---

## Component Interaction Without Fusion Attributes

If:

* You want to control Components **from App**
* Or from **another Component**
* Or using **expression tags**

👉 **Remove Fusion attributes from FrontFile**

Then control via:

```php
$frontobj->getComponent('txt1')->fu_setValue('North');
```

This avoids:

* Render order conflicts
* Double execution
* Unexpected overrides

---

## AI-Safe Generation Rules (For Models & Tools)

**AI must always follow these rules:**

1. ❌ Never generate `fi_` methods with `fun-` or `fur-`
2. ✅ Always bind `fi_` → `fui-`
3. ✅ Always bind `fu_` → `fur-`
4. ❌ Never assume Fusion attributes are mandatory
5. ✅ Prefer `fur-` for child Components
6. ❌ Do not mix `fun-` unless timing is irrelevant
7. ✅ Expression tags without Fusion attributes execute last

---

## One-Sentence Final Law

> **Fusion attributes control timing, not logic —
> choose timing first, logic second.**

