# WP Background Task Manager (Demo)

This repository contains a small, self-contained WordPress plugin created to demonstrate a clean and reliable approach to running long-running background tasks using WP-Cron.

Most of my professional WordPress and plugin work over the years has been on private commercial and client repositories. This plugin is intended as a representative example of how I structure, implement, and reason about background processing in WordPress rather than as a production-ready release.

---

## What this plugin demonstrates

The focus of this plugin is **architecture and execution flow**, not features.

Specifically, it demonstrates:

- Chunked background task execution using WP-Cron
- Persistent task state stored via the Options API
- Safe, resumable execution across requests
- Defensive PHP with predictable control flow
- Clear separation of responsibilities between components
- Simple file-based logging
- A minimal WordPress admin UI with secure AJAX actions

The task itself is intentionally lightweight and simulates work rather than performing real backups or file operations.

---

## High-level architecture

The plugin is structured around a few clearly defined responsibilities:

- **Task Manager**  
  Owns task lifecycle and state (start, increment, cancel, complete).

- **Cron Runner**  
  Executes one unit of work per run and reschedules itself only when required.

- **Logger**  
  Writes human-readable log output to a file in the uploads directory.

- **Admin Page**  
  Provides a minimal interface to start and cancel tasks and view current state.

This mirrors patterns commonly used in real-world WordPress plugins that need to handle long-running or resource-intensive processes safely.

---

## How it works (briefly)

1. A task is started from the admin page.
2. Initial state is persisted using the Options API.
3. A single WP-Cron event is scheduled.
4. Each cron run processes one step and updates state.
5. The task automatically completes or can be cancelled safely.
6. Progress and completion are logged to a file.

At no point does the plugin rely on long synchronous requests.

---

## Admin interface

The plugin adds a simple page under:

**Tools → Background Task Demo**

From there you can:

- Start a demo task
- Cancel a running task
- View the current task state

The interface is intentionally minimal and uses standard WordPress admin patterns.

---

## Notes

- This plugin is designed for demonstration and discussion purposes.
- It avoids unnecessary abstractions or frameworks.
- No client or proprietary code is included.

---

## License

GPL-2.0+
