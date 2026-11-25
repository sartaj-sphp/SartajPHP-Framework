
# SartajPHP Development Rules

These rules are maintained by the SartajPHP framework and distributed through Composer.

## General rules

- Follow the installed SartajPHP skills and API documentation.
- Use the nearest app root containing `start.php`.
- Never treat `vendor/` as an application directory.
- Do not edit Composer vendor files to fix application code.
- Check SphpDoc stubs before using framework APIs.
- Follow the existing application architecture and conventions.
- Do not assume traditional MVC routing unless the application uses MVCApp.

## Naming conventions

- Use CamelCase for classes, methods, functions, and variables.
- Use snake_case for Gate, Page, Components events handlers.
- Use UPPER_SNAKE_CASE for constants.
- Preserve SartajPHP reserved naming conventions.

Examples:

- `SphpApi`
- `jsServer`
- `$debugMode`
- `page_new`
- `page_event_about`

## Error handling

- Soft errors: `setErr()` / `getCheckErr()`.
- Hard errors: check the console and app `cache/Sphp_errorLog.txt`.
- Ignore `vendor/sartajphp/` stack frames when locating application bugs.
- Prefer fixing application code in the appropriate app directory.

## Fusion

- Prefer Front `fui-*`, `fun-*`, and `fur-*`.
- `fi_*` / `fui-*` initialization should normally happen once.
- Do not call Gate `fi_*` after creating `new FrontFile` unless intentionally changing the initialization flow.
- `fu_*` functions should have one owner.
- If Gate calls `fu_*`, do not also assign the same function to the Front.

## Develop / run / test

- Edit and run under the **app root** (`start.php` folder). Do not edit vendor skill sources to “fix” the app.
- Cloud = NativeGate + SphpServer (skill 14). Hosting/SPanel ops out of scope.

## Front files (summary)

- No `<?php ?>`, and no `echo` / `print` in `.front` — output with `##{$text}#` (filtered). Details: skill `04-front-file-designing.md`.

## Secrets

- Never commit passwords or put secrets in docs/skills.
