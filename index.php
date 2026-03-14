<!DOCTYPE html>
<html lang="en" data-bs-theme="dark" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VICIdial Non-Agent API Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --accent: #6f42c1;
            --accent-hover: #7e55cc;
            --sidebar-width: 280px;
        }
        * { font-family: 'Inter', sans-serif; }

        /* ========== DARK THEME (default) ========== */
        [data-theme="dark"] {
            --bg-body: #0d1117;
            --text-primary: #c9d1d9;
            --text-secondary: #8b949e;
            --text-heading: #fff;
            --sidebar-bg: linear-gradient(180deg, #161b22 0%, #0d1117 100%);
            --sidebar-border: #21262d;
            --sidebar-section-title: #484f58;
            --sidebar-link: #8b949e;
            --sidebar-link-hover-bg: #161b22;
            --sidebar-link-hover-color: #c9d1d9;
            --card-bg: #161b22;
            --card-border: #21262d;
            --fieldset-bg: #0d1117;
            --input-bg: #0d1117;
            --input-border: #21262d;
            --input-color: #c9d1d9;
            --input-focus-bg: #0d1117;
            --response-color: #7ee787;
            --log-color: #c9d1d9;
            --scrollbar-thumb: #30363d;
            --progress-track: #21262d;
            --batch-bg: rgba(111,66,193,.04);
        }

        /* ========== LIGHT THEME ========== */
        [data-theme="light"] {
            --bg-body: #f6f8fa;
            --text-primary: #24292f;
            --text-secondary: #57606a;
            --text-heading: #1b1f23;
            --sidebar-bg: linear-gradient(180deg, #ffffff 0%, #f6f8fa 100%);
            --sidebar-border: #d0d7de;
            --sidebar-section-title: #8b949e;
            --sidebar-link: #57606a;
            --sidebar-link-hover-bg: #f3f4f6;
            --sidebar-link-hover-color: #24292f;
            --card-bg: #ffffff;
            --card-border: #d0d7de;
            --fieldset-bg: #f6f8fa;
            --input-bg: #ffffff;
            --input-border: #d0d7de;
            --input-color: #24292f;
            --input-focus-bg: #ffffff;
            --response-color: #116329;
            --log-color: #24292f;
            --scrollbar-thumb: #afb8c1;
            --progress-track: #d0d7de;
            --batch-bg: rgba(111,66,193,.06);
        }

        body { background: var(--bg-body); color: var(--text-primary); min-height: 100vh; transition: background .3s ease, color .3s ease; }

        /* ---------- Sidebar ---------- */
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            overflow-y: auto; z-index: 1040;
            transition: transform .3s ease, background .3s ease;
        }
        .sidebar .brand {
            padding: 1.25rem 1.5rem;
            font-size: 1.2rem; font-weight: 700;
            color: var(--text-heading); border-bottom: 1px solid var(--sidebar-border);
            display: flex; align-items: center; gap: .6rem;
        }
        .sidebar .brand i { color: var(--accent); font-size: 1.4rem; }
        .sidebar .nav-section {
            padding: .5rem 0; border-bottom: 1px solid var(--sidebar-border);
        }
        .sidebar .nav-section-title {
            padding: .5rem 1.5rem; font-size: .7rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: .08em; color: var(--sidebar-section-title);
        }
        .sidebar .nav-link {
            display: flex; align-items: center; gap: .6rem;
            padding: .5rem 1.5rem; color: var(--sidebar-link);
            font-size: .85rem; cursor: pointer;
            border-left: 3px solid transparent;
            transition: all .15s ease;
        }
        .sidebar .nav-link:hover { background: var(--sidebar-link-hover-bg); color: var(--sidebar-link-hover-color); }
        .sidebar .nav-link.active {
            color: var(--text-heading); background: rgba(111,66,193,.08);
            border-left-color: var(--accent);
        }

        /* ---------- Main ---------- */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem 2.5rem;
        }

        /* ---------- Cards ---------- */
        .glass-card {
            background: var(--card-bg); border: 1px solid var(--card-border);
            border-radius: 12px; padding: 1.5rem;
            transition: background .3s ease, border-color .3s ease;
        }
        .fieldset-card {
            background: var(--fieldset-bg); border: 1px solid var(--card-border);
            border-radius: 10px; padding: 1.25rem 1.5rem;
            margin-bottom: 1rem;
            transition: background .3s ease, border-color .3s ease;
        }
        .fieldset-card legend {
            font-size: .8rem; font-weight: 600; text-transform: uppercase;
            letter-spacing: .06em; color: var(--accent); padding: 0 .5rem;
            float: none; width: auto;
        }

        /* ---------- Form ---------- */
        .form-control, .form-select {
            background: var(--input-bg); border: 1px solid var(--input-border); color: var(--input-color);
            border-radius: 8px; font-size: .85rem;
            transition: background .3s ease, border-color .3s ease, color .3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--accent); box-shadow: 0 0 0 3px rgba(111,66,193,.15);
            background: var(--input-focus-bg); color: var(--input-color);
        }
        .form-label { font-size: .78rem; font-weight: 500; color: var(--text-secondary); margin-bottom: .25rem; }
        .form-text { font-size: .72rem; color: var(--text-secondary); }

        .btn-accent {
            background: var(--accent); color: #fff; border: none;
            border-radius: 8px; font-weight: 600; padding: .55rem 1.4rem;
            transition: all .2s ease;
        }
        .btn-accent:hover { background: var(--accent-hover); color: #fff; transform: translateY(-1px); }

        /* ---------- Response ---------- */
        #responseArea {
            background: var(--fieldset-bg); border: 1px solid var(--card-border);
            border-radius: 10px; padding: 1rem 1.25rem;
            font-family: 'Consolas','Courier New', monospace;
            font-size: .82rem; white-space: pre-wrap;
            max-height: 400px; overflow-y: auto;
            color: var(--response-color);
            transition: background .3s ease, border-color .3s ease, color .3s ease;
        }

        /* ---------- Batch ---------- */
        .batch-card {
            border: 1px dashed var(--accent); background: var(--batch-bg);
        }
        .progress-log {
            background: var(--fieldset-bg); border: 1px solid var(--card-border);
            border-radius: 8px; padding: .75rem 1rem;
            font-family: 'Consolas','Courier New',monospace;
            font-size: .78rem; max-height: 300px;
            overflow-y: auto; white-space: pre-wrap;
            color: var(--log-color);
            transition: background .3s ease, border-color .3s ease, color .3s ease;
        }
        .progress-log .log-success { color: #7ee787; }
        .progress-log .log-error { color: #f85149; }
        .progress-log .log-info { color: #58a6ff; }
        [data-theme="light"] .progress-log .log-success { color: #116329; }
        [data-theme="light"] .progress-log .log-error { color: #cf222e; }
        [data-theme="light"] .progress-log .log-info { color: #0550ae; }

        /* Badge pill */
        .badge-req { background: #da3633; font-size:.65rem; }
        .badge-opt { background: #1f6feb; font-size:.65rem; }
        .badge-set { background: #238636; font-size:.65rem; }

        /* ---------- Theme Toggle ---------- */
        .theme-toggle {
            width: 42px; height: 42px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            border: 1px solid var(--card-border);
            background: var(--card-bg); color: var(--text-primary);
            cursor: pointer; font-size: 1.1rem;
            transition: all .2s ease;
        }
        .theme-toggle:hover { border-color: var(--accent); color: var(--accent); transform: translateY(-1px); }

        /* Responsive */
        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--scrollbar-thumb); border-radius: 4px; }
    </style>
    <script>
        // Apply saved theme BEFORE render to prevent flash
        (function() {
            const saved = localStorage.getItem('vc-api-theme') || 'dark';
            document.documentElement.setAttribute('data-theme', saved);
            document.documentElement.setAttribute('data-bs-theme', saved);
        })();
    </script>
</head>
<body>

<!-- Mobile Toggle -->
<button class="btn btn-sm btn-outline-secondary d-lg-none position-fixed" style="top:10px;left:10px;z-index:1050" onclick="document.querySelector('.sidebar').classList.toggle('show')">
    <i class="bi bi-list"></i>
</button>

<!-- Sidebar -->
<nav class="sidebar" id="sidebar">
    <div class="brand"><i class="bi bi-telephone-inbound-fill"></i> VICIdial API</div>

    <div class="nav-section">
        <div class="nav-section-title">System</div>
        <a class="nav-link" data-fn="version"><i class="bi bi-info-circle"></i> Version</a>
        <a class="nav-link" data-fn="sounds_list"><i class="bi bi-music-note-list"></i> Sounds List</a>
        <a class="nav-link" data-fn="moh_list"><i class="bi bi-music-note-beamed"></i> MOH List</a>
        <a class="nav-link" data-fn="vm_list"><i class="bi bi-voicemail"></i> Voicemail List</a>
    </div>

    <div class="nav-section">
        <div class="nav-section-title">Monitoring</div>
        <a class="nav-link" data-fn="blind_monitor"><i class="bi bi-eye"></i> Blind Monitor</a>
        <a class="nav-link" data-fn="agent_ingroup_info"><i class="bi bi-person-badge"></i> Agent Ingroup Info</a>
    </div>

    <div class="nav-section">
        <div class="nav-section-title">Recordings & Logs</div>
        <a class="nav-link" data-fn="recording_lookup"><i class="bi bi-mic"></i> Recording Lookup</a>
        <a class="nav-link" data-fn="did_log_export"><i class="bi bi-journal-text"></i> DID Log Export</a>
    </div>

    <div class="nav-section">
        <div class="nav-section-title">Leads</div>
        <a class="nav-link" data-fn="add_lead"><i class="bi bi-person-plus"></i> Add Lead</a>
        <a class="nav-link" data-fn="update_lead"><i class="bi bi-person-gear"></i> Update Lead</a>
    </div>

    <div class="nav-section">
        <div class="nav-section-title">Users</div>
        <a class="nav-link" data-fn="add_user"><i class="bi bi-person-plus-fill"></i> Add User</a>
        <a class="nav-link" data-fn="add_user_batch"><i class="bi bi-people-fill"></i> Batch Add Users</a>
    </div>

    <div class="nav-section">
        <div class="nav-section-title">Phones</div>
        <a class="nav-link" data-fn="add_phone"><i class="bi bi-phone-fill"></i> Add Phone</a>
        <a class="nav-link" data-fn="update_phone"><i class="bi bi-phone"></i> Update Phone</a>
        <a class="nav-link" data-fn="add_phone_alias"><i class="bi bi-phone-vibrate"></i> Add Phone Alias</a>
        <a class="nav-link" data-fn="update_phone_alias"><i class="bi bi-phone-flip"></i> Update Phone Alias</a>
    </div>

    <div class="nav-section">
        <div class="nav-section-title">Lists</div>
        <a class="nav-link" data-fn="add_list"><i class="bi bi-card-list"></i> Add List</a>
        <a class="nav-link" data-fn="update_list"><i class="bi bi-list-check"></i> Update List</a>
    </div>
</nav>

<!-- Main Content -->
<div class="main-content">

    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold mb-1" id="pageTitle"><i class="bi bi-telephone-inbound-fill text-purple me-2" style="color:var(--accent)"></i>VICIdial Non-Agent API Panel</h3>
            <p class="text-secondary mb-0 small">Select a function from the sidebar to get started.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="theme-toggle" id="settingsToggle" onclick="document.getElementById('connSettingsCollapse').classList.toggle('show')" title="Connection Settings">
                <i class="bi bi-gear-fill"></i>
            </button>
            <button class="theme-toggle" id="themeToggle" onclick="toggleTheme()" title="Toggle Light/Dark Theme">
                <i class="bi" id="themeIcon"></i>
            </button>
        </div>
    </div>

    <!-- Connection Settings (Collapsible) -->
    <div class="collapse mb-4" id="connSettingsCollapse">
        <div class="glass-card">
            <h6 class="fw-semibold mb-3"><i class="bi bi-plug-fill me-2" style="color:var(--accent)"></i>Connection Settings</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Server Domain / IP <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <select class="form-select" id="connProtocol" style="max-width:100px;">
                            <option value="http://">http://</option>
                            <option value="https://">https://</option>
                        </select>
                        <input type="text" class="form-control" id="connDomain" placeholder="192.168.1.100">
                    </div>
                    <div class="form-text text-secondary">Server hostname or IP address</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Admin User <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="connUser" placeholder="6666">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Admin Pass <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="connPass" placeholder="••••••">
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePass()"><i class="bi bi-eye"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dynamic Form Area -->
    <div id="functionFormArea" style="display:none;">
        <div class="glass-card mb-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-semibold mb-0"><i class="bi bi-sliders me-2" style="color:var(--accent)"></i><span id="formTitle">Function Parameters</span></h6>
                <span class="badge bg-secondary" id="fnBadge"></span>
            </div>

            <form id="apiForm" onsubmit="return false;">

                <!-- Required Fields Fieldset -->
                <fieldset class="fieldset-card" id="requiredFieldset" style="display:none;">
                    <legend><i class="bi bi-asterisk me-1"></i> Required Fields</legend>
                    <div class="row g-3" id="requiredFields"></div>
                </fieldset>

                <!-- Settings Fields Fieldset -->
                <fieldset class="fieldset-card" id="settingsFieldset" style="display:none;">
                    <legend><i class="bi bi-gear me-1"></i> Settings Fields</legend>
                    <div class="row g-3" id="settingsFields"></div>
                </fieldset>

                <!-- Optional / Editable Fields Fieldset -->
                <fieldset class="fieldset-card" id="optionalFieldset" style="display:none;">
                    <legend><i class="bi bi-sliders2 me-1"></i> Optional Fields</legend>
                    <div class="row g-3" id="optionalFields"></div>
                </fieldset>

                <div class="mt-3 d-flex gap-2">
                    <button type="button" class="btn btn-accent" id="btnSubmit" onclick="submitAPI()">
                        <i class="bi bi-send me-1"></i> Execute
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="clearForm()">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                    </button>
                </div>
            </form>
        </div>

        <!-- Response Area -->
        <div class="glass-card">
            <h6 class="fw-semibold mb-3"><i class="bi bi-terminal me-2" style="color:var(--accent)"></i>Response</h6>
            <div id="responseArea">Waiting for request...</div>
        </div>
    </div>

    <!-- Batch Add User Area (hidden by default) -->
    <div id="batchArea" style="display:none;">
        <div class="glass-card mb-4 batch-card">
            <h6 class="fw-semibold mb-1"><i class="bi bi-people-fill me-2" style="color:var(--accent)"></i>Batch Add Users</h6>
            <p class="text-secondary small mb-3">Create multiple users at once by specifying a user ID range. The numeric suffix will auto-increment and agent_full_name will be generated accordingly.</p>

            <form id="batchForm" onsubmit="return false;">
                <!-- User Input Mode Tabs -->
                <fieldset class="fieldset-card">
                    <legend><i class="bi bi-people me-1"></i> Agent Users</legend>
                    <ul class="nav nav-tabs mb-3" id="batchModeTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab-range" data-bs-toggle="tab" data-bs-target="#pane-range" type="button" role="tab" aria-controls="pane-range" aria-selected="true">
                                <i class="bi bi-arrow-left-right me-1"></i> Range
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-list" data-bs-toggle="tab" data-bs-target="#pane-list" type="button" role="tab" aria-controls="pane-list" aria-selected="false">
                                <i class="bi bi-list-ul me-1"></i> List
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="batchModeContent">
                        <!-- Range Tab -->
                        <div class="tab-pane fade show active" id="pane-range" role="tabpanel" aria-labelledby="tab-range">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">From Agent User <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="batchFromUser" placeholder="agent001">
                                    <div class="form-text text-secondary">Starting agent user (e.g. agent001)</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">To Agent User <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="batchToUser" placeholder="agent050">
                                    <div class="form-text text-secondary">Ending agent user (e.g. agent050)</div>
                                </div>
                            </div>
                        </div>
                        <!-- List Tab -->
                        <div class="tab-pane fade" id="pane-list" role="tabpanel" aria-labelledby="tab-list">
                            <label class="form-label">Agent Usernames <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="batchUserList" rows="8" placeholder="Enter one agent username per line, e.g.:
agent001
agent002
john_smith
jane_doe
operator10"></textarea>
                            <div class="form-text text-secondary">One username per line. agent_full_name will be auto-generated from the username. Blank lines are ignored.</div>
                        </div>
                    </div>
                </fieldset>

                <!-- Required Common Fields -->
                <fieldset class="fieldset-card">
                    <legend><i class="bi bi-asterisk me-1"></i> Required Common Fields</legend>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Agent Pass <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="batchAgentPass" placeholder="1234">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Agent User Level <span class="text-danger">*</span></label>
                            <select class="form-select" id="batchAgentLevel">
                                <option value="1">1</option><option value="2">2</option><option value="3">3</option>
                                <option value="4">4</option><option value="5">5</option><option value="6">6</option>
                                <option value="7">7</option><option value="8">8</option><option value="9">9</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Agent User Group <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="batchAgentGroup" placeholder="AGENTS">
                        </div>
                    </div>
                </fieldset>

                <!-- Optional Fields -->
                <fieldset class="fieldset-card">
                    <legend><i class="bi bi-sliders2 me-1"></i> Optional Fields</legend>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Phone Login</label>
                            <input type="text" class="form-control" id="batchPhoneLogin" placeholder="">
                            <div class="form-text text-secondary">Leave blank to skip</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Phone Pass</label>
                            <input type="text" class="form-control" id="batchPhonePass" placeholder="">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Hotkeys Active</label>
                            <select class="form-select" id="batchHotkeys">
                                <option value="">-- skip --</option>
                                <option value="0">0 - Inactive</option>
                                <option value="1">1 - Active</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Voicemail ID</label>
                            <input type="text" class="form-control" id="batchVoicemailId" placeholder="">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" id="batchEmail" placeholder="">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Custom One</label>
                            <input type="text" class="form-control" id="batchCustomOne" placeholder="">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Custom Two</label>
                            <input type="text" class="form-control" id="batchCustomTwo" placeholder="">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Custom Three</label>
                            <input type="text" class="form-control" id="batchCustomThree" placeholder="">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Custom Four</label>
                            <input type="text" class="form-control" id="batchCustomFour" placeholder="">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Custom Five</label>
                            <input type="text" class="form-control" id="batchCustomFive" placeholder="">
                        </div>
                    </div>
                </fieldset>

                <div class="d-flex gap-2 mt-3">
                    <button type="button" class="btn btn-accent" id="btnBatchRun" onclick="runBatch()">
                        <i class="bi bi-play-circle me-1"></i> Run Batch
                    </button>
                    <button type="button" class="btn btn-outline-danger" id="btnBatchStop" onclick="stopBatch()" style="display:none;">
                        <i class="bi bi-stop-circle me-1"></i> Stop
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="clearBatchLog()">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Clear Log
                    </button>
                </div>
            </form>
        </div>

        <!-- Batch Progress -->
        <div class="glass-card mb-4">
            <h6 class="fw-semibold mb-2"><i class="bi bi-activity me-2" style="color:var(--accent)"></i>Batch Progress</h6>
            <div class="progress mb-3" style="height:8px;background:#21262d;border-radius:6px;">
                <div class="progress-bar" id="batchProgress" role="progressbar" style="width:0%;background:var(--accent);border-radius:6px;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="d-flex justify-content-between small text-secondary mb-3">
                <span id="batchStatus">Idle</span>
                <span id="batchCounter">0 / 0</span>
            </div>
            <div class="progress-log" id="batchLog">Batch log will appear here...</div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// =============================================================================
//  FUNCTION DEFINITIONS
// =============================================================================
const API_FUNCTIONS = {
    version: {
        label: 'Version',
        desc: 'Shows version and build of the API, along with date/time and timezone.',
        required: [],
        settings: [],
        optional: []
    },
    sounds_list: {
        label: 'Sounds List',
        desc: 'Outputs a list of audio files from the audio store.',
        required: [],
        settings: [],
        optional: [
            { name:'format', label:'Format', type:'select', options:['','tab','link','selectframe'], hint:'Output format' },
            { name:'stage', label:'Stage (Sort)', type:'select', options:['','date','size','name'], hint:'How to sort output' },
            { name:'comments', label:'Comments', type:'text', hint:'Name of the field to populate' }
        ]
    },
    moh_list: {
        label: 'MOH List',
        desc: 'Outputs a list of music on hold classes in the system.',
        required: [],
        settings: [],
        optional: [
            { name:'format', label:'Format', type:'select', options:['','tab','link','selectframe'], hint:'Output format' },
            { name:'comments', label:'Comments', type:'text', hint:'Name of the field to populate' }
        ]
    },
    vm_list: {
        label: 'Voicemail List',
        desc: 'Outputs a list of voicemail boxes in the system.',
        required: [],
        settings: [],
        optional: [
            { name:'format', label:'Format', type:'select', options:['','tab','link','selectframe'], hint:'Output format' },
            { name:'comments', label:'Comments', type:'text', hint:'Name of the field to populate' }
        ]
    },
    blind_monitor: {
        label: 'Blind Monitor',
        desc: 'Calls user-defined phone and places them in session as blind monitor.',
        required: [
            { name:'phone_login', label:'Phone Login', type:'text', hint:'Alpha-numeric, no spaces or special characters' },
            { name:'session_id', label:'Session ID', type:'text', hint:'All numbers, 7 digits' },
            { name:'server_ip', label:'Server IP', type:'text', hint:'All numbers and dots, max 15 chars' },
            { name:'source', label:'Source', type:'text', hint:'Max 20 characters' }
        ],
        settings: [
            { name:'stage', label:'Stage', type:'select', options:['MONITOR','BARGE','HIJACK'], hint:'Monitor type' }
        ],
        optional: []
    },
    agent_ingroup_info: {
        label: 'Agent Ingroup Info',
        desc: 'Shows in-group and outbound auto-dial info for a logged-in agent.',
        required: [
            { name:'agent_user', label:'Agent User', type:'text', hint:'2-20 characters' },
            { name:'source', label:'Source', type:'text', hint:'Max 20 characters' }
        ],
        settings: [
            { name:'stage', label:'Stage', type:'select', options:['','info','change','text'], hint:'Display mode' }
        ],
        optional: []
    },
    recording_lookup: {
        label: 'Recording Lookup',
        desc: 'Looks up recordings based upon user and date or lead_id.',
        required: [
            { name:'agent_user', label:'Agent User', type:'text', hint:'2-20 characters' },
            { name:'lead_id', label:'Lead ID', type:'text', hint:'1-10 digits' },
            { name:'date', label:'Date', type:'date', hint:'YYYY-MM-DD format' },
            { name:'uniqueid', label:'Unique ID', type:'text', hint:'Uniqueid of the call' }
        ],
        settings: [
            { name:'stage', label:'Stage (Format)', type:'select', options:['','csv','tab','pipe'], hint:'Export format' },
            { name:'header', label:'Header', type:'select', options:['','YES','NO'], hint:'Include header row' }
        ],
        optional: []
    },
    did_log_export: {
        label: 'DID Log Export',
        desc: 'Exports all calls inbound to a DID for one day.',
        required: [
            { name:'phone_number', label:'Phone Number (DID)', type:'text', hint:'2-20 characters' },
            { name:'date', label:'Date', type:'date', hint:'YYYY-MM-DD format' }
        ],
        settings: [
            { name:'stage', label:'Stage (Format)', type:'select', options:['','csv','tab','pipe'], hint:'Export format' },
            { name:'header', label:'Header', type:'select', options:['','YES','NO'], hint:'Include header row' }
        ],
        optional: []
    },
    add_lead: {
        label: 'Add Lead',
        desc: 'Adds a new lead to the vicidial_list table with several fields and options.',
        required: [
            { name:'phone_number', label:'Phone Number', type:'text', hint:'All numbers, 6-16 digits' },
            { name:'phone_code', label:'Phone Code', type:'text', hint:'1-4 digits, defaults to 1' },
            { name:'list_id', label:'List ID', type:'text', hint:'3-12 digits, defaults to 999' },
            { name:'source', label:'Source', type:'text', hint:'Max 20 characters' }
        ],
        settings: [
            { name:'dnc_check', label:'DNC Check', type:'select', options:['N','Y','AREACODE'], hint:'Default N' },
            { name:'campaign_dnc_check', label:'Campaign DNC Check', type:'select', options:['N','Y','AREACODE'], hint:'Default N' },
            { name:'campaign_id', label:'Campaign ID', type:'text', hint:'2-8 chars, required for campaign_dnc_check/callbacks' },
            { name:'add_to_hopper', label:'Add to Hopper', type:'select', options:['N','Y'], hint:'Default N' },
            { name:'hopper_priority', label:'Hopper Priority', type:'text', hint:'-99 to 99' },
            { name:'hopper_local_call_time_check', label:'Hopper Local Call Time Check', type:'select', options:['N','Y'], hint:'Default N' },
            { name:'duplicate_check', label:'Duplicate Check', type:'text', hint:'e.g. DUPLIST-DUPNAMEPHONELIST' },
            { name:'usacan_prefix_check', label:'USA/CAN Prefix Check', type:'select', options:['N','Y'], hint:'Default N' },
            { name:'usacan_areacode_check', label:'USA/CAN Areacode Check', type:'select', options:['N','Y'], hint:'Default N' },
            { name:'custom_fields', label:'Custom Fields', type:'select', options:['N','Y'], hint:'Default N' },
            { name:'tz_method', label:'TZ Method', type:'select', options:['','POSTAL','TZCODE'], hint:'Timezone lookup method' },
            { name:'callback', label:'Callback', type:'select', options:['N','Y'], hint:'Default N' },
            { name:'callback_status', label:'Callback Status', type:'text', hint:'1-6 chars, default CALLBK' },
            { name:'callback_datetime', label:'Callback Datetime', type:'text', hint:'YYYY-MM-DD+HH:MM:SS or NOW' },
            { name:'callback_type', label:'Callback Type', type:'select', options:['ANYONE','USERONLY'], hint:'Default ANYONE' },
            { name:'callback_user', label:'Callback User', type:'text', hint:'User ID for USERONLY callback' },
            { name:'callback_comments', label:'Callback Comments', type:'text', hint:'Optional comments' }
        ],
        optional: [
            { name:'vendor_lead_code', label:'Vendor Lead Code', type:'text', hint:'1-20 characters' },
            { name:'source_id', label:'Source ID', type:'text', hint:'1-50 characters' },
            { name:'gmt_offset_now', label:'GMT Offset Now', type:'text', hint:'Overridden by auto-lookup' },
            { name:'title', label:'Title', type:'text', hint:'1-4 characters' },
            { name:'first_name', label:'First Name', type:'text', hint:'1-30 characters' },
            { name:'middle_initial', label:'Middle Initial', type:'text', hint:'1 character' },
            { name:'last_name', label:'Last Name', type:'text', hint:'1-30 characters' },
            { name:'address1', label:'Address 1', type:'text', hint:'1-100 characters' },
            { name:'address2', label:'Address 2', type:'text', hint:'1-100 characters' },
            { name:'address3', label:'Address 3', type:'text', hint:'1-100 characters' },
            { name:'city', label:'City', type:'text', hint:'1-50 characters' },
            { name:'state', label:'State', type:'text', hint:'2 characters' },
            { name:'province', label:'Province', type:'text', hint:'1-50 characters' },
            { name:'postal_code', label:'Postal Code', type:'text', hint:'1-10 characters' },
            { name:'country_code', label:'Country Code', type:'text', hint:'3 characters' },
            { name:'gender', label:'Gender', type:'select', options:['U','M','F'], hint:'Default U' },
            { name:'date_of_birth', label:'Date of Birth', type:'date', hint:'YYYY-MM-DD' },
            { name:'alt_phone', label:'Alt Phone', type:'text', hint:'1-12 characters' },
            { name:'email', label:'Email', type:'text', hint:'1-70 characters' },
            { name:'security_phrase', label:'Security Phrase', type:'text', hint:'1-100 characters' },
            { name:'comments', label:'Comments', type:'text', hint:'1-255 characters' },
            { name:'multi_alt_phones', label:'Multi Alt Phones', type:'text', hint:'e.g. 7275551212_1_work!7275551213_1_home' },
            { name:'rank', label:'Rank', type:'text', hint:'1-5 digits' },
            { name:'owner', label:'Owner', type:'text', hint:'1-20 characters' }
        ]
    },
    update_lead: {
        label: 'Update Lead',
        desc: 'Updates lead information in vicidial_list and associated custom table.',
        required: [
            { name:'lead_id', label:'Lead ID', type:'text', hint:'1-9 digits (or use vendor_lead_code/phone_number)' },
            { name:'vendor_lead_code', label:'Vendor Lead Code', type:'text', hint:'Alternative to lead_id' },
            { name:'phone_number', label:'Phone Number', type:'text', hint:'Alternative to lead_id' },
            { name:'source', label:'Source', type:'text', hint:'Max 20 characters' }
        ],
        settings: [
            { name:'search_method', label:'Search Method', type:'text', hint:'LEAD_ID, VENDOR_LEAD_CODE, PHONE_NUMBER (combinable)' },
            { name:'search_location', label:'Search Location', type:'select', options:['SYSTEM','LIST','CAMPAIGN'], hint:'Default SYSTEM' },
            { name:'insert_if_not_found', label:'Insert If Not Found', type:'select', options:['N','Y'], hint:'Default N' },
            { name:'records', label:'Records', type:'text', hint:'Number of records to update' },
            { name:'custom_fields', label:'Custom Fields', type:'select', options:['N','Y'], hint:'Default N' },
            { name:'no_update', label:'No Update (Check Only)', type:'select', options:['N','Y'], hint:'Default N' },
            { name:'delete_lead', label:'Delete Lead', type:'select', options:['N','Y'], hint:'Default N' },
            { name:'reset_lead', label:'Reset Lead', type:'select', options:['N','Y'], hint:'Default N' },
            { name:'callback', label:'Callback', type:'select', options:['N','Y','REMOVE'], hint:'Default N' },
            { name:'callback_status', label:'Callback Status', type:'text', hint:'1-6 chars, default CALLBK' },
            { name:'callback_datetime', label:'Callback Datetime', type:'text', hint:'YYYY-MM-DD+HH:MM:SS or NOW' },
            { name:'callback_type', label:'Callback Type', type:'select', options:['ANYONE','USERONLY'], hint:'Default ANYONE' },
            { name:'callback_user', label:'Callback User', type:'text', hint:'User ID for USERONLY' },
            { name:'callback_comments', label:'Callback Comments', type:'text', hint:'Optional comments' }
        ],
        optional: [
            { name:'user_field', label:'User Field', type:'text', hint:'1-20 chars (updates user field)' },
            { name:'list_id_field', label:'List ID Field', type:'text', hint:'3-12 digits (updates list_id)' },
            { name:'status', label:'Status', type:'text', hint:'1-6 characters' },
            { name:'gmt_offset_now', label:'GMT Offset Now', type:'text', hint:'Overridden by auto-lookup' },
            { name:'title', label:'Title', type:'text', hint:'1-4 characters' },
            { name:'first_name', label:'First Name', type:'text', hint:'1-30 characters' },
            { name:'middle_initial', label:'Middle Initial', type:'text', hint:'1 character' },
            { name:'last_name', label:'Last Name', type:'text', hint:'1-30 characters' },
            { name:'address1', label:'Address 1', type:'text', hint:'1-100 characters' },
            { name:'address2', label:'Address 2', type:'text', hint:'1-100 characters' },
            { name:'address3', label:'Address 3', type:'text', hint:'1-100 characters' },
            { name:'city', label:'City', type:'text', hint:'1-50 characters' },
            { name:'state', label:'State', type:'text', hint:'2 characters' },
            { name:'province', label:'Province', type:'text', hint:'1-50 characters' },
            { name:'postal_code', label:'Postal Code', type:'text', hint:'1-10 characters' },
            { name:'country_code', label:'Country Code', type:'text', hint:'3 characters' },
            { name:'gender', label:'Gender', type:'select', options:['U','M','F'], hint:'Default U' },
            { name:'date_of_birth', label:'Date of Birth', type:'date', hint:'YYYY-MM-DD' },
            { name:'alt_phone', label:'Alt Phone', type:'text', hint:'1-12 characters' },
            { name:'email', label:'Email', type:'text', hint:'1-70 characters' },
            { name:'security_phrase', label:'Security Phrase', type:'text', hint:'1-100 characters' },
            { name:'comments', label:'Comments', type:'text', hint:'1-255 characters' },
            { name:'rank', label:'Rank', type:'text', hint:'1-5 digits' },
            { name:'owner', label:'Owner', type:'text', hint:'1-20 characters' },
            { name:'called_count', label:'Called Count', type:'text', hint:'Digits only' }
        ]
    },
    add_user: {
        label: 'Add User',
        desc: 'Adds a user to the system.',
        required: [
            { name:'agent_user', label:'Agent User', type:'text', hint:'2-20 chars (or AUTOGENERATED)' },
            { name:'agent_pass', label:'Agent Pass', type:'text', hint:'1-20 characters' },
            { name:'agent_user_level', label:'Agent User Level', type:'select', options:['1','2','3','4','5','6','7','8','9'], hint:'1-9' },
            { name:'agent_full_name', label:'Agent Full Name', type:'text', hint:'1-50 characters' },
            { name:'agent_user_group', label:'Agent User Group', type:'text', hint:'1-20 chars, must be valid group' }
        ],
        settings: [],
        optional: [
            { name:'phone_login', label:'Phone Login', type:'text', hint:'1-20 characters' },
            { name:'phone_pass', label:'Phone Pass', type:'text', hint:'1-20 characters' },
            { name:'hotkeys_active', label:'Hotkeys Active', type:'select', options:['','0','1'], hint:'0 or 1' },
            { name:'voicemail_id', label:'Voicemail ID', type:'text', hint:'1-10 digits' },
            { name:'email', label:'Email', type:'text', hint:'1-100 characters' },
            { name:'custom_one', label:'Custom One', type:'text', hint:'1-100 characters' },
            { name:'custom_two', label:'Custom Two', type:'text', hint:'1-100 characters' },
            { name:'custom_three', label:'Custom Three', type:'text', hint:'1-100 characters' },
            { name:'custom_four', label:'Custom Four', type:'text', hint:'1-100 characters' },
            { name:'custom_five', label:'Custom Five', type:'text', hint:'1-100 characters' }
        ]
    },
    add_phone: {
        label: 'Add Phone',
        desc: 'Adds a phone to the system.',
        required: [
            { name:'extension', label:'Extension', type:'text', hint:'2-100 characters' },
            { name:'dialplan_number', label:'Dialplan Number', type:'text', hint:'1-20 digits' },
            { name:'voicemail_id', label:'Voicemail ID', type:'text', hint:'1-10 digits' },
            { name:'phone_login', label:'Phone Login', type:'text', hint:'1-20 characters' },
            { name:'phone_pass', label:'Phone Pass', type:'text', hint:'1-20 characters' },
            { name:'server_ip', label:'Server IP', type:'text', hint:'7-15 characters, valid server IP' },
            { name:'protocol', label:'Protocol', type:'select', options:['SIP','IAX2','Zap','EXTERNAL'], hint:'Phone protocol' },
            { name:'registration_password', label:'Registration Password', type:'text', hint:'1-20 characters' },
            { name:'phone_full_name', label:'Phone Full Name', type:'text', hint:'1-50 characters' },
            { name:'local_gmt', label:'Local GMT', type:'text', hint:'Timezone, default -5.00' },
            { name:'outbound_cid', label:'Outbound CID', type:'text', hint:'1-20 digits' }
        ],
        settings: [],
        optional: [
            { name:'phone_context', label:'Phone Context', type:'text', hint:'Default is "default"' },
            { name:'email', label:'Email', type:'text', hint:'1-100 characters' }
        ]
    },
    update_phone: {
        label: 'Update Phone',
        desc: 'Updates or deletes an existing phone record in the system.',
        required: [
            { name:'extension', label:'Extension', type:'text', hint:'2-100 characters' },
            { name:'server_ip', label:'Server IP', type:'text', hint:'7-15 characters' }
        ],
        settings: [
            { name:'delete_phone', label:'Delete Phone', type:'select', options:['N','Y'], hint:'Default N' }
        ],
        optional: [
            { name:'dialplan_number', label:'Dialplan Number', type:'text', hint:'1-20 digits' },
            { name:'voicemail_id', label:'Voicemail ID', type:'text', hint:'1-10 digits' },
            { name:'phone_login', label:'Phone Login', type:'text', hint:'1-20 characters' },
            { name:'phone_pass', label:'Phone Pass', type:'text', hint:'1-20 characters' },
            { name:'protocol', label:'Protocol', type:'select', options:['','SIP','IAX2','Zap','EXTERNAL'], hint:'Phone protocol' },
            { name:'registration_password', label:'Registration Password', type:'text', hint:'1-20 characters' },
            { name:'phone_full_name', label:'Phone Full Name', type:'text', hint:'1-50 characters' },
            { name:'local_gmt', label:'Local GMT', type:'text', hint:'Timezone, default -5.00' },
            { name:'outbound_cid', label:'Outbound CID', type:'text', hint:'1-20 digits' },
            { name:'phone_context', label:'Phone Context', type:'text', hint:'Default is "default"' },
            { name:'email', label:'Email', type:'text', hint:'1-100 characters' }
        ]
    },
    add_phone_alias: {
        label: 'Add Phone Alias',
        desc: 'Adds a phone alias record to the system.',
        required: [
            { name:'alias_id', label:'Alias ID', type:'text', hint:'2-20 characters' },
            { name:'phone_logins', label:'Phone Logins', type:'text', hint:'2-255 chars (comma-separated)' },
            { name:'alias_name', label:'Alias Name', type:'text', hint:'1-50 characters' }
        ],
        settings: [],
        optional: []
    },
    update_phone_alias: {
        label: 'Update Phone Alias',
        desc: 'Updates or deletes an existing phone alias record in the system.',
        required: [
            { name:'alias_id', label:'Alias ID', type:'text', hint:'2-20 characters' },
            { name:'phone_logins', label:'Phone Logins', type:'text', hint:'2-255 chars (comma-separated)' },
            { name:'alias_name', label:'Alias Name', type:'text', hint:'1-50 characters' }
        ],
        settings: [
            { name:'delete_alias', label:'Delete Alias', type:'select', options:['N','Y'], hint:'Default N' }
        ],
        optional: []
    },
    add_list: {
        label: 'Add List',
        desc: 'Adds a list to the system.',
        required: [
            { name:'list_id', label:'List ID', type:'text', hint:'2-14 digits' },
            { name:'list_name', label:'List Name', type:'text', hint:'6-30 characters' },
            { name:'campaign_id', label:'Campaign ID', type:'text', hint:'2-8 characters, must be valid' }
        ],
        settings: [],
        optional: [
            { name:'active', label:'Active', type:'select', options:['N','Y'], hint:'Default N' },
            { name:'outbound_cid', label:'Outbound CID', type:'text', hint:'6-20 digits' },
            { name:'script', label:'Script', type:'text', hint:'1-10 chars, must be valid' },
            { name:'am_message', label:'AM Message', type:'text', hint:'2-100 characters' },
            { name:'drop_inbound_group', label:'Drop Inbound Group', type:'text', hint:'1-10 chars, must be valid' },
            { name:'web_form_address', label:'Web Form Address', type:'text', hint:'6-100 characters' },
            { name:'web_form_address_two', label:'Web Form Address Two', type:'text', hint:'6-100 characters' },
            { name:'reset_time', label:'Reset Time', type:'text', hint:'4-100 chars, 24-hour groups (e.g. 0900-1700)' }
        ]
    },
    update_list: {
        label: 'Update List',
        desc: 'Updates list settings in the system, reset leads in list, delete list.',
        required: [
            { name:'list_id', label:'List ID', type:'text', hint:'2-14 digits' },
            { name:'source', label:'Source', type:'text', hint:'Max 20 characters' }
        ],
        settings: [
            { name:'insert_if_not_found', label:'Insert If Not Found', type:'select', options:['N','Y'], hint:'Default N' },
            { name:'reset_list', label:'Reset List', type:'select', options:['N','Y'], hint:'Default N' },
            { name:'delete_list', label:'Delete List', type:'select', options:['N','Y'], hint:'Default N' },
            { name:'delete_leads', label:'Delete Leads', type:'select', options:['N','Y'], hint:'Default N' }
        ],
        optional: [
            { name:'list_name', label:'List Name', type:'text', hint:'6-30 characters' },
            { name:'campaign_id', label:'Campaign ID', type:'text', hint:'2-8 characters' },
            { name:'active', label:'Active', type:'select', options:['N','Y'], hint:'Default N' },
            { name:'outbound_cid', label:'Outbound CID', type:'text', hint:'6-20 digits' },
            { name:'script', label:'Script', type:'text', hint:'1-10 characters' },
            { name:'am_message', label:'AM Message', type:'text', hint:'2-100 characters' },
            { name:'drop_inbound_group', label:'Drop Inbound Group', type:'text', hint:'1-10 characters' },
            { name:'web_form_address', label:'Web Form Address', type:'text', hint:'6-100 characters' },
            { name:'web_form_address_two', label:'Web Form Address Two', type:'text', hint:'6-100 characters' },
            { name:'reset_time', label:'Reset Time', type:'text', hint:'4-100 chars, 24-hour groups' }
        ]
    }
};

// =============================================================================
//  STATE
// =============================================================================
let currentFn = null;
let batchRunning = false;
let batchAbort = false;

// =============================================================================
//  THEME TOGGLE
// =============================================================================
function getTheme() {
    return localStorage.getItem('vc-api-theme') || 'dark';
}
function setTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    document.documentElement.setAttribute('data-bs-theme', theme);
    localStorage.setItem('vc-api-theme', theme);
    updateThemeIcon(theme);
}
function toggleTheme() {
    setTheme(getTheme() === 'dark' ? 'light' : 'dark');
}
function updateThemeIcon(theme) {
    const icon = document.getElementById('themeIcon');
    if (icon) {
        icon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
    }
}
// Set icon on load
updateThemeIcon(getTheme());

// =============================================================================
//  SIDEBAR NAVIGATION
// =============================================================================
document.querySelectorAll('.sidebar .nav-link[data-fn]').forEach(link => {
    link.addEventListener('click', () => {
        document.querySelectorAll('.sidebar .nav-link').forEach(l => l.classList.remove('active'));
        link.classList.add('active');
        const fn = link.dataset.fn;
        if (fn === 'add_user_batch') {
            showBatch();
        } else {
            showFunction(fn);
        }
        // Close sidebar on mobile
        if (window.innerWidth < 992) {
            document.querySelector('.sidebar').classList.remove('show');
        }
    });
});

// =============================================================================
//  SHOW FUNCTION
// =============================================================================
function showFunction(fn) {
    currentFn = fn;
    const def = API_FUNCTIONS[fn];
    if (!def) return;

    document.getElementById('batchArea').style.display = 'none';
    document.getElementById('functionFormArea').style.display = 'block';
    document.getElementById('formTitle').textContent = def.label;
    document.getElementById('fnBadge').textContent = fn;
    document.getElementById('responseArea').textContent = 'Waiting for request...';

    renderFieldset('requiredFieldset', 'requiredFields', def.required, 'req');
    renderFieldset('settingsFieldset', 'settingsFields', def.settings, 'set');
    renderFieldset('optionalFieldset', 'optionalFields', def.optional, 'opt');
}

function renderFieldset(fsId, containerId, fields, badgeType) {
    const fs = document.getElementById(fsId);
    const container = document.getElementById(containerId);
    container.innerHTML = '';
    if (!fields || fields.length === 0) {
        fs.style.display = 'none';
        return;
    }
    fs.style.display = 'block';
    fields.forEach(f => {
        const col = document.createElement('div');
        col.className = 'col-md-4';
        let input;
        if (f.type === 'select') {
            const opts = f.options.map(o => `<option value="${o}">${o || '-- select --'}</option>`).join('');
            input = `<select class="form-select" id="field_${f.name}" name="${f.name}">${opts}</select>`;
        } else if (f.type === 'date') {
            input = `<input type="date" class="form-control" id="field_${f.name}" name="${f.name}">`;
        } else {
            input = `<input type="text" class="form-control" id="field_${f.name}" name="${f.name}" placeholder="${f.hint || ''}">`;
        }
        const reqStar = badgeType === 'req' ? ' <span class="text-danger">*</span>' : '';
        col.innerHTML = `
            <label class="form-label">${f.label}${reqStar}</label>
            ${input}
            <div class="form-text text-secondary">${f.hint || ''}</div>
        `;
        container.appendChild(col);
    });
}

function showBatch() {
    currentFn = null;
    document.getElementById('functionFormArea').style.display = 'none';
    document.getElementById('batchArea').style.display = 'block';
}

// =============================================================================
//  TOGGLE PASSWORD
// =============================================================================
function togglePass() {
    const p = document.getElementById('connPass');
    p.type = p.type === 'password' ? 'text' : 'password';
}

// =============================================================================
//  BUILD BASE URL
// =============================================================================
function getBaseUrl() {
    const proto = document.getElementById('connProtocol').value;
    const domain = document.getElementById('connDomain').value.trim();
    const user = document.getElementById('connUser').value.trim();
    const pass = document.getElementById('connPass').value.trim();
    if (!domain || !user || !pass) {
        alert('Please fill in Domain, Admin User and Admin Pass in Connection Settings.');
        return null;
    }
    return `${proto}${domain}/vicidial/non_agent_api.php?source=adminpanel&user=${encodeURIComponent(user)}&pass=${encodeURIComponent(pass)}`;
}

// Route requests through proxy.php to avoid CORS issues
async function proxyFetch(targetUrl) {
    const proxyUrl = `proxy.php?url=${encodeURIComponent(targetUrl)}`;
    return fetch(proxyUrl);
}

// =============================================================================
//  DISPLAY RESPONSE (auto-detect HTML)
// =============================================================================
function displayResponse(el, text) {
    if (!text) {
        el.textContent = '(empty response)';
        return;
    }
    // Check if response contains HTML tags
    if (/<[a-z][\s\S]*>/i.test(text)) {
        el.innerHTML = text;
    } else {
        el.textContent = text;
    }
}

// =============================================================================
//  SUBMIT SINGLE API CALL
// =============================================================================
async function submitAPI() {
    if (!currentFn) return;
    const base = getBaseUrl();
    if (!base) return;

    let url = `${base}&function=${currentFn}`;
    const def = API_FUNCTIONS[currentFn];
    const allFields = [...(def.required||[]), ...(def.settings||[]), ...(def.optional||[])];
    allFields.forEach(f => {
        const el = document.getElementById(`field_${f.name}`);
        if (el && el.value.trim()) {
            url += `&${f.name}=${encodeURIComponent(el.value.trim())}`;
        }
    });

    const resArea = document.getElementById('responseArea');
    resArea.textContent = '⏳ Sending request...';

    try {
        const resp = await proxyFetch(url);
        const text = await resp.text();
        displayResponse(resArea, text);
    } catch(err) {
        resArea.textContent = `❌ Error: ${err.message}\n\nURL attempted:\n${url}`;
    }
}

// =============================================================================
//  CLEAR FORM
// =============================================================================
function clearForm() {
    if (!currentFn) return;
    document.getElementById('apiForm').reset();
    document.getElementById('responseArea').textContent = 'Waiting for request...';
}

// =============================================================================
//  BATCH ADD USERS
// =============================================================================
function parseUserRange(from, to) {
    // Extract prefix and numeric parts
    const fromMatch = from.match(/^(.*?)(\d+)$/);
    const toMatch = to.match(/^(.*?)(\d+)$/);
    if (!fromMatch || !toMatch) return null;
    const prefix = fromMatch[1];
    if (prefix !== toMatch[1]) return null;
    const startNum = parseInt(fromMatch[2], 10);
    const endNum = parseInt(toMatch[2], 10);
    const padLen = fromMatch[2].length;
    if (startNum > endNum) return null;
    const users = [];
    for (let i = startNum; i <= endNum; i++) {
        const numStr = String(i).padStart(padLen, '0');
        users.push({
            agent_user: prefix + numStr,
            agent_full_name: (prefix.replace(/[_-]/g,' ').trim() || 'Agent') + ' ' + numStr
        });
    }
    return users;
}

function parseUserList(text) {
    const lines = text.split(/\r?\n/).map(l => l.trim()).filter(l => l.length > 0);
    if (lines.length === 0) return null;
    return lines.map(username => {
        // Generate a readable full name from the username
        const fullName = username.replace(/[_\-\.]/g, ' ').replace(/(\d+)/g, ' $1').replace(/\s+/g, ' ').trim();
        return {
            agent_user: username,
            agent_full_name: fullName || username
        };
    });
}

function getBatchMode() {
    // Check which tab is active
    const listTab = document.getElementById('tab-list');
    return listTab && listTab.classList.contains('active') ? 'list' : 'range';
}

async function runBatch() {
    if (batchRunning) return;
    const base = getBaseUrl();
    if (!base) return;

    const agentPass = document.getElementById('batchAgentPass').value.trim();
    const agentLevel = document.getElementById('batchAgentLevel').value;
    const agentGroup = document.getElementById('batchAgentGroup').value.trim();
    if (!agentPass || !agentGroup) { alert('Please fill Agent Pass and Agent User Group.'); return; }

    let users = null;
    const mode = getBatchMode();

    if (mode === 'list') {
        const text = document.getElementById('batchUserList').value.trim();
        if (!text) { alert('Please enter at least one username in the list.'); return; }
        users = parseUserList(text);
        if (!users || users.length === 0) {
            alert('No valid usernames found. Enter one username per line.');
            return;
        }
    } else {
        const fromUser = document.getElementById('batchFromUser').value.trim();
        const toUser = document.getElementById('batchToUser').value.trim();
        if (!fromUser || !toUser) { alert('Please fill From Agent User and To Agent User.'); return; }
        users = parseUserRange(fromUser, toUser);
        if (!users || users.length === 0) {
            alert('Invalid user range. Ensure both have the same prefix and valid numeric suffixes (from <= to).');
            return;
        }
    }

    // Optional fields
    const optFields = {};
    const optMap = {
        phone_login: 'batchPhoneLogin', phone_pass: 'batchPhonePass',
        hotkeys_active: 'batchHotkeys', voicemail_id: 'batchVoicemailId',
        email: 'batchEmail', custom_one: 'batchCustomOne', custom_two: 'batchCustomTwo',
        custom_three: 'batchCustomThree', custom_four: 'batchCustomFour', custom_five: 'batchCustomFive'
    };
    for (const [key, id] of Object.entries(optMap)) {
        const v = document.getElementById(id).value.trim();
        if (v) optFields[key] = v;
    }

    batchRunning = true;
    batchAbort = false;
    document.getElementById('btnBatchRun').disabled = true;
    document.getElementById('btnBatchStop').style.display = 'inline-block';

    const log = document.getElementById('batchLog');
    const progress = document.getElementById('batchProgress');
    const status = document.getElementById('batchStatus');
    const counter = document.getElementById('batchCounter');
    log.innerHTML = '';
    let done = 0;
    let success = 0;
    let errors = 0;
    const total = users.length;
    counter.textContent = `0 / ${total}`;
    status.textContent = 'Running...';

    for (const u of users) {
        if (batchAbort) {
            appendLog(log, `\n⛔ Batch aborted by user.`, 'log-error');
            break;
        }

        let url = `${base}&function=add_user`;
        url += `&agent_user=${encodeURIComponent(u.agent_user)}`;
        url += `&agent_pass=${encodeURIComponent(agentPass)}`;
        url += `&agent_user_level=${agentLevel}`;
        url += `&agent_full_name=${encodeURIComponent(u.agent_full_name)}`;
        url += `&agent_user_group=${encodeURIComponent(agentGroup)}`;
        for (const [k,v] of Object.entries(optFields)) {
            url += `&${k}=${encodeURIComponent(v)}`;
        }

        appendLog(log, `→ Creating ${u.agent_user} (${u.agent_full_name})...`, 'log-info');

        try {
            const resp = await proxyFetch(url);
            const text = await resp.text();
            if (text.includes('SUCCESS')) {
                success++;
                appendLog(log, `  ✅ ${text.trim()}`, 'log-success');
            } else {
                errors++;
                appendLog(log, `  ❌ ${text.trim()}`, 'log-error');
            }
        } catch(err) {
            errors++;
            appendLog(log, `  ❌ Network error: ${err.message}`, 'log-error');
        }

        done++;
        const pct = Math.round((done / total) * 100);
        progress.style.width = pct + '%';
        progress.setAttribute('aria-valuenow', pct);
        counter.textContent = `${done} / ${total}`;
    }

    status.textContent = `Complete — ${success} succeeded, ${errors} failed`;
    batchRunning = false;
    document.getElementById('btnBatchRun').disabled = false;
    document.getElementById('btnBatchStop').style.display = 'none';
}

function stopBatch() {
    batchAbort = true;
}

function appendLog(logEl, text, cls) {
    const span = document.createElement('span');
    span.className = cls || '';
    span.textContent = text + '\n';
    logEl.appendChild(span);
    logEl.scrollTop = logEl.scrollHeight;
}

function clearBatchLog() {
    document.getElementById('batchLog').innerHTML = 'Batch log will appear here...';
    document.getElementById('batchProgress').style.width = '0%';
    document.getElementById('batchStatus').textContent = 'Idle';
    document.getElementById('batchCounter').textContent = '0 / 0';
}
</script>

</body>
</html>
