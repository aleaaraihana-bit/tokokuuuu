<?php
require_once __DIR__ . "/functions.php";
wajibLogin();
$pageTitle = $pageTitle ?? "TOKOKU";
$active = basename($_SERVER["PHP_SELF"]);
$user = $_SESSION["user"];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> | TOKOKU</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="app-shell">
    <aside class="sidebar" id="sidebar">
        <a class="brand" href="dashboard.php">
            <span class="brand-mark">T</span>
            <span><b>TOKOKU</b><small>Sistem Manajemen Toko</small></span>
        </a>
        <div class="side-label">MENU UTAMA</div>
        <nav class="nav-menu">
            <a class="<?= $active === 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php"><span>▦</span> Dashboard</a>
            <a class="<?= $active === 'pelanggan.php' ? 'active' : '' ?>" href="pelanggan.php"><span>♙</span> Data Pelanggan</a>
            <?php if ($user["role"] === "admin"): ?>
            <a class="<?= $active === 'master.php' && ($_GET['jenis'] ?? '') === 'barang' ? 'active' : '' ?>" href="master.php?jenis=barang"><span>▣</span> Data Barang</a>
            <a class="<?= $active === 'master.php' && ($_GET['jenis'] ?? '') === 'kategori' ? 'active' : '' ?>" href="master.php?jenis=kategori"><span>◇</span> Kategori Barang</a>
            <a class="<?= $active === 'master.php' && ($_GET['jenis'] ?? '') === 'supplier' ? 'active' : '' ?>" href="master.php?jenis=supplier"><span>♧</span> Data Supplier</a>
            <a class="<?= $active === 'stok.php' ? 'active' : '' ?>" href="stok.php"><span>▤</span> Stok Barang</a>
            <a class="<?= $active === 'penjualan_form.php' ? 'active' : '' ?>" href="penjualan_form.php"><span>＋</span> Transaksi Penjualan</a>
            <?php endif; ?>
            <a class="<?= $active === 'transaksi.php' ? 'active' : '' ?>" href="transaksi.php"><span>▤</span> Riwayat Transaksi</a>
            <a class="<?= $active === 'laporan.php' ? 'active' : '' ?>" href="laporan.php"><span>▥</span> Laporan Penjualan</a>
        </nav>
        <div class="side-label">PENGELOLAAN DATABASE</div>
        <nav class="nav-menu">
            <a class="<?= $active === 'database.php' ? 'active' : '' ?>" href="database.php"><span>◈</span> Fitur BAB 1–5</a>
            <?php if ($user["role"] === "admin"): ?>
            <a class="<?= $active === 'pengguna.php' ? 'active' : '' ?>" href="pengguna.php"><span>♧</span> Kelola Pengguna</a>
            <?php endif; ?>
        </nav>
        <div class="sidebar-bottom">
            <div class="help-card"><span class="help-icon">✦</span><b>Kelola toko lebih mudah</b><small>Pantau pelanggan dan transaksi dalam satu tempat.</small></div>
            <a class="nav-logout" href="logout.php"><span>⇥</span> Keluar</a>
        </div>
    </aside>
    <main class="main-area">
        <header class="topbar">
            <button class="menu-toggle" onclick="document.getElementById('sidebar').classList.toggle('show')">☰</button>
            <div><div class="top-eyebrow">SISTEM MANAJEMEN TOKO</div><h1><?= e($pageTitle) ?></h1></div>
            <div class="top-user">
                <div class="avatar"><?= strtoupper(substr($user["nama"], 0, 1)) ?></div>
                <div><b><?= e($user["nama"]) ?></b><small><?= $user["role"] === "admin" ? "Administrator" : "Pengguna" ?></small></div>
            </div>
        </header>
        <section class="content">
            <?php tampilPesan(); ?>
