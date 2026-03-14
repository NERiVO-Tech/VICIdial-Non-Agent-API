# VICIdial Non-Agent API Admin Panel v2.0

A Bootstrap 5 web-based admin panel for interacting with the **VICIdial Non-Agent API**. Provides a clean UI for all 16+ API functions, including a batch user creation tool.

---

## Features

- **All API Functions** — version, sounds_list, moh_list, vm_list, blind_monitor, agent_ingroup_info, recording_lookup, did_log_export, add_lead, update_lead, add_user, add_phone, update_phone, add_phone_alias, update_phone_alias, add_list, update_list
- **Dynamic Forms** — Required, Settings, and Optional fields rendered in separate fieldsets per function
- **Batch Add Users** — Create multiple users via Range mode (e.g. `agent001` → `agent050`) or List mode (paste usernames line by line)
- **Dark / Light Theme** — Toggle with sun/moon icon, preference saved in localStorage
- **Collapsible Connection Settings** — Hidden by default, toggle with the gear ⚙️ icon for a cleaner UI
- **CORS Proxy** — Built-in `proxy.php` routes API requests server-side via cURL, avoiding browser CORS restrictions
- **Smart Response Rendering** — Auto-detects HTML in API responses and renders formatted HTML; plain text responses display as-is
- **Responsive** — Collapsible sidebar for mobile devices
- **Single File UI** — No build step, no npm dependencies (CDN-loaded Bootstrap)

---

## What's New in v2.0

| Feature | Description |
|---------|-------------|
| **Dark / Light Theme** | Sun/moon toggle in top-right corner, persisted in localStorage |
| **Batch List Mode** | New "List" tab in Batch Add Users — paste usernames line by line instead of using a range |
| **Collapsible Settings** | Connection Settings hidden by default, toggled via gear ⚙️ button |
| **CORS Proxy** | New `proxy.php` — all API calls route server-side to bypass CORS |
| **HTML Response Rendering** | API responses containing HTML tags are rendered as formatted HTML |

---

## Requirements

- A web server with **PHP** and **cURL** enabled (Apache, Nginx, XAMPP, Laragon, etc.)
- A running **VICIdial** instance with the Non-Agent API enabled (`/vicidial/non_agent_api.php`)
- A valid VICIdial admin user account with API access and appropriate permissions

---

## Installation

1. Copy `index.php` and `proxy.php` to any directory served by your web server.
2. Open it in a browser.

```bash
# Example with PHP's built-in server:
php -S localhost:8080
```

Then visit `http://localhost:8080/` in your browser.

---

## File Structure

```
vc-api/
├── index.php       # Main admin panel (HTML + Bootstrap + JS)
├── proxy.php       # Server-side CORS proxy (PHP + cURL)
└── README.md       # This file
```

---

## Usage

### 1. Connection Settings

Click the **gear ⚙️ icon** in the top-right corner to reveal the connection fields:

| Field | Description |
|-------|-------------|
| **Server Domain / IP** | Hostname or IP of your VICIdial server. Select `http://` or `https://` from the dropdown. |
| **Admin User** | A valid VICIdial user with API permissions (e.g. `6666`) |
| **Admin Pass** | The password for that user |

### 2. Selecting a Function

Click any function in the **sidebar menu**, organized into sections:

- **System** — Version, Sounds List, MOH List, Voicemail List
- **Monitoring** — Blind Monitor, Agent Ingroup Info
- **Recordings & Logs** — Recording Lookup, DID Log Export
- **Leads** — Add Lead, Update Lead
- **Users** — Add User, Batch Add Users
- **Phones** — Add Phone, Update Phone, Add Phone Alias, Update Phone Alias
- **Lists** — Add List, Update List

### 3. Filling in Parameters

Each function shows parameters in separate fieldsets:

- **Required Fields** (red asterisk) — Must be filled
- **Settings Fields** — Control behavior (search method, format, etc.)
- **Optional Fields** — Additional data, can be left blank

Click **Execute** to send the request. The response appears below — HTML responses are rendered formatted, plain text responses show as-is.

### 4. Batch Add Users

Two input modes available via tabs:

**Range Mode:**
- Enter `From Agent User` (e.g. `agent001`) and `To Agent User` (e.g. `agent050`)
- Auto-generates users with zero-padded incrementing suffixes
- `agent_full_name` auto-generated as `agent 001`, `agent 002`, etc.

**List Mode:**
- Paste or type one username per line in the textarea
- `agent_full_name` auto-generated from the username (underscores/hyphens become spaces)
- Blank lines are ignored

Common fields (Agent Pass, Level, Group, optional fields) apply to all users. Live progress bar and log show success/error for each. Click **Stop** to abort mid-batch.

### 5. Theme Toggle

Click the **sun/moon icon** in the top-right to switch between dark and light themes. Saved in localStorage.

---

## CORS Proxy

All API requests are routed through `proxy.php` to avoid browser CORS restrictions:

```
Browser → proxy.php (your server) → VICIdial API → response back
```

This means you can host the panel on a completely different domain from your VICIdial server. No VICIdial server changes needed.

---

## API Reference

Implements the VICIdial Non-Agent API as documented in:
[NON-AGENT_API.txt](https://raw.githubusercontent.com/inktel/Vicidial/refs/heads/master/docs/NON-AGENT_API.txt)

---

## Notes

- **Security**: API credentials are sent as URL parameters through the proxy. Use HTTPS in production. Do not expose this panel publicly without access controls.
- **cURL Required**: `proxy.php` requires PHP cURL extension (enabled by default on most servers).
- **No Build Step**: The `.php` extension is needed for the proxy. The UI is pure HTML/CSS/JS.

---

## License

This project is provided as-is for internal use with VICIdial deployments.
