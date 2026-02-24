# Chapter 2 – Environment, Events and Flow

## 2.2 Request-to-Event Execution Flow

A typical browser request is processed by SartajPHP in the following sequence:

1. Browser sends request to web server
2. Web server loads `start.php`
3. SartajPHP Engine is initialized
4. Router parses the incoming request
5. Page class is loaded
6. Request intent is parsed (URL pattern, method, flags)
7. Global settings are loaded
8. Project settings (`comp.php`) are loaded
9. Applications are registered
10. Request is translated into a PageEvent
12. Registered Gate is resolved using Gate
13. `prerun.php` is executed
14. Output buffering starts
15. Gate file is loaded and Gate object is created
16. Gate is executed
17. Gate output is rendered through Master file
18. Output is passed to Cache Engine
19. Final output is sent to browser

This mechanism allows SartajPHP to convert **URLs into structured application events** instead of static scripts.

---

## 2.3 BasicGate Execution Flow (Detailed)

In a **BasicGate**, after the SartajPHP engine loads and creates the Gate object, execution continues as follows:

1. Gate lifecycle event onstart triggered
2. FrontFile is created and parsed
3. SartajPHP Engine triggers the Gate run event
4. Gate triggers the resolved **PageEvent**
5. FrontFile is executed
6. Execute MasterFile and print FrontFile Output in proper place
7. SartajPHP Engine triggers the Gate render event

During this process, the Gate handles multiple categories of events:

* Application lifecycle events
* PageEvents
* Component events
* FrontFile-driven events

---

## 2.4 Gate Types and Execution Environment

| Gate Type   | Environment Support                | Description                                               |
| ---------- | ---------------------------------- | --------------------------------------------------------- |
| BasicGate   | Apache, SphpServer                 | Standard web applications with HTTP and AJAX support      |
| NativeGate  | SphpServer, Console (testing only) | WebSocket communication, AJAX, child process handling     |
| ConsoleGate | Console                            | CLI applications with argument parsing and console output |

**Notes:**

* BasicGate does not manage WebSocket connections directly
* NativeGate requires SphpServer for full functionality
* ConsoleGate does not run under a web server

---

## 2.5 Rules for Gate Types

### BasicGate

* `onstart` initializes FrontFile, authentication, permissions, master file, and defaults
* PageEvents: `page_new`, `page_insert`, `page_update`, `page_view`, `page_delete`
* AJAX events use `page_event_*`
* Can communicate with NativeGate through browser-side JavaScript WebSocket

---

### NativeGate

* `onstart` creates process, checks authentication, and sets up environment
* WebSocket events: `onwscon`, `onwsdiscon`
* Child process events: `page_event_c_*`
* Browser communication via `sendTo`, `sendAll`

---

### ConsoleGate

* `onstart` initializes variables and authentication
* `page_new` runs tasks or displays help
* Output via `sendMsg`, `consoleWriteln`, `consoleError`

---

## 2.6 Environment Execution Rules

### BasicGate

* Uses `onstart` for FrontFile creation, authentication, permissions, and defaults
* `page_new` always sends the default FrontFile
* Database operations:

  * `page_insert`
  * `page_update`
  * `page_view`
  * `page_delete`
* Heavy communication uses AJAX events `page_event_*`

---

### ConsoleGate

* Uses `onstart` for setup
* `page_new` executes tasks or shows help
* Outputs to console

---

### NativeGate

* Uses `onstart` to create process and initialize environment
* Communicates with browser via WebSocket
* Executes child processes
* AJAX communication via `page_event_*`

---

## 2.7 Event Naming Conventions

| Prefix  | Origin                       |
| ------- | ---------------------------- |
| `page*` | Page class events            |
| `comp*` | Component events             |
| `sphp*` | SartajPHP framework events   |
| none    | Application lifecycle events |

## URL → Gate → PageEvent Mapping Table

| # | Browser URL             | HTTP Method / Source                 | Gate | Server-side PageEvent(s)           | Notes                                                          |
| - | ----------------------- | ------------------------------------ | ------- | ---------------------------------- | -------------------------------------------------------------- |
| 1 | `index.html`            | GET (direct request)                 | `index` | `page_new()`                       | Default entry point. Used for initial page load.               |
| 2 | `index.html`            | POST (Form submit)                   | `index` | `page_submit()` → `page_insert()`  | Standard form submission for **new data insertion**.           |
| 3 | `index.html`            | POST (Form submit with data binding) | `index` | `page_submit()` → `page_update()`  | Used when form is bound to existing DB record.                 |
| 4 | `index-info-about.html` | GET / AJAX                           | `index` | `page_event_info($evtp = "about")` | Hyphenated suffix maps to **custom PageEvent** with parameter. |
| 5 | `index-delete-1.html`   | GET / AJAX                           | `index` | `page_delete()`                    | Numeric suffix maps to delete action (ID resolved internally). |
| 6 | `index-view-2.html`     | GET / AJAX                           | `index` | `page_view()`                      | View existing record (ID resolved internally).                 |
| 7 | `chat-send-eml.html`    | GET / AJAX                           | `chat`  | `page_event_send($evtp = "eml")`   | Event-driven action routed to a different Gate.             |

