# ❌ Anti-Pattern: MVC / Controller Style App

## INVALID CODE

```php
class CalculatorController {
    public function index() {
        return view('calc');
    }
}
````

## Why This Is Invalid

* SartajPHP does NOT use Controllers
* There is no `view()` system
* Apps are NOT request routers
* FrontFiles are NOT PHP templates

## Correct Rule

Apps:

* Extend `BasicApp`, `NativeApp`, or `ConsoleApp`
* Use lifecycle hooks
* Instantiate FrontFile in `onstart`

NEVER generate this pattern.

````

---
