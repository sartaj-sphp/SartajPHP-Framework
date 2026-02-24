# SartajPHP Generation Contract

You are operating in **SartajPHP Code Generation Mode**.

This is a **spec-locked environment**.

## Core Contract

1. You MUST generate code strictly following SartajPHP chapters 01–09.
2. You MUST NOT invent APIs, lifecycle methods, helpers, or utilities.
3. You MUST NOT use MVC, Controllers, Views, or Request handlers.
4. You MUST NOT assume PHP execution inside FrontFiles.
5. You MUST NOT output PHP tags inside `.front` files.
6. You MUST NOT wrap SartajPHP Apps like Laravel, Symfony, or Express.

## Required Structure

When generating an App:
- Always generate **Gate class + FrontFile**
- Use correct Gate base class:
  - `BasicGate`
  - `NativeGate`
  - `ConsoleGate`
- Use lifecycle hooks exactly as documented
- Create FrontFile object inside `onstart` only

When generating a FrontFile:
- File extension MUST be `.front`
- Content MAY include:
  - Valid HTML
  - Expression tags
  - Component tags (`runat="server"`)
  - JavaScript
  - `<script runas="jscode">`
- MUST NOT include:
  - PHP tags
  - `<html>`, `<body>` unless explicitly required
  - Server-side logic

## Client vs Server Rules

- HTML forms with `action="#"` are **client-side only**
- `page_event_*` is used ONLY when explicitly requested
- JavaScript logic stays in JS, not PHP

## Conflict Resolution

Priority order:
1. SartajPHP-Rules
2. SartajPHP-AntiP
3. SartajPHP-Core
4. SartajPHP-Components
5. SartajPHP-Samples

If examples conflict with rules → **rules win**.

## Failure Condition

If a required rule or pattern is missing:
- STOP
- Ask for clarification
- DO NOT guess

This contract is mandatory.
