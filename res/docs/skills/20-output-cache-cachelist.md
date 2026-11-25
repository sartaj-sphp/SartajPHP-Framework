# Output cache (`cachelist.php`)

Teach an AI how to **register Gate URLs for HTML output caching** to cut PHP load and speed repeat GETs. Demo: `ex19cache` + project `cachelist.php`. API documented on `addCacheList` in framework `vendor/.../Score/SphpDoc/global/start.php`.

## When to use

- Public pages that change rarely (marketing, docs)  
- Same HTML for all users for a TTL  

Do **not** cache personalized or POST-driven pages.

## Mental model

Engine reads `cachelist.php` early. Matching **GET** responses may be served from cache until `$sec` expires. **POST** skips this page cache.

## Develop

In project `cachelist.php`:

```php
<?php
// Cache all events of Gate "ex19cache" for 30 seconds
addCacheList('ex19cache', 30);

// Examples from start.php docs:
// addCacheList('blog-view', 1800, 'ce');   // Gate + event
// addCacheList('shop-product-shirt', 3600, 'cep'); // Gate + event + param
// addCacheList('info', 3600, 'e');         // event name on any Gate
```

| `$type` | Meaning |
|---------|---------|
| `Gate` (default) | Match Gate name; all its events |
| `ce` | Gate + event |
| `cep` | Gate + event + evtp |
| `e` | Event name on any Gate |

Helpers: `isRegisterCacheItem`, `getCacheItem`, `clearCacheItem` (same `start.php`).

Demo Gate prints a timestamp so you can see staleness while cached.

## Run / test

```bat
sphpdesk\sphpserver\sphpserver-win.exe --proj .\ --port 8000 --host 127.0.0.1
```

1. Open `/ex19cache.html` — note **Generated at**  
2. Reload within 30s — stamp should stay the same when cache is active  
3. `/ex19cache-fresh.html` — event not registered as `cep`; useful contrast  

Verified 2026-10-26: Gate HTML renders; registry line present in `cachelist.php`.

## Related

- Request pipeline / cache check: [01](01-browser-request-and-sartajphp-response-workflow.md)  
- Framework: [ebook2](https://www.sartajphp.com/ebook2-fullbook.html)  
