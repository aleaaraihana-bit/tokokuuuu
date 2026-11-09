<?php
require_once "config.php";
require_once "includes/functions.php";

// Membuat tabel akun website tanpa mengubah tabel tugas BAB 1–5.
$pdo->exec("CREATE TABLE IF NOT EXISTS users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') NOT NULL DEFAULT 'user',
    dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");


// Tabel tambahan untuk fitur katalog barang, kategori, supplier, stok, dan struk.
$pdo->exec("CREATE TABLE IF NOT EXISTS tokoku_kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL UNIQUE,
    keterangan VARCHAR(255) NULL,
    dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
$pdo->exec("CREATE TABLE IF NOT EXISTS tokoku_supplier (
    id_supplier INT AUTO_INCREMENT PRIMARY KEY,
    nama_supplier VARCHAR(120) NOT NULL,
    telepon VARCHAR(30) NULL,
    alamat VARCHAR(255) NULL,
    dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
$pdo->exec("CREATE TABLE IF NOT EXISTS tokoku_barang (
    id_barang INT AUTO_INCREMENT PRIMARY KEY,
    nama_barang VARCHAR(150) NOT NULL,
    id_kategori INT NULL,
    id_supplier INT NULL,
    harga DECIMAL(14,2) NOT NULL DEFAULT 0,
    stok INT NOT NULL DEFAULT 0,
    dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (id_kategori), INDEX (id_supplier)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
$pdo->exec("CREATE TABLE IF NOT EXISTS tokoku_detail_transaksi (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT NOT NULL,
    id_barang INT NOT NULL,
    nama_barang VARCHAR(150) NOT NULL,
    harga DECIMAL(14,2) NOT NULL,
    jumlah INT NOT NULL,
    subtotal DECIMAL(14,2) NOT NULL,
    dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (id_transaksi), INDEX (id_barang)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$cek = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
if ((int)$cek === 0) {
    $stmt = $pdo->prepare("INSERT INTO users (nama, username, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute(["Administrator TOKOKU", "admin", password_hash("admin123", PASSWORD_DEFAULT), "admin"]);
    $stmt->execute(["Pengguna TOKOKU", "user", password_hash("user123", PASSWORD_DEFAULT), "user"]);
}
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Pengaturan TOKOKU</title><link rel="stylesheet" href="assets/style.css"></head>
<body class="login-body"><div class="login-card setup-card"><div class="brand centered"><span class="brand-mark">T</span><span><b>TOKOKU</b><small>Pengaturan Website</small></span></div><div class="login-heading"><h1>Website siap digunakan!</h1><p>Tabel akun website berhasil disiapkan. Tabel pelanggan, transaksi, View, Procedure, Function, dan Trigger milikmu tetap digunakan.</p></div>
<div class="credential"><b>Login Admin</b><span>Username: admin</span><span>Password: admin123</span></div>
<div class="credential"><b>Login User</b><span>Username: user</span><span>Password: user123</span></div>
<a class="btn btn-primary full" href="login.php">Masuk ke TOKOKU</a><p class="tiny-note">Demi keamanan, hapus file setup.php setelah pengaturan selesai dan ganti kata sandi akun melalui pengelolaan pengguna.</p></div></body></html>
