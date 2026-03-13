# VICIdial Non-Agent API Admin Panel

A Bootstrap 5 web-based admin panel for interacting with the **VICIdial Non-Agent API**. Provides a clean UI for all 16+ API functions, including a batch user creation tool.

---

## Features

- **All API Functions** — version, sounds_list, moh_list, vm_list, blind_monitor, agent_ingroup_info, recording_lookup, did_log_export, add_lead, update_lead, add_user, add_phone, update_phone, add_phone_alias, update_phone_alias, add_list, update_list
- **Dynamic Forms** — Required, Settings, and Optional fields rendered in separate fieldsets per function
- **Batch Add Users** — Create multiple users at once by specifying a range (e.g. `agent001` → `agent050`)
- **Dark / Light Theme** — Toggle with localStorage persistence
- **Responsive** — Collapsible sidebar for mobile devices
- **Single File** — No build step, no dependencies to install (CDN-loaded Bootstrap)

---

## Requirements

- A web server that can serve `.php` files (Apache, Nginx, XAMPP, Laragon, etc.)
- A running **VICIdial** instance with the Non-Agent API enabled (`/vicidial/non_agent_api.php`)
- A valid VICIdial admin user account with API access and appropriate permissions

---

## Installation

1. Copy `index.php` to any directory served by your web server.
2. Open it in a browser.

```
# Example with PHP's built-in server:
php -S localhost:8080
```

Then visit `http://localhost:8080/` in your browser.

---

## Usage

### 1. Connection Settings

At the top of the page, fill in the three connection fields that are common to every API call:

| Field | Description |
|-------|-------------|
| **Server Domain / IP** | The hostname or IP of your VICIdial server (e.g. `192.168.1.100` or `dialer.example.com`). Select `http://` or `https://` from the dropdown. |
| **Admin User** | A valid VICIdial user with API permissions (e.g. `6666`) |
| **Admin Pass** | The password for that user |

These values are used to construct the API URL:
```
{protocol}{domain}/vicidial/non_agent_api.php?source=adminpanel&user={user}&pass={pass}&function={function}&...
```

### 2. Selecting a Function

Click any function in the **sidebar menu**. The sidebar is organized into sections:

- **System** — Version, Sounds List, MOH List, Voicemail List
- **Monitoring** — Blind Monitor, Agent Ingroup Info
- **Recordings & Logs** — Recording Lookup, DID Log Export
- **Leads** — Add Lead, Update Lead
- **Users** — Add User, Batch Add Users
- **Phones** — Add Phone, Update Phone, Add Phone Alias, Update Phone Alias
- **Lists** — Add List, Update List

### 3. Filling in Parameters

Each function shows its parameters in separate fieldsets:

- **Required Fields** (red asterisk) — Must be filled for the API call to succeed
- **Settings Fields** — Control behavior (e.g. search method, export format)
- **Optional Fields** — Additional data fields that can be left blank

Click **Execute** to send the request. The raw API response appears in the **Response** area below.

### 4. Batch Add Users

The **Batch Add Users** function (under Users in the sidebar) lets you create multiple users in one go:

1. Enter a **From Agent User** (e.g. `agent001`) and **To Agent User** (e.g. `agent050`)
2. Fill in the common required fields: **Agent Pass**, **Agent User Level**, **Agent User Group**
3. Optionally fill in Phone Login, Phone Pass, Hotkeys, Voicemail ID, Email, Custom fields
4. Click **Run Batch**

**How it works:**
- The panel parses the prefix and numeric suffix from both fields (e.g. prefix = `agent`, from = `001`, to = `050`)
- It iterates from the start number to the end number, zero-padded to match the original length
- For each user, `agent_user` is set to `agent001`, `agent002`, ... `agent050`
- `agent_full_name` is auto-generated as `agent 001`, `agent 002`, etc.
- All other fields remain the same across all users
- Each user is created via a separate API call (JavaScript `fetch`)
- A **live progress bar** and **log** show success/error for each user
- Click **Stop** to abort mid-batch

### 5. Theme Toggle

Click the **sun/moon icon** in the top-right corner to switch between dark and light themes. Your preference is saved in the browser's localStorage.

---

## API Reference

This panel implements the VICIdial Non-Agent API as documented in:

[NON-AGENT_API.txt](NON-AGENT_API.txt)

The API endpoint used is:
```
/vicidial/non_agent_api.php
```

All requests are GET requests sent directly from the browser via JavaScript `fetch()`.

---

## Notes

- **CORS**: If your VICIdial server and this panel are on different domains, you may need to configure CORS headers on the VICIdial server, or host this panel on the same server.
- **Security**: API credentials are sent as URL parameters. Use HTTPS in production. Do not expose this panel to the public internet without proper access controls.
- **No server-side logic**: This file is pure HTML/CSS/JS. The `.php` extension is only for convenience — it can be renamed to `.html` and will work the same way.

---

## License

This project is provided as-is for internal use with VICIdial deployments.
