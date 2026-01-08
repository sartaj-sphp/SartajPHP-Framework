# ❌ Anti-Pattern: page_event Misuse

## INVALID

```html
<form page_event_submit="calculate">
````

## Why This Is Invalid

* `page_event_*` is server-side
* Forms with `action="#"` are client-side
* Client-side JS must handle submit

## Correct

```html
<form action="##{getThisURL()}#">
```

Use JavaScript for client-only behavior.

```

---
