```
title: SartajPHP Complete Framework Standard
description: The definitive guide to the Gate-Driven Event Architecture (GDEA), covering all application types, file structures, and APIs.
version: 1.0.0
source: https://www.sartajphp.com/ebook-fullbook.html
update-strategy: fetch-on-request
globs:
  - "**/*.gate.php"
  - "**/*.app"
  - "**/*.front"
  - "**/*.mast.php"
  - "**/*.place.php"
  - "**/start.php"
  - "**/reg.php"
  - "**/comp.php"
---

# SartajPHP Core Standards

## Application Types & Their Patterns

### 1. BasicGate (Web Apps)
- **File:** `*.gate.php`
- **Lifecycle:** `onstart()` -> `onready()` -> `onrun()` -> `onrender()`
- **URL Mapping:** `index-view-5.html` -> `Gate: index`, `Event: view`, `Parameter: 5`
- **Key Events:**
  - `page_new()`: Default GET request.
  - `page_submit()`: Handles POST requests.
  - `page_event_{event}($evtp)`: Custom events (e.g., `page_event_delete`).

### 2. NativeGate (Real-time/WebSocket)
- **File:** `*.gate.php` (placed in `/appsn/`)
- **Characteristics:** Long-running, persistent connections. No HTTP request/response cycle.
- **Key Events:**
  - `onwscon($wsconobj)`: New WebSocket connection.
  - `onwsdiscon($wsconobj)`: Connection closed.
  - `page_event_{event}($evtp)`: Handles messages from the client.

### 3. ConsoleGate (CLI Apps)
- **File:** `*.gate.php`
- **Execution:** `php start.php --gate {GateName} --evt {Event} --evtp {Param}`
- **Characteristics:** No web server, outputs to console, ideal for cron jobs.

## Critical File Rules

### Front Files (`*.front`)
- **RULE 1: NO PHP TAGS (`<?php`).** Pure HTML/XML only.
- **RULE 2: Common fields (`userid`, `parentid`, `spcmpid`) are handled by the Gate class. DO NOT add them as hidden inputs.**
- **RULE 3: Component Attribute Mapping**
  - `component="input"` -> tag: `<input>`
  - `component="textarea"` -> tag: `<textarea>`
  - `component="select"` -> tag: `<select>`

### Master Files (`*.mast.php`)
- Contain the main HTML layout (`<html>`, `<head>`, `<body>`).
- Use `getScriptsAndCSS($html)` and `getPageContent()` API calls to assemble the final page.

### Project Configuration (`comp.php`)
- Database (`$dhost`, `$duser`, `$dpass`, `$db`).
- Debug mode (`$debugmode`: 0=prod, 1=errors, 2=[erros, warnings], 3=all).
- Master file path (`$masterf`, `$mebmasterf`).

### Application Registry (`reg.php`)
- **CRITICAL:** All applications must be registered.
- `registerGate("gate_name", "/full/path/to/Gate.gate.php");`
- With Permissions: `registerGate("chat", "/path/to/Chat.gate.php", "","Chat",array(
        ["view","Chat View"],
        ["add","Create Chat"],
        ["edit","Edit Chat"]
    ));`


## 🔧 Database Introspection & Code Generation with aiinfo Gate

Kilo can inspect your database structure and generate code using the built-in aiinfo Gate. This is the PREFERRED method for understanding table schemas and generating Gate classes + Front Files.

### Command Line Usage

**To inspect a table structure:**
```bash
php {workspace_folder}/start.php -- --gate aiinfo --evt table_list --evtp {tablename}
```

**To get last 10 rows of a table:**
```bash
php {workspace_folder}/start.php -- --gate aiinfo --evt search --evtp {tablename}
```

**To generate Gate Class + Front Files from a table:**
```bash
php {workspace_folder}/start.php -- --gate aiinfo --evt generateApp --evtp {tablename}
```

**Examples:**
```bash
# Inspect the cmp_monthly_compliance table
php /home/user/myproject/start.php -- --gate aiinfo --evt table_list --evtp cmp_monthly_compliance

# Generate full CRUD app for the product table
php ./start.php -- --gate aiinfo --evt generateApp --evtp product
```

### URL-Based Access (Web Server)

**URL Pattern with Base Path:**
```
http://{domain}/{basepath}/{gate}-{event}-{parameter}.html
```

**URL Components:**

| Variable | Source | Description | Example |
|----------|--------|-------------|---------|
| `{domain}` | Web server config | Your domain or localhost | `localhost` or `example.com` |
| `{basepath}` | `comp.php` `$basepath` variable | Subfolder path from root (may be empty) | `myproject` or `` (empty) |
| `{gate}` | Registered Gate name | Gate class from `reg.php` | `aiinfo` |
| `{event}` | Event method name | Without `page_event_` prefix | `generateApp` or `table_list` |
| `{parameter}` | Event parameter | Table name or other value | `product` |

**How to Read Basepath from comp.php:**

The `$basepath` variable in `comp.php` defines the subfolder path:
```php
// comp.php
$basepath = "myproject";  // Project is in subfolder
// OR
$basepath = "";  // Project is in root directory
```

**URL Construction Rules:**
1. If `$basepath` is not empty, include it with a trailing slash: `{basepath}/`
2. If `$basepath` is empty, omit it entirely
3. Always use hyphens (`-`) as separators between gate, event, and parameter
4. File extension must be `.html`

**URL Examples:**

| Basepath Value | Full URL |
|----------------|----------|
| `""` (empty) | `http://localhost/aiinfo-generateApp-product.html` |
| `"myproject"` | `http://localhost/myproject/aiinfo-generateApp-product.html` |
| `"sartaj/apps"` | `http://localhost/sartaj/apps/aiinfo-generateApp-product.html` |

### Parameter Reference

| Parameter | Source | Description | Example |
|-----------|--------|-------------|---------|
| `{workspace_folder}` | VS Code workspace | Current project root (use `./` or full path) | `./` or `/var/www/project` |
| `{domain}` | Web server | Server domain or IP | `localhost` or `192.168.1.100` |
| `{basepath}` | `comp.php` `$basepath` | Subfolder path (may be empty string) | `"myproject"` or `""` |
| `--gate` | Command line | Registered Gate class name | `aiinfo` |
| `--evt` | Command line | Event method name | `table_list` or `generateApp` |
| `--evtp` | Command line | Table name to inspect/generate | `cmp_monthly_compliance` |

### Important Notes

- Always use `{workspace_folder}` or `./` to reference the current project root
- `table_list` returns complete column metadata (names, types, constraints)
- `generateApp` returns code of Gate class + edit.front + list.front files as Database Table Structure
- To get the `basepath` value, read `$basepath` from `comp.php` in the project root
- If `$basepath` is not defined in `comp.php`, treat it as empty string
- When constructing URLs for Kilo to access, use the appropriate basepath or omit it based on the configuration


## API and Coding Standards

### Request Data (NEVER use superglobals)
- `$this->Client->post('field_name')`
- `$this->Client->get('param_name')`
- `SphpBase::sphp_request()->session('sid')`

### Component Interaction
- Get Component: `$this->frtMain->getComponent('component_id')`
- Set Component Value: `$component->value = "new value";`

### Debugging
- Use `$this->debug->println($variable);` for console output during development.
- Print Array on Browser Console: `$this->debug->print_r($array_v);`