---

## URL Resolution Rules (Important for Models)

### 1. Gate Resolution Rule

```
<gate>-<action>-<param>.html
```

* First segment → **Gate**
* Gate must be registered
* If not registered → request rejected

---

### 2. PageEvent Resolution Rules

| URL Pattern              | Resulting Event                   |
| ------------------------ | --------------------------------- |
| `/index.html`            | `page_new()`                      |
| POST to same URL         | `page_submit()` → `page_insert()` |
| POST + DB binding        | `page_submit()` → `page_update()` |
| `*-delete-*.html`        | `page_delete()`                   |
| `*-view-*.html`          | `page_view()`                     |
| `*-<event>-<param>.html` | `page_event_<event>($evtp)`       |

---

### 3. `page_submit()` Role (Important)

`page_submit()` is a **dispatcher**, not a final handler.

It decides:

* Insert vs Update
* Validation state
* Whether to trigger:

  * `page_insert()`
  * `page_update()`
  * or return to `page_new()`

---

### 4. `$evtp` (Event Parameter)

In URLs like:

```
index-info-about.html
```

* `info` → event name
* `about` → `$evtp`

Result:

```php
page_event_info("about")
```

Used heavily for:

* AJAX
* Dynamic content
* Lightweight routing
* Component-triggered events


> **In SartajPHP, URLs are translated into PageEvents, not controller methods.**

## Final Authoritative Execution Flow (Text Diagram)

Browser Request
   ↓
start.php
   ↓
SartajPHP Engine
   ↓
Router
   ↓
Gate Resolved
   ↓
Page Class Loaded
   ↓
PageEvent Resolved
   ↓
Gate Object Created
   ↓
Gate Lifecycle Event: onstart
   ↓
FrontFile Created
   ↓
FrontFile Parsed
   ├─ NodeText Objects Created
   ├─ NodeTag Objects Created
      │
      ├─ Runtime Attribute Detection
      │   └─ runat="server"
      │        │
      │        ├─ Component Objects Created (extends Component)
      │        │   ├─ Component Object Instantiated
      │        │   └─ NodeTag Bound to Component (Component::$element)
      │        │
      │        ├─ Fusion Attributes Executed (PARSE PHASE)
      │        │   ├─ fun-* → Call Component method with fi_* prefix
      │        │   └─ fui-* → Call Component method with fi_* prefix
      │        │
      │        ├─ Component Creation Lifecycle
      │        │   ├─ Component Internal Event: oninit
      │        │   ├─ Gate Hook Event: on-init
      │        │   ├─ Gate Hook Event: on-create
      │        │   ├─ Component Internal Event: oncreate
      │        │   └─ $parent->onchildevent("oncreate", Component)
      │
   ↓
FrontFile Parse Completed
   └─ Global Component Event Triggered: onaftercreate
   ↓
Gate Lifecycle Event: onready
   ↓
Gate Lifecycle Event: onrun
   ↓
Gate Triggers Component onappevent (request-level coordination)
   ↓
Gate Triggers PageEvent (page*)
   ↓
FrontFile Executed
   ├─ Fusion Attributes Executed (EXECUTION PHASE)
   │   ├─ fun-* → Call Component method with fu_* prefix
   │   └─ fur-* → Call Component method with fu_* prefix
   │
   ├─ Runtime Attributes Processed
   │   ├─ runas="holder" → onholder Event Triggered (Component or App)
   │   └─ runcb="true" → NodeTag callback manipulation
   │
   ├─ Component Render Lifecycle
   │   ├─ Gate Hook Event: on-startrender
   │   ├─ Component Internal Event: onprejsrender
   │   ├─ Component Internal Event: onprerender
   │   ├─ $parent->onchildevent("onprerender", Component)
   │   ├─ Component Internal Event: onjsrender
   │   ├─ Component Internal Event: onrender
   │   ├─ Component Internal Event: renderLast
   │   ├─ Gate Hook Event: on-endrender
   │   └─ $parent->onchildevent("onrender", Component)
   │
   └─ HTML Generated (1 NodeTag → N HTML tags possible)
   ↓
Combine MasterFile master.php + FrontFile Output
   ↓
Gate Render Event
   ↓
Cache Engine
   ↓
Browser Response
