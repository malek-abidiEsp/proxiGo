
<?php
$activePage = $activePage ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($title ?? 'Admin Panel - ProxiGo', ENT_QUOTES, 'UTF-8') ?></title>
<link rel="stylesheet" href="assets/CSS/automark.css">
<link rel="stylesheet" href="assets/CSS/automark-theme.css">
<style>
:root {
    --sidebar-bg: #0b0c17;
    --sidebar-hover: #171528;
    --sidebar-text: #a5a0b5;
    --accent: #937aff;
    --turquoise: #40e0d0;
    --bg: #03010e;
    --card-bg: #0b0c17;
    --border: #202128;
    --text: #e5e5e5;
    --text-light: #817e84;
    --red: #ff7777;
    --green: #79d99b;
    --radius: 14px;
}

* {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: 'Segoe UI', Arial, sans-serif;
    background: var(--bg);
    color: var(--text);
}

.admin-wrapper {
    display: flex;
    min-height: 100vh;
}

.sidebar {
    width: 245px;
    flex-shrink: 0;
    background: var(--sidebar-bg);
    color: var(--sidebar-text);
    display: flex;
    flex-direction: column;
    padding: 24px 0;
    border-right: 1px solid var(--border);
}

.sidebar .brand {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0 24px 25px;
    border-bottom: 1px solid var(--border);
    margin-bottom: 22px;
}

.sidebar .brand img {
    width: 125px;
    height: auto;
    object-fit: contain;
}

.sidebar .brand span {
    color: var(--turquoise);
    font-size: 13px;
    font-weight: 700;
}

.sidebar nav {
    display: flex;
    flex-direction: column;
    gap: 7px;
}

.sidebar nav a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px 24px;
    color: var(--sidebar-text);
    text-decoration: none;
    font-size: 14px;
    border-left: 3px solid transparent;
    transition: all .2s ease;
}

.sidebar nav a:hover {
    background: var(--sidebar-hover);
    color: #fff;
}

.sidebar nav a.active {
    background: var(--sidebar-hover);
    color: var(--turquoise);
    border-left-color: var(--turquoise);
}

.sidebar nav a .icon {
    font-size: 17px;
    width: 20px;
    text-align: center;
}

.sidebar-footer {
    margin-top: auto;
    padding: 20px 24px 0;
    border-top: 1px solid var(--border);
}

.sidebar-footer .who {
    font-size: 14px;
    color: #fff;
    margin-bottom: 5px;
}

.sidebar-footer .role-tag {
    font-size: 11px;
    color: var(--turquoise);
    text-transform: uppercase;
    letter-spacing: .7px;
}

.sidebar-footer a.logout {
    display: inline-block;
    margin-top: 15px;
    font-size: 13px;
    color: var(--sidebar-text);
    text-decoration: none;
}

.sidebar-footer a.logout:hover {
    color: var(--red);
}

.main {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
}

.topbar {
    background: rgba(11, 12, 23, .95);
    border-bottom: 1px solid var(--border);
    padding: 20px 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.topbar h1 {
    font-size: 21px;
    margin: 0;
}

.topbar .env-tag {
    font-size: 11px;
    font-weight: 700;
    color: var(--turquoise);
    background: rgba(64, 224, 208, .1);
    border: 1px solid rgba(64, 224, 208, .25);
    padding: 7px 13px;
    border-radius: 20px;
    letter-spacing: .5px;
}

.content {
    padding: 32px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 28px;
}

.stat-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 22px;
}

.stat-card .label {
    font-size: 13px;
    color: var(--text-light);
}

.stat-card .value {
    font-size: 26px;
    font-weight: 700;
    margin-top: 8px;
}

.stat-card .value.accent {
    color: var(--turquoise);
}

.stat-card .value.red {
    color: var(--red);
}

.card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 24px;
    overflow-x: auto;
}

.card h2 {
    font-size: 19px;
    margin: 0 0 16px;
}

.card-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}

.card-head h2 {
    margin: 0;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    text-align: left;
    padding: 13px 10px;
    border-bottom: 1px solid var(--border);
    font-size: 14px;
}

