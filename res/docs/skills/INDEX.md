# SartajPhp skill index

Numbered markdown files in this folder are skill **sources**. Order is by filename prefix only.

| File | Status | Title |
|------|--------|--------|
| [01-browser-request-and-sartajphp-response-workflow.md](01-browser-request-and-sartajphp-response-workflow.md) | Skill (tested via `apps/examples/Ex01flow`) | Browser Request and SartajPhp Response Work-Flow |
| [02-project-structure-and-important-apis.md](02-project-structure-and-important-apis.md) | Skill (tested via `apps/examples/Ex02apis`) | Project Structure and Most Important APIs |
| [03-how-to-write-gate-class-and-handle-events.md](03-how-to-write-gate-class-and-handle-events.md) | Skill (tested via `apps/examples/Ex02events`) | How To Write Gate Class and Handle Events |
| [04-front-file-designing.md](04-front-file-designing.md) | Skill (tested via `apps/examples/Ex04front`) | Front File designing |
| [05-master-file-design.md](05-master-file-design.md) | Skill (tested via `apps/examples/Ex05master`) | Master File Design |
| [06-component-design-and-basic-components.md](06-component-design-and-basic-components.md) | Skill (tested via `Ex06comp` + `Ex06group`) | Component Design and Basic Components |
| [07-sartajphp-ajax-library-use.md](07-sartajphp-ajax-library-use.md) | Skill (tested via `Ex07ajax`) | SartajPhp AJAX Library Use |
| [08-code-blocks-and-frontfile-theming.md](08-code-blocks-and-frontfile-theming.md) | Skill (tested via `Ex08codeblock`) | Code Blocks and FrontFile theming |
| [09-permissions-and-authentication.md](09-permissions-and-authentication.md) | Skill (tested via `Ex09permis` + `apps/permis`) | Permissions and Authentication |
| [10-database-communication-in-gate.md](10-database-communication-in-gate.md) | Skill (tested via `Ex10db` + SQLite) | Database communication in Gate |
| [11-data-log-history-and-restore.md](11-data-log-history-and-restore.md) | Skill (tested via `Ex11dblog`) | Data log history and restore |
| [12-recycle-bin-delete-and-restore.md](12-recycle-bin-delete-and-restore.md) | Skill (tested via `Ex12recycle`) | Recycle bin — delete and restore |
| [13-consolegate-cli-shell.md](13-consolegate-cli-shell.md) | Skill (tested via `Ex13console` + system PHP) | ConsoleGate — CLI shell commands |
| [14-nativegate-websocket-and-python-child.md](14-nativegate-websocket-and-python-child.md) | Skill (tested via `Ex14native` + Python child) | NativeGate — WebSocket UI and Python child |
| [15-mobile-app-development.md](15-mobile-app-development.md) | Skill (tested via `mobileapp/` + MobileGate generate) | Mobile App Development |
| [16-debugging-and-error-tracing.md](16-debugging-and-error-tracing.md) | Skill (tested via `Ex16debug` + SphpServer) | Debugging and error tracing |
| [17-builtin-form-and-data-components.md](17-builtin-form-and-data-components.md) | Skill (tested via `Ex17comps`) | Built-in form and data Components |
| [18-autogate-reduced-crud-handlers.md](18-autogate-reduced-crud-handlers.md) | Skill (tested via `Ex18auto`) | AutoGate and AutoGatePermis |
| [19-minimum-project-files.md](19-minimum-project-files.md) | Skill | Minimum project files |
| [20-output-cache-cachelist.md](20-output-cache-cachelist.md) | Skill (tested via `Ex19cache` + `cachelist.php`) | Output cache (`cachelist.php`) |

**Learning path (typical web app):** 01 → 02 → 03 → 04 → 05 → 06 → 07 → 10 → 17 → 09 → 16. Then 13/14/15 as needed. Cloud ≡ NativeGate ([14](14-nativegate-websocket-and-python-child.md)).

In polished skills prefer [framework ebook/API links](https://www.sartajphp.com/ebook2-fullbook.html); cite demo Gates as paths/text, not learning-only local hyperlinks.

**Current framework naming:** CamelCase APIs/paths under `SphpDoc/Sphp/{Core,Gates,Kit,Lib,Tools}/`; snake_case Gate events; see skill [02](02-project-structure-and-important-apis.md). Skills match the installed vendor package version.

Workflow: author hints in `docs2/` → experiment/test in `apps/examples/` (or `mobileapp/`) → learning in `docs2/` → polish skill here. Do one numbered topic at a time.
