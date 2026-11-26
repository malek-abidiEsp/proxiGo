
<?php
ob_start();
?>

<div class="dashboard-welcome">
    <div>
        <span class="dashboard-tag">PROXIGO ADMIN</span>
        <h2>Dashboard Overview</h2>
        <p>Manage your platform and monitor your users.</p>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="label">Total Accounts</div>
        <div class="value"><?= $totalUsers ?></div>
        <div class="stat-description">All registered accounts</div>
    </div>

    <div class="stat-card">
        <div class="label">Regular Users</div>
        <div class="value accent"><?= $totalRegular ?></div>
        <div class="stat-description">Standard platform members</div>
    </div>

    <div class="stat-card">
        <div class="label">Administrators</div>
        <div class="value red"><?= $totalAdmins ?></div>
        <div class="stat-description">Platform administrators</div>
    </div>
</div>

<div class="card users-table-card">
    <div class="section-heading">
        <div>
            <h2>All Users</h2>
            <p>Overview of registered ProxiGo accounts</p>
        </div>
        <span class="users-count"><?= $totalUsers ?> Accounts</span>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($allUsers as $u): ?>
                <tr>
                    <td>#<?= $u->getId() ?></td>
                    <td class="username-cell">
                        <?= htmlspecialchars($u->getUsername(), ENT_QUOTES, 'UTF-8') ?>
                    </td>
                    <td><?= htmlspecialchars($u->getEmail(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <?php $roleName = $u->getRoleId() === 1 ? 'admin' : 'user'; ?>
                        <span class="badge <?= $roleName === 'admin' ? 'badge-admin' : 'badge-user' ?>">
                            <?= htmlspecialchars($roleName, ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </td>
                    <td><?= htmlspecialchars($u->getCreatedAt(), ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
.dashboard-welcome {
    margin-bottom: 28px;
}

.dashboard-tag {
    color: #40e0d0;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 2px;
}

.dashboard-welcome h2 {
    color: #dad4de;
    font-size: 27px;
    margin: 10px 0 6px;
}

.dashboard-welcome p,
.section-heading p {
    color: #9692a5;
    font-size: 14px;
    margin: 0;
}

.stats-grid {
    margin-bottom: 28px;
}

.stat-card {
    background: #0b0c17;
    border: 1px solid rgba(147, 122, 255, 0.15);
    border-radius: 14px;
    padding: 24px;
    transition: transform 0.2s, border-color 0.2s;
}

.stat-card:hover {
    transform: translateY(-4px);
    border-color: #40e0d0;
}

.stat-card .label {
    color: #9692a5;
    font-size: 14px;
}

.stat-card .value {
    color: #40e0d0;
    font-size: 32px;
    font-weight: 700;
    margin-top: 12px;
}

.stat-card .value.accent {
    color: #937aff;
}

.stat-card .value.red {
    color: #ff7185;
}

.stat-description {
    color: #777487;
    font-size: 12px;
    margin-top: 8px;
}

.users-table-card {
    padding: 24px;
}

.section-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 22px;
}

.section-heading h2 {
    color: #dad4de;
    font-size: 20px;
    margin: 0 0 7px;
}

.users-count {
    color: #40e0d0;
    background: rgba(64, 224, 208, 0.08);
    border: 1px solid rgba(64, 224, 208, 0.2);
    padding: 8px 13px;
    border-radius: 20px;
    font-size: 12px;
    white-space: nowrap;
}

.table-container {
    width: 100%;
    overflow-x: auto;
}

.table-container table {
    width: 100%;
    border-collapse: collapse;
}

.table-container th {
    color: #9692a5;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.7px;
    text-align: left;
    padding: 15px 12px;
    border-bottom: 1px solid rgba(147, 122, 255, 0.2);
}

.table-container td {
    color: #c5c0d0;
    font-size: 13px;
    padding: 16px 12px;
    border-bottom: 1px solid rgba(147, 122, 255, 0.1);
}

.table-container tbody tr:hover {
    background: rgba(147, 122, 255, 0.06);
}

.username-cell {
    color: #40e0d0 !important;
    font-weight: 600;
}

@media (max-width: 600px) {
    .users-table-card {
        padding: 16px;
    }

    .section-heading {
        align-items: flex-start;
        flex-direction: column;
    }
}
</style>

<?php
$content = ob_get_clean();
$title = 'Dashboard - ProxiGo';
$activePage = 'dashboard';
require __DIR__ . '/layout_admin.php';
