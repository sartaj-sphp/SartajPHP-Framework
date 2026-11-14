# Project Structure and Most Important APIs

Teach an AI the **files that make a SartajPhp project** and the **APIs used every day** (Request cookie/session, debug console, URL helpers, soft errors, `SphpBase`). Builds on [01 — request/response](01-browser-request-and-sartajphp-response-workflow.md). Gate lifecycle / PageEvents are [03](03-how-to-write-gate-class-and-handle-events.md).

## When to use

- Starting or navigating a SartajPhp project tree
- Reading/writing cookies, session, GET/POST
- Sending debug output to the browser console
- Building Gate/Event URLs (`getGateUrl`, `getEventUrl`)
- Soft validation errors (`setErr` / `getCheckErr`)

## Project structure (typical Web App)

```text
project/
  start.php          # Engine entry (web server / SphpServer hits this)
  reg.php            # registerGate("name", path to *.gate.php)
  comp.php           # $debugMode, DB, $masterf, getWelcome(), app settings
  prerun.php         # Runs before Gate (headers, global includes)
  cachelist.php      # Optional output-cache registry
  apps/              # Gate classes (*.gate.php) + fronts/
    examples/        # Skill demos in this doc project
  masters/           # *.mast.php layouts + Front Places
  cache/             # Sessions, error log (Sphp_errorLog.txt)
  vendor/sartajphp/sartajphp/   # Framework package
  sphpdesk/          # Local SphpServer binaries (this demo)
```

| Concern | Where |
|---------|--------|
| Register gates | `reg.php` → `registerGate(...)` |
| Debug level / master path | `comp.php` (`$debugMode`, `$masterf`) |
| API stubs (agent) | `vendor/.../res/Score/SphpDoc/Sphp/{Core,Dev,Gates,Kit,Lib,Tools}/` |
| Runtime lib (this demo) | `start.php` → `$libVersion = "SphpLatest"` → `res/Score/SphpLatest/` |
| Ebook | https://www.sartajphp.com/ebook2-fullbook.html |

## Naming conventions (current framework)

| Kind | Format | Examples |
|------|--------|----------|
| Classes, methods, functions, variables | **CamelCase** | `SphpApi`, `sphpRequest()`, `$debugMode`, `$projectUrl`, `$this->jsServer` |
| Gate event handlers | **snake_case** | `page_new`, `page_submit`, `page_event_*`, `onstart`, `onrender` |
| Constants | **UPPER_SNAKE** | `PROJ_PATH`, `NEWLINE`, `START_PATH` / `start_path` |
| Namespaces / stub folders | **PascalCase** segments | `Sphp\Core`, `Sphp\Gates`, `Sphp\Tools` under `SphpDoc/Sphp/…` |

**Fusion:** Front attributes stay **kebab** (`fui-*` / `fun-*` / `fur-*`). PHP methods are `fi_*` / `fu_*` with **CamelCase tails** (`fu_setRender`, `fu_submitAjax`). Prefer [apps/examples/](../../apps/examples/) over lagging stub comments.

Match APIs to the installed vendor package (`vendor/sartajphp/sartajphp/` → `SphpDoc` / `$libVersion`).

## Mental model: two ways to call APIs

| Context | Request / debug |
|---------|-----------------|
| Inside Gate | `$this->client` (Request), `$this->debug`, `$this->page`, `$this->jsServer` |
| Anywhere | `SphpBase::sphpRequest()`, `SphpBase::debug()`, `SphpBase::page()`, … |

`$this->client` **is** the same Request type as `SphpBase::sphpRequest()`.

## Develop — essential APIs

### 1. Request: cookie, session, get/post

From `vendor/.../SphpDoc/Sphp/Core/Request.php`:

```php
// Write cookie
$this->client->cookie("test1", "kaju");
// Same outside Gate:
SphpBase::sphpRequest()->cookie("test1", "kaju");

// Read cookie (omit value / pass null)
$v = $this->client->cookie("test1");
$v = SphpBase::sphpRequest()->cookie("test1");

// Session read/write
$this->client->session("ex02demo", "hello-session");
$s = $this->client->session("ex02demo");

// Form / query
$this->client->request("txtname");   // request bag
$this->client->post("txtname");
$this->client->get("id");
```

Signature pattern: `cookie($name, $value = null, ...)` and `session($name, $value = null)` — **null value means read**.

Also useful: `isCookie`, `isSession`, `isPost`, `isGet`, `isAjax`, `unsetCookie`, `unsetSession`.

### 2. Debug → browser console

