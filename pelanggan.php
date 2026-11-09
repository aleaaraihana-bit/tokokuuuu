<?php
require_once "config.php"; require_once "includes/functions.php"; wajibLogin();
$pageTitle="Data Pelanggan";
$q=trim($_GET["q"]??"");
$sql="SELECT p.*, COUNT(t.id_transaksi) jumlah_transaksi, COALESCE(SUM(t.total_belanja),0) total_belanja FROM tbl_pelanggan p LEFT JOIN tbl_transaksi t ON p.id_pelanggan=t.id_pelanggan";
$params=[];
if($q!==""){ $sql.=" WHERE p.nama_pelanggan LIKE ? OR p.kota LIKE ? OR CAST(p.id_pelanggan AS CHAR) LIKE ?"; $params=["%$q%","%$q%","%$q%"]; }
$sql.=" GROUP BY p.id_pelanggan,p.nama_pelanggan,p.kota ORDER BY p.id_pelanggan DESC";
$stmt=$pdo->prepare($sql);$stmt->execute($params);$rows=$stmt->fetchAll();
require "includes/header.php";
?>
<div class="page-intro"><div><span class="eyebrow">PENGELOLAAN DATA</span><h2>Daftar Pelanggan</h2><p>Kelola informasi pelanggan dan pantau aktivitas belanjanya.</p></div><?php if($user["role"]==="admin"): ?><a class="btn btn-primary" href="pelanggan_form.php">＋ Tambah Pelanggan</a><?php endif; ?></div>
<div class="panel table-panel"><div class="panel-head"><div><h3>Semua Pelanggan <span class="count-badge"><?= count($rows) ?></span></h3><p>Data diambil langsung dari tabel tbl_pelanggan</p></div><form class="search-form" method="get"><input class="input search-input" name="q" value="<?= e($q) ?>" placeholder="Cari nama, kota, atau ID..."><button class="btn btn-outline" type="submit">Cari</button></form></div>
<div class="table-scroll"><table><thead><tr><th>ID</th><th>Nama Pelanggan</th><th>Kota</th><th>Jumlah Transaksi</th><th>Total Belanja</th><?php if($user["role"]==="admin"): ?><th>Aksi</th><?php endif; ?></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td class="muted-cell">#<?= e($r["id_pelanggan"]) ?></td><td><div class="person-cell"><span class="table-avatar"><?= strtoupper(substr($r["nama_pelanggan"],0,1)) ?></span><b><?= e($r["nama_pelanggan"]) ?></b></div></td><td><?= e($r["kota"]) ?></td><td><?= number_format($r["jumlah_transaksi"]) ?> transaksi</td><td><b><?= rupiah($r["total_belanja"]) ?></b></td><?php if($user["role"]==="admin"): ?><td><div class="actions"><a class="action-btn" href="pelanggan_form.php?id=<?= e($r["id_pelanggan"]) ?>">Edit</a><form method="post" action="pelanggan_hapus.php" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini? Data yang masih memiliki transaksi mungkin tidak dapat dihapus.')"><input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>"><input type="hidden" name="id" value="<?= e($r["id_pelanggan"]) ?>"><button class="action-btn danger" type="submit">Hapus</button></form></div></td><?php endif; ?></tr><?php endforeach; ?>
<?php if(!$rows): ?><tr><td colspan="6" class="empty-state">Data pelanggan tidak ditemukan.</td></tr><?php endif; ?>
</tbody></table></div></div>
<?php require "includes/footer.php"; ?>
