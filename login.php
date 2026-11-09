<?php
require_once "config.php";
require_once "includes/functions.php";
if (!empty($_SESSION["user"])) { header("Location: dashboard.php"); exit; }
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    cekCsrf();
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    $stmt = $pdo->prepare("SELECT id_user, nama, username, password, role FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $akun = $stmt->fetch();
    if ($akun && password_verify($password, $akun["password"])) {
        session_regenerate_id(true);
        unset($akun["password"]);
        $_SESSION["user"] = $akun;
        header("Location: dashboard.php");
        exit;
    } else $error = "Nama pengguna atau kata sandi tidak sesuai.";
}
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Masuk | TOKOKU</title><link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Manrope:wght@700;800&display=swap" rel="stylesheet"><link rel="stylesheet" href="assets/style.css"></head>
<body class="login-body"><div class="login-wrap"><div class="login-visual"><div class="visual-brand"><span class="brand-mark light">T</span><b>TOKOKU</b></div><div class="visual-copy"><span class="eyebrow-light">SATU DASHBOARD, SEMUA TERKENDALI</span><h1>Kelola toko<br>jadi lebih mudah.</h1><p>Pantau pelanggan, transaksi, dan laporan toko melalui satu sistem yang praktis.</p></div><div class="visual-foot">Sistem Manajemen Toko · BAB 1–5</div></div>
<div class="login-panel"><div class="login-form"><div class="brand mobile-brand"><span class="brand-mark">T</span><span><b>TOKOKU</b><small>Sistem Manajemen Toko</small></span></div><div class="login-heading"><span class="eyebrow">SELAMAT DATANG</span><h2>Masuk ke akunmu</h2><p>Silakan masukkan nama pengguna dan kata sandi.</p></div>
<?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
<form method="post"><input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>"><label>Nama Pengguna</label><input class="input" type="text" name="username" placeholder="Masukkan nama pengguna" required autofocus><label>Kata Sandi</label><input class="input" type="password" name="password" placeholder="Masukkan kata sandi" required><button class="btn btn-primary full" type="submit">Masuk Sekarang <span>→</span></button></form>
<div class="login-hint"><b>Akun demo setelah menjalankan setup.php</b><span>Admin: admin / admin123</span><span>User: user / user123</span></div><p class="login-copyright">© <?= date("Y") ?> TOKOKU. Dibuat untuk pengelolaan toko.</p></div></div></div></body></html>
