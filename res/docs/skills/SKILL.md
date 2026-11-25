---
name: sartajphp
description: >-
  Develop, run, and test SartajPhp projects (Web App, Console, Mobile, NativeGate/Cloud).
  Use when creating or editing Gates, FrontFiles, Masters, Components, fusion attributes
  (fui/fun/fur, fi_*/fu_*), AJAX/jsServer, permissions, database/HTMLForm/Pagination,
  FileUploader, AutoGate, ConsoleGate, NativeGate, MobileGate, debug/edit mode, or
  cachelist. Also use when the user mentions SartajPhp, SphpServer, or .gate.php / .front files.
---

# SartajPhp — agent router

Teach develop / run / test only. Do **not** invent APIs — verify against installed SphpDoc and the matching topic skill file.

## Naming (current framework)

- **CamelCase** — classes, methods, functions, variables (`sphpApi`, `jsServer`, `$debugMode`, `$projectUrl`).
- **snake_case** — Gate event handlers only (`page_new`, `page_submit`, `page_event_*`, `onstart`).
- **UPPER_SNAKE** — constants (`PROJ_PATH`, `START_PATH`, `NEWLINE`).
- **Namespaces / stubs** — `SphpDoc/Sphp/{Core,Dev,Gates,Kit,Lib,Tools}/` (PascalCase).
- **Fusion:** Front kebab `fui-*`/`fun-*`/`fur-*`; PHP `fi_*`/`fu_*` with CamelCase tails (`fu_setRender`).
- Skills ship with the matching vendor package — teach this framework version only.

## Single project and multi-project (both supported)

**Workspace root** = folder opened in Cursor (has `.cursor/`).  
**SartajPhp app root** = directory that contains **`start.php`**. Secondary: `comp.php`, `prerun.php`, `apps/`.

### Resolve app root (do this every task)

1. Read workspace **AGENTS.md** if present (may name app subfolders).
2. **Nearest wins:** from the file being edited, walk **upward** to the first folder that contains `start.php` → that is the **app root**.
3. If no file context yet:
   - List folders (workspace + documented children) that contain `start.php`.
   - **One** → that folder is the app root (often workspace = single project).
   - **Several** → multi-project; use the path the user named, else ask which app.
4. Never treat `vendor/` as an app root.

### Resolve vendor package

Use the first that exists:

1. `{workspace}/vendor/sartajphp/sartajphp/`
2. `{app root}/vendor/sartajphp/sartajphp/`

API stubs: `{vendor-package}/res/Score/SphpDoc/Sphp/…`  
Runtime boot often: `$libVersion` → `res/Score/SphpLatest/` (or `Sphp8e`)  
Ebook: https://www.sartajphp.com/ebook2-fullbook.html  

Do **not** use RAG folders. Prefer topic skills + SphpDoc.

### Resolve topic skill files (read the matching `NN-….md`)

Use the first location that contains the file:

1. **This Cursor skill folder** (same directory as this `SKILL.md`) — packaged for any project
2. `{vendor-package}/res/Score/skills/`
3. `{workspace}/docs/sartajphp/` (skill-source / doc repos only)

### Layout A — single project

```text
myapp/                          ← workspace = app root
  .cursor/skills/sartajphp/     ← SKILL.md + 01–20 topic files
  .cursor/rules/sartajphp.mdc
  start.php
  apps/
  vendor/sartajphp/sartajphp/   ← SphpDoc (+ optional Score/skills)
```

### Layout B — multiple related projects (shared vendor)

```text
spanel/                         ← workspace
  .cursor/skills/sartajphp/
  AGENTS.md
  vendor/sartajphp/sartajphp/
  appOne/start.php
  appTwo/start.php
```

## How to use

1. Resolve **app root** and **vendor package**.
2. Match the task to a topic below.
3. **Read** the full `NN-….md` from the skill folder (or vendor `Score/skills/`).
4. If an API is unclear, open the stub under `SphpDoc/Sphp/…`.
5. Implement under the **app root** — do not edit vendor skill sources to “fix” the app.

## Topic index

| File | Use when |
|------|----------|
| `01-browser-request-and-sartajphp-response-workflow.md` | URL → Gate → PageEvent → Front + Master |
| `02-project-structure-and-important-apis.md` | Project layout, naming, SphpBase, important APIs |
| `03-how-to-write-gate-class-and-handle-events.md` | Gate lifecycle, page_new / page_submit / page_event_* |
| `04-front-file-designing.md` | `.front` expressions, holders, Components in Fronts |
| `05-master-file-design.md` | Master layout, Front Places |
| `06-component-design-and-basic-components.md` | Components, **fusion rules** (fi_/fu_, fui/fun/fur) |
| `07-sartajphp-ajax-library-use.md` | getURL / getAJAX / jsServer |
| `08-code-blocks-and-frontfile-theming.md` | Code blocks / theming |
| `09-permissions-and-authentication.md` | Auth, roles, menus |
| `10-database-communication-in-gate.md` | Page helpers, HTMLForm, schema install |
| `11-data-log-history-and-restore.md` | data_log history |
| `12-recycle-bin-delete-and-restore.md` | Recycle bin |
| `13-consolegate-cli-shell.md` | ConsoleGate CLI |
| `14-nativegate-websocket-and-python-child.md` | NativeGate / WebSocket (**Cloud ≡ this**) |
| `15-mobile-app-development.md` | MobileGate hybrid Android |
| `16-debugging-and-error-tracing.md` | debugMode, edit mode, stacks (skip vendor frames) |
| `17-builtin-form-and-data-components.md` | Select, TextArea, FileUploader, Pagination/Grid AJAX |
| `18-autogate-reduced-crud-handlers.md` | AutoGate / AutoGatePermis |
| `19-minimum-project-files.md` | Minimum project bootstrap |
| `20-output-cache-cachelist.md` | cachelist / addCacheList |

**Typical web path:** 01 → 02 → 03 → 04 → 05 → 06 → 07 → 10 → 17 → 09 → 16. Then 13 / 14 / 15 as needed.

## Hard rules (always)

- Prefer Front fusion (`fui-*` / `fun-*` / `fur-*`) over Gate `fi_*` after `new FrontFile`.
- `fi_*` = init; `fu_*` = render. Front: `fui-*`→`fi_*` once; `fur-*`→`fu_*` each render; `fun-*` once per life.
- If Gate calls `fu_*`, do **not** also set that option on the Front — set only in Gate (incl. Page-Events).
- Soft errors: `setErr` / `getCheckErr`; do not throw for form validation.
- When tracing errors: skip `vendor/sartajphp/` frames; open first app `apps/` / `fronts/` / `masters/` file.
- No SPanel/Podman/FrontServer hosting rules here. No secrets in generated docs.

## Local run (typical)

From the **app root** (folder that contains `start.php`):

```bat
sphpdesk\sphpserver\sphpserver-win.exe --proj .\ --port 8000 --host 127.0.0.1
```

Or: `php -f start.php -- --gate {name}`

Apache subfolder apps: keep `comp.php` `$projectUrl` logic so `getGateUrl` includes the folder name.