Requires `$debugMode > 0` in `comp.php` (this demo uses `2`).

```php
$a = array("gate" => "ex02apis", "n" => 2);

$this->debug->print_r($a);           // in Gate
SphpBase::debug()->print_r($a);      // anywhere

$this->debug->println("my info");
SphpBase::debug()->println("my info");
```

Open DevTools **Console** to see output. Hard PHP crashes may still need `cache/Sphp_errorLog.txt`.

### 3. `SphpBase` (most used statics)

From `vendor/.../SphpDoc/global/startEngine.php`:

| Method | Returns / role |
|--------|----------------|
| `sphpRequest()` | Request (cookie, session, get/post) |
| `sphpResponse()` | Response |
| `sphpSettings()` | Paths, flags (`blnEditMode`, …) |
| `sphpRouter()` | Gate registration / current request |
| `sphpApi()` | Header/footer HTML, props, assets |
| `page()` | Page object (event, `$evtp`, DB helpers) |
| `jsServer()` | AJAX JSON blocks (skill 07) |
| `debug()` | Console debug |
| `dbEngine()` | Database |
| `getAppOutput()` | Gate/Front HTML into Master |

### 4. Global URL and error helpers

From `vendor/.../SphpDoc/Sphp/Tools/interfacefunctions.php`:

```php
getGateUrl("ex02apis");                    // landing URL
getEventUrl("readcookie", "", "ex02apis"); // PageEvent URL
getThisGateUrl();                          // current gate landing

setErr("app1", "User-facing error");
if (!getCheckErr()) { /* continue */ }
setErrInner("dev", "Internal detail for console");
```

FrontFile expression examples:

```html
<a href="##{getGateUrl('ex02apis')}#">Home</a>
<a href="##{getEventUrl('readcookie','','ex02apis')}#">Read</a>
```

Master-related helpers (skill 05): `addFrontPlace`, `runFrontPlace`, `renderFrontPlace`.

### 5. Minimal Gate using these APIs

See `apps/examples/Ex02apis.gate.php` — `page_new` writes cookie/session and `print_r`; `page_event_readcookie` reads via `SphpBase::sphpRequest()`.

## Run

```bat
sphpdesk\sphpserver\sphpserver-win.exe --proj .\ --port 8000 --host 127.0.0.1
```

- http://127.0.0.1:8000/ex02apis.html  
- http://127.0.0.1:8000/ex02apis-readcookie.html  

## Test / verify

Verified 2026-10-20 (HTTP 200, cookie jar):

| Check | Expect |
|-------|--------|
| Landing | Front shows cookie `kaju`, session `hello-session`; response `Set-Cookie: test1=kaju` |
| `getGateUrl` in page | `http://127.0.0.1:8000/ex02apis.html` |
| Read event | Same cookie/session via `SphpBase::sphpRequest()` |
| Console | With `$debugMode=2`, `print_r` / `println` appear in browser console |

## Pitfalls

- Wrong chain: use `SphpBase::sphpRequest()->cookie(...)`, **not** `sphpRequest()->request->cookie(...)`.  
- Forgetting `$debugMode` when expecting console output.  
- Confusing soft errors (`setErr`) with thrown exceptions.  
- Putting business logic only in Master — prefer Gate + Front; Master is layout (skill 05).  
- Import: `use Sphp\Gates\BasicGate;` and `use Sphp\Tools\FrontFile;`.

## Key paths

| Role | Path |
|------|------|
| Example | `apps/examples/Ex02apis.gate.php`, `apps/examples/fronts/ex02apis_main.front` |
| `SphpBase` | `vendor/sartajphp/sartajphp/res/Score/SphpDoc/global/startEngine.php` |
| Request | `vendor/sartajphp/sartajphp/res/Score/SphpDoc/Sphp/Core/Request.php` |
| Debug | `vendor/sartajphp/sartajphp/res/Score/SphpDoc/Sphp/Core/DebugProfiler.php` |
| Helpers | `vendor/sartajphp/sartajphp/res/Score/SphpDoc/Sphp/Tools/interfacefunctions.php` |
| Settings | `comp.php` |
| Ebook tree | `D:\www\SartajPHPWeb\apps\ebook` |

## See also

- [01 — Browser request / response](01-browser-request-and-sartajphp-response-workflow.md)  
- [03 — Gate class and PageEvents](03-how-to-write-gate-class-and-handle-events.md)  
- [04 — Front file](04-front-file-designing.md)  
- [05 — Master file](05-master-file-design.md)  
- [07 — AJAX](07-sartajphp-ajax-library-use.md)  
