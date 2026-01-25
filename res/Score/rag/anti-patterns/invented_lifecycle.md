# ❌ Anti-Pattern: Invented Lifecycle Methods

## INVALID CODE

```php
public function index() {}
public function init() {}
public function handleRequest() {}
````

## Why This Is Invalid

* SartajPHP lifecycle is fixed
* No undocumented lifecycle methods exist
* Inventing lifecycle breaks execution order

## Correct Rule

Use ONLY documented lifecycle hooks.
If unsure → STOP.

````

---
