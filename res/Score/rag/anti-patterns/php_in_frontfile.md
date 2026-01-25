# ❌ Anti-Pattern: PHP Inside FrontFile

## INVALID CODE

```html
<?php echo $value; ?>
````

## Why This Is Invalid

* FrontFiles are NOT executed by PHP
* FrontFiles are parsed by SartajPHP engine
* PHP tags will break parsing

## Correct Usage

Use:

* Expression tags
* Component attributes
* JavaScript

NEVER generate PHP inside `.front` files.

````

---