th {
    color: var(--turquoise);
    font-weight: 600;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: .4px;
}

tr:last-child td {
    border-bottom: none;
}

.badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.badge-admin {
    background: #351818;
    color: var(--red);
}

.badge-user {
    background: #252044;
    color: #b5a3ff;
}

.btn {
    display: inline-block;
    padding: 9px 16px;
    background: var(--accent);
    color: #fff;
    border: 1px solid var(--accent);
    border-radius: 8px;
    font-size: 14px;
    text-decoration: none;
    cursor: pointer;
    transition: all .2s ease;
}

.btn:hover {
    background: #4d36d0;
}

.btn-sm {
    padding: 5px 12px;
    font-size: 13px;
}

.btn-outline {
    background: transparent;
    color: var(--turquoise);
    border-color: var(--turquoise);
}

.btn-outline:hover {
    background: rgba(64, 224, 208, .1);
}

.btn-danger {
    background: #a92c39;
    border-color: #a92c39;
}

.btn-danger:hover {
    background: #7f1d2d;
}

.actions {
    white-space: nowrap;
}

form.inline {
    display: inline;
}

.alert {
    padding: 12px 15px;
    border-radius: 8px;
    font-size: 14px;
    margin-bottom: 18px;
}

.alert-error {
    background: #351818;
    color: var(--red);
    border: 1px solid #572525;
}

.alert-success {
    background: #153322;
    color: var(--green);
    border: 1px solid #245638;
}

.form-card {
    max-width: 520px;
}

.form-card label {
    display: block;
    font-size: 13px;
    color: var(--text-light);
    margin: 14px 0 6px;
}

.form-card input[type=text],
.form-card input[type=email],
.form-card input[type=password],
.form-card select {
    width: 100%;
    padding: 11px 12px;
    background: #040404;
    color: var(--text);
    border: 1px solid var(--border);
    border-radius: 8px;
    font-size: 14px;
}

.form-card input:focus,
.form-card select:focus {
    outline: none;
    border-color: var(--accent);
}

.form-actions {
    margin-top: 22px;
    display: flex;
    gap: 10px;
}

@media (max-width: 750px) {
    .admin-wrapper {
        flex-direction: column;
    }

    .sidebar {
        width: 100%;
        padding: 15px 0;
    }

    .sidebar .brand {
        padding-bottom: 15px;
    }

    .sidebar nav {
        flex-direction: row;
        flex-wrap: wrap;
    }

    .sidebar nav a {
        padding: 10px 15px;
    }

    .sidebar-footer {
        margin-top: 15px;
    }

    .topbar {
        padding: 16px 20px;
    }

    .content {
        padding: 20px;
    }
}
</style>
</head>
<body>
<div class="admin-wrapper">
    <aside class="sidebar">
        <div class="brand">
            <img src="assets/images/ProxiGo.png" alt="ProxiGo Logo">
            <span>ADMIN</span>
        </div>

        <nav>
            <a href="index.php?action=admin_users" class="<?= $activePage === 'users' ? 'active' : '' ?>">
    <span class="icon">&#128101;</span> Users
</a>

<a href="Role.php" class="<?= $activePage === 'roles' ? 'active' : '' ?>">
    <span class="icon">&#9881;</span> Roles
</a>
            </a>

            <a href="index.php?action=admin_users" class="<?= $activePage === 'users' ? 'active' : '' ?>">
                <span class="icon">&#128101;</span> Users
            </a>

            <a href="index.php?action=dashboard">
                <span class="icon">&#8617;</span> Back to frontoffice
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="who"><?= htmlspecialchars($user->getUsername(), ENT_QUOTES, 'UTF-8') ?></div>
            <div class="role-tag">Administrator</div>
            <a class="logout" href="index.php?action=logout">Log out</a>
        </div>
    </aside>

    <div class="main">
        <div class="topbar">
            <h1><?= htmlspecialchars($title ?? 'Admin Panel', ENT_QUOTES, 'UTF-8') ?></h1>
            <span class="env-tag">BACKOFFICE</span>
        </div>

        <div class="content">
            <?= $content ?>
        </div>
    </div>
</div>
</body>
</html>
