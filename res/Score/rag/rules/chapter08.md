# Chapter08 — FrontFile Specification

## 8.1 Definition

A **FrontFile** is a view-layer file responsible for rendering UI and handling client-side behavior.

A FrontFile:

* Is **not a controller**
* Is **not restricted HTML**
* Is **not lifecycle-bound**
* Is **not server-executed PHP**

---

## 8.2 Allowed Content (Authoritative)

A FrontFile **MAY contain**:

1. Any **valid HTML**
2. Any **valid JavaScript**
3. Any **valid CSS**
4. `<script>` tags (inline or external)
5. Dynamic JavaScript generation
6. Expression tags
7. Component tags
8. Server-bound attributes

No limitation is imposed on layout, structure, or client-side logic.

---

## 8.3 File Rules

* Extension: `.front`
* No PHP tags (`<?php ?>`) allowed
* Parsed by SartajPHP Front Parser
* Output must remain valid browser-renderable HTML

---

## 8.4 Expression Tags

Expression tags are allowed anywhere in FrontFile output.

Purpose:

* Output server-provided values
* Bind runtime data
* Reflect Gate state

Expression syntax and behavior are defined in **Chapter04**.

---

## 8.5 Component Tags

A FrontFile MAY include component tags.

Rules:

* Components are declared via custom tags
* `runat="server"` enables server binding
* Component lifecycle is **not executed in FrontFile**
* FrontFile only **declares** components

Component behavior is governed by **Chapter06**.

---

## 8.6 JavaScript Rules

FrontFiles MAY include:

* Inline `<script>` tags
* External JS files
* Event listeners
* Client-side calculations
* DOM manipulation
* AJAX
* Fetch / XHR
* Frameworks or vanilla JS

No restriction exists on client-side execution.

---

## 8.7 Execution Attributes

FrontFiles MAY use execution attributes:

* `runas`
* `runcb`
* `runas="jscode"`

Purpose:

* Control execution context
* Enable dynamic script evaluation
* Bind runtime behavior

Execution attributes do **not** define lifecycle behavior.

---

## 8.8 Client-Side Forms

Forms in FrontFiles:

* MAY use `action="#"` or any valid URL
* MAY submit via JavaScript
* MAY calculate entirely on client side
* ARE NOT required to use page events

Server interaction is optional.

---

## 8.9 Forbidden Content

A FrontFile MUST NOT contain:

* PHP code
* PHP tags
* Controllers
* Gate logic
* Request parsing logic
* Citation markers (`[1]`, `[2]`, etc.)
* Documentation artifacts

---

## 8.10 Authority Boundary

FrontFiles:

* Do **not** define lifecycle
* Do **not** invoke Gate methods
* Do **not** replace Apps
* Do **not** act as Controllers

They are **pure UI + client behavior** with optional server binding.

