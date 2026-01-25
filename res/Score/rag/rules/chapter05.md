# Chapter 05 — Expression Tags (Execution Model & Priority)

Expression tags provide a **controlled evaluation layer** inside FrontFiles.
They are **not PHP**, but a **restricted expression engine** with **well-defined execution priority**.

Expression tags **do not run immediately when parsed**.
They execute according to **where they appear** and **which lifecycle phase they are bound to**.

---

## 5.1 Expression Tag Types

There are two expression tag forms:

| Tag          | Purpose                      |
| ------------ | ---------------------------- |
| `#{ ... }#`  | Silent execution (no output) |
| `##{ ... }#` | Escaped output by default    |

Filters may be applied:

```html
##{raw:$html}#
##{json:$data}#
```

---

## 5.2 Expression Tags Are NOT PHP

Expression tags:

* ❌ Cannot execute full PHP
* ❌ Cannot define loops
* ❌ Cannot define functions or classes
* ❌ Cannot access Component instances directly
* ❌ Cannot mutate Component lifecycle implicitly

They can:

* Assign variables
* Evaluate expressions
* Use if / elseif / else / endif
* Call limited functions
* Call methods on **explicitly allowed objects only**

---

## 5.3 Allowed Method Targets

Expression tags may call methods **only** on the following objects:

* `$frontobj`
* `$parentapp`
* `$metadata`
* `$sphp_settings` (`Sphp\Settings`)
* `$sphp_router` (`Sphp\core\Router`)
* `$sphp_request` (`Sphp\core\Request`)
* `$debug` (`Sphp\core\DebugProfiler`)

Example:
addMetaData in App can access as variable in Expression Tag of Front File.
```php
// in App
$this->frtMain->addMetaData("title","My Page Title");
```
```html
##{$title}#
```

> Components are **directly accessible** from expression tags with id as variable.

---

## 5.4 Expression Tag Execution Priority (Very Important)

Expression tags execute at **different priorities** depending on **where they are placed**.

### Priority Levels (Highest → Lowest)

| Priority                            | Location                                               |
| ----------------------------------- | ------------------------------------------------------ |
| **1 (fui-*)**                       | Expression tags inside **Fusion attributes fui-**      |
| **2 (<code on-init="true">)**       | Expression tags inside <code> Tag bind event init      |
| **3 (fur-*)**                       | Expression tags inside **Fusion attributes fur-**      |
| **4 (<code on-endrender="true">)**  | Expression tags inside <code> Tag bind event endrender |
| **5**                               | Expression tags inside **Component attributes**        |
| **6 (Lowest)**                      | Expression tags in normal HTML/text                    |

---

## 5.5 Expression Tags Inside Fusion Attributes

When expression tags are used **inside Fusion attributes**, their execution time is tied to the **Fusion prefix**.

Example:

```html
<input runat="server"
       fui-setDefaultValue="##{rand()}#">
```

Execution timing depends on the prefix:

| Prefix | Execution Phase                          |
| ------ | ---------------------------------------- |
| `fun-` | Call Any init / Rendering                |
| `fui-` | Immediate (init, before rendering begins)|
| `fur-` | Render-time (during component rendering) |

> Expression tags inside Fusion attributes execute **at the moment the Fusion method is invoked**, not globally.

---

## 5.6 Expression Tags Outside Components (Lowest Priority)

Expression tags written in normal HTML content:

```html
<p>##{$out1}#</p>
```

* Execute **after all Components have completed rendering**
* Cannot affect already-rendered Components
* Are suitable only for **final output composition**

---

## 5.7 Lifecycle-Based Example (Authoritative)

```html
<p id="p0">
    ##{$out1}#
</p>

<p id="p1" runat="server">
    render before p2 paragraph
    <input type="text" runat="server" id="txt1" value="west" />
</p>

<p id="p2" runat="server"
   fur-_style="#{$frontobj->getComponent('txt1')->fu_setValue('South')}#">

    render after p1 paragraph.
    We cannot change txt1 value here because txt1 has already rendered.
    
    #{$out1='This content cannot appear in p0'}#
</p>

<p id="p3" runat="server"
   fui-_style="#{$frontobj->getComponent('txt1')->fu_setValue('North')}#"
   fur-_class="#{$out1='This content WILL appear in p0'}#">

    Here txt1 value CAN be changed because fui- executes before rendering.
</p>
```

### Why This Happens

| Case                              | Reason                           |
| --------------------------------- | -------------------------------- |
| `p2` cannot change `txt1`         | `txt1` already rendered          |
| `fur-` executes too late          | Render phase                     |
| `fui-` works                      | Executes **before render phase** |
| `$out1` in `p2` invisible to `p0` | Executed after `p0`              |
| `$out1` in `p3` visible to `p0`   | Executed before `p0`             |

---

## 5.8 Canonical Rule (Chapter 05)

> Expression tags execute **according to lifecycle position**, not file order.
> Expression tags inside Fusion attributes execute at **Fusion call time**.
> Expression tags in normal content execute **after all Components complete rendering**.

---

## Final Canonical Separation

| Concept           | Responsibility      |
| ----------------- | ------------------- |
| Expression Tags   | Evaluation & output |
| Fusion Attributes | Component control   |
| Prefixes          | Execution timing    |
| Components        | State & rendering   |

