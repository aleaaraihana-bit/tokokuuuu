<?php
require_once "config.php";
require_once "includes/functions.php";
wajibAdmin();
$pageTitle = "Kelola Pengguna";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    cekCsrf();
    $aksi = $_POST["aksi"] ?? "";

    if ($aksi === "tambah") {
        $nama = trim($_POST["nama"] ?? "");
        $username = trim($_POST["username"] ?? "");
        $password = $_POST["password"] ?? "";
        $role = $_POST["role"] ?? "user";
        if ($nama === "" || $username === "" || strlen($password) < 6 || !in_array($role, ["admin", "user"], true)) {
            pesan("error", "Lengkapi semua data. Kata sandi minimal 6 karakter.");
        } else {
            try {
                $stmt = $pdo->prepare("INSERT INTO users (nama, username, password, role) VALUES (?, ?, ?, ?)");
                $stmt->execute([$nama, $username, password_hash($password, PASSWORD_DEFAULT), $role]);
                pesan("success", "Data orang baru berhasil ditambahkan sebagai akun " . strtoupper($role) . ".");
            } catch (PDOException $e) {
                pesan("error", "Gagal menambahkan akun. Nama pengguna mungkin sudah digunakan.");
            }
        }
        header("Location: pengguna.php"); exit;
    }

    if ($aksi === "edit") {
        $id = (int)($_POST["id"] ?? 0);
        $nama = trim($_POST["nama"] ?? "");
        $username = trim($_POST["username"] ?? "");
        $password = $_POST["password"] ?? "";
        $role = $_POST["role"] ?? "user";
        if ($id < 1 || $nama === "" || $username === "" || !in_array($role, ["admin", "user"], true) || ($password !== "" && strlen($password) < 6)) {
            pesan("error", "Periksa kembali data. Kata sandi baru harus minimal 6 karakter.");
        } else {
            try {
                if ($password !== "") {
                    $stmt = $pdo->prepare("UPDATE users SET nama=?, username=?, password=?, role=? WHERE id_user=?");
                    $stmt->execute([$nama, $username, password_hash($password, PASSWORD_DEFAULT), $role, $id]);
                } else {
                    $stmt = $pdo->prepare("UPDATE users SET nama=?, username=?, role=? WHERE id_user=?");
                    $stmt->execute([$nama, $username, $role, $id]);
                }
                if ($id === (int)$_SESSION["user"]["id_user"]) {
                    $_SESSION["user"]["nama"] = $nama;
                    $_SESSION["user"]["username"] = $username;
                }
                pesan("success", "Data pengguna berhasil diperbarui.");
            } catch (PDOException $e) {
                pesan("error", "Gagal memperbarui akun. Pastikan nama pengguna belum dipakai akun lain.");
            }
        }
        header("Location: pengguna.php"); exit;
    }

    if ($aksi === "hapus") {
        $id = (int)($_POST["id"] ?? 0);
        if ($id === (int)$_SESSION["user"]["id_user"]) {
            pesan("error", "Akun yang sedang digunakan tidak dapat dihapus.");
        } else {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id_user=?");
            $stmt->execute([$id]);
            pesan("success", "Akun pengguna berhasil dihapus.");
        }
        header("Location: pengguna.php"); exit;
    }
}

$editId = (int)($_GET["edit"] ?? 0);
$editData = null;
if ($editId > 0) {
    $stmt = $pdo->prepare("SELECT id_user, nama, username, role FROM users WHERE id_user=?");
    $stmt->execute([$editId]);
    $editData = $stmt->fetch();
    if (!$editData) { pesan("error", "Data pengguna tidak ditemukan."); header("Location: pengguna.php"); exit; }
}
$rows = $pdo->query("SELECT id_user, nama, username, role, dibuat_pada FROM users ORDER BY id_user DESC")->fetchAll();
require "includes/header.php";
?>
<div class="page-intro"><div><span class="eyebrow">PENGATURAN AKSES</span><h2>Kelola Pengguna</h2><p>Tambahkan orang baru, ubah data akun, dan atur hak akses Admin atau User.</p></div></div>
<div class="two-col user-layout">
    <div class="panel form-panel">
        <div class="panel-head"><div><h3><?= $editData ? "Ubah Data Pengguna" : "Tambah Orang / Akun Baru" ?></h3><p><?= $editData ? "Perbarui informasi akun yang dipilih." : "Daftarkan orang baru agar dapat masuk ke website TOKOKU." ?></p></div></div>
        <form method="post" class="data-form">
            <input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>">
            <input type="hidden" name="aksi" value="<?= $editData ? "edit" : "tambah" ?>">
            <?php if ($editData): ?><input type="hidden" name="id" value="<?= e($editData["id_user"]) ?>"><?php endif; ?>
            <div class="field"><label>Nama Lengkap</label><input class="input" name="nama" maxlength="100" value="<?= e($editData["nama"] ?? "") ?>" placeholder="Contoh: Andi Pratama" required></div>
            <div class="field"><label>Nama Pengguna</label><input class="input" name="username" maxlength="50" value="<?= e($editData["username"] ?? "") ?>" placeholder="Contoh: andi" required></div>
            <div class="field"><label>Kata Sandi <?= $editData ? "Baru (opsional)" : "" ?></label><input class="input" type="password" name="password" minlength="6" <?= $editData ? "" : "required" ?> placeholder="<?= $editData ? "Kosongkan jika tidak diubah" : "Minimal 6 karakter" ?>"><small><?= $editData ? "Isi hanya jika ingin mengganti kata sandi." : "Minimal 6 karakter." ?></small></div>
            <div class="field"><label>Hak Akses</label><select class="input" name="role"><option value="user" <?= (($editData["role"] ?? "user") === "user") ? "selected" : "" ?>>User</option><option value="admin" <?= (($editData["role"] ?? "") === "admin") ? "selected" : "" ?>>Admin</option></select></div>
            <button class="btn btn-primary full" type="submit"><?= $editData ? "Simpan Perubahan" : "＋ Tambahkan Orang Baru" ?></button>
            <?php if ($editData): ?><a class="btn btn-outline full" href="pengguna.php">Batal Mengubah</a><?php endif; ?>
        </form>
    </div>
    <div class="panel table-panel">
        <div class="panel-head"><div><h3>Daftar Pengguna</h3><p><?= count($rows) ?> akun terdaftar di TOKOKU</p></div></div>
        <div class="simple-list">
            <?php foreach ($rows as $r): ?>
            <div class="account-row">
                <div class="table-avatar"><?= e(strtoupper(substr($r["nama"], 0, 1))) ?></div>
                <div class="account-info"><b><?= e($r["nama"]) ?></b><small>@<?= e($r["username"]) ?> · <?= e(date("d/m/Y", strtotime($r["dibuat_pada"]))) ?></small></div>
                <span class="role-pill <?= e($r["role"]) ?>"><?= e(strtoupper($r["role"])) ?></span>
                <a class="action-btn" href="pengguna.php?edit=<?= e($r["id_user"]) ?>">Edit</a>
                <?php if ((int)$r["id_user"] !== (int)$_SESSION["user"]["id_user"]): ?>
                <form method="post" onsubmit="return confirm('Yakin ingin menghapus akun ini?')"><input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>"><input type="hidden" name="aksi" value="hapus"><input type="hidden" name="id" value="<?= e($r["id_user"]) ?>"><button class="action-btn danger" type="submit">Hapus</button></form>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php require "includes/footer.php"; ?>
