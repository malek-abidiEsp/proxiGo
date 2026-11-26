
<?php
$csrfToken = $authController->getCsrfToken();
ob_start();
?>

<div class="space-y-8">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="mb-2 text-sm font-semibold text-[#40e0d0]">ADMINISTRATION</p>
            <h1 class="text-2xl font-bold text-white">Roles Management</h1>
            <p class="mt-2 text-sm text-[#9b95aa]">Manage the roles available in ProxiGo.</p>
        </div>

        <a href="Role.php?action=add" class="rounded-xl bg-[#40e0d0] px-5 py-3 font-semibold text-[#03010e] hover:opacity-90">
            + Add New Role
        </a>
    </div>

    <div class="rounded-2xl border border-white/10 bg-[#0b0c17] p-6">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-white">All Roles</h2>
                <p class="mt-1 text-sm text-[#9b95aa]">
                    <?= count($roles) ?> role(s) found
                </p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-white/10 text-sm text-[#9b95aa]">
                        <th class="px-4 py-4 font-medium">ID</th>
                        <th class="px-4 py-4 font-medium">Role Name</th>
                        <th class="px-4 py-4 text-right font-medium">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (empty($roles)): ?>
                        <tr>
                            <td colspan="3" class="px-4 py-10 text-center text-[#9b95aa]">
                                No roles found.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($roles as $role): ?>
                            <tr class="border-b border-white/5 last:border-0 hover:bg-white/[0.02]">
                                <td class="px-4 py-4 text-sm text-[#9b95aa]">
                                    <?= (int) $role['id'] ?>
                                </td>

                                <td class="px-4 py-4">
                                    <span class="rounded-lg border border-[#937aff]/20 bg-[#937aff]/10 px-3 py-1.5 text-sm font-medium text-[#b9a8ff]">
                                        <?= htmlspecialchars($role['name'], ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                </td>

                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a
                                            href="Role.php?action=edit&id=<?= (int) $role['id'] ?>"
                                            class="rounded-lg border border-[#937aff]/30 px-3 py-2 text-sm text-[#b9a8ff] hover:bg-[#937aff]/10"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="Role.php?action=delete"
                                            onsubmit="return confirm('Are you sure you want to delete this role?')"
                                        >
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
                                            <input type="hidden" name="id" value="<?= (int) $role['id'] ?>">

                                            <button
                                                type="submit"
                                                class="rounded-lg border border-red-500/20 px-3 py-2 text-sm text-red-400 hover:bg-red-500/10"
                                            >
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = 'Roles Management';
$activePage = 'roles';
require __DIR__ . '/../layout_admin.php';
?>
