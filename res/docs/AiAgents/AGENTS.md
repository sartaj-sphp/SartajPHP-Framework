
# SartajPHP Project

## Application

- Workspace root is the folder opened by the agent.
- App root is the nearest directory containing `start.php` above the active file.
- Ignore `start.php` files inside `vendor/`.
- Never treat a Composer vendor directory as an app root.
- For multi-app workspaces, identify the correct app from the active file path or user request.

## Framework package

Locate the installed Composer package:

`vendor/sartajphp/sartajphp/`

The package may be installed under the workspace root or the selected app root.

## Framework documentation

Before SartajPHP development, read:

- `res/docs/skills/SKILL.md`
- `res/docs/rules/RULES.md`

These paths are relative to the SartajPHP Composer package root.

Follow the skill and rules routers to load relevant documentation for the current task.

Use SphpDoc stubs as the API reference:

`res/Score/SphpDoc/Sphp/`

## Development

- Follow the installed framework skills, rules, and API stubs.
- Do not invent SartajPHP APIs or conventions.
- Do not edit Composer vendor files to fix application code.
- Work under the identified app root.
- Follow the existing application architecture.

The installed Composer package is the source of truth for SartajPHP-specific guidance.
