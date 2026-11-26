
<?php
ob_start();
?>

<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <p class="text-sm text-[#40e0d0] font-semibold mb-2">ADMINISTRATION</p>
        <h1 class="text-2xl font-bold text-white">Add New Role</h1>
        <p class="text-sm text-[#9b95aa] mt-2">Create a new role for ProxiGo users.</p>
    </div>

    <div class="rounded-2xl border border-white/10 bg-[#0b0c17] p-6">
        <form method="POST" action="Role.php?action=save" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

            <div>
                <label for="name" class="block text-sm font-medium text-[#dad4de] mb-2">Role name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Enter role name"
                    required
                    maxlength="100"
                    class="w-full rounded-xl border border-white/10 bg-[#03010e] px-4 py-3 text-white outline-none focus:border-[#40e0d0]"
                >
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="rounded-xl bg-[#40e0d0] px-6 py-3 font-semibold text-[#03010e] hover:opacity-90">
                    Add Role
                </button>

                <a href="Role.php" class="rounded-xl border border-white/10 px-6 py-3 text-[#dad4de] hover:bg-white/5">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = 'Add Role';
$activePage = 'roles';
require __DIR__ . '/../layout_admin.php';
?>
