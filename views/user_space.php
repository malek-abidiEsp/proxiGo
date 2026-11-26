
<?php
ob_start();
?>
<div class="container wide" style="max-width: 1000px; margin: 55px auto; padding: 40px;">
    <div style="margin-bottom: 35px;">
        <p style="color: #40e0d0; font-weight: 600; margin-bottom: 10px;">PROXIGO DASHBOARD</p>
        <h1 style="font-size: 32px; margin-bottom: 12px;">
            Welcome back, <?= htmlspecialchars($user->getUsername(), ENT_QUOTES, 'UTF-8') ?>!
        </h1>
        <p style="color: #817e84; margin: 0;">
            Manage your personal information and account settings.
        </p>
    </div>

    <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 30px;">
        <div style="flex: 1; min-width: 200px; padding: 24px; background: #151326; border: 1px solid #292342; border-radius: 14px;">
            <p style="color: #817e84; margin: 0 0 10px;">Account ID</p>
            <h2 style="color: #40e0d0; margin: 0;"><?= $user->getId() ?></h2>
        </div>

        <div style="flex: 1; min-width: 200px; padding: 24px; background: #151326; border: 1px solid #292342; border-radius: 14px;">
            <p style="color: #817e84; margin: 0 0 10px;">Account type</p>
            <h2 style="color: #937aff; margin: 0;">User</h2>
        </div>

        <div style="flex: 1; min-width: 200px; padding: 24px; background: #151326; border: 1px solid #292342; border-radius: 14px;">
            <p style="color: #817e84; margin: 0 0 10px;">Member since</p>
            <h2 style="color: #40e0d0; margin: 0; font-size: 18px;">
                <?= htmlspecialchars($user->getCreatedAt(), ENT_QUOTES, 'UTF-8') ?>
            </h2>
        </div>
    </div>

    <div style="padding: 28px; background: #0b0c17; border: 1px solid #202128; border-radius: 14px;">
        <h2 style="margin-top: 0; margin-bottom: 22px;">Personal Information</h2>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 22px;">
            <div>
                <p style="color: #817e84; margin-bottom: 7px;">Username</p>
                <p style="color: #e5e5e5; font-weight: 600; margin: 0;">
                    <?= htmlspecialchars($user->getUsername(), ENT_QUOTES, 'UTF-8') ?>
                </p>
            </div>

            <div>
                <p style="color: #817e84; margin-bottom: 7px;">Email address</p>
                <p style="color: #e5e5e5; font-weight: 600; margin: 0;">
                    <?= htmlspecialchars($user->getEmail(), ENT_QUOTES, 'UTF-8') ?>
                </p>
            </div>
        </div>

        <div style="display: flex; flex-wrap: wrap; gap: 12px; margin-top: 30px;">
            <a href="index.php?action=profile" style="display: inline-block; padding: 12px 22px; background: #937aff; color: white; border-radius: 8px; text-decoration: none; font-weight: 600;">
                Manage My Profile
            </a>

            <a href="index.php?action=logout" style="display: inline-block; padding: 12px 22px; background: transparent; color: #40e0d0; border: 1px solid #40e0d0; border-radius: 8px; text-decoration: none; font-weight: 600;">
                Log out
            </a>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'My Space - ProxiGo';
require __DIR__ . '/layout.php';
