<?php
require_once "config.php";require_once "includes/functions.php";wajibLogin();$pageTitle="Data Transaksi";$q=trim($_GET["q"]??"");
$sql="SELECT t.*,p.nama_pelanggan FROM tbl_transaksi t JOIN tbl_pelanggan p ON p.id_pelanggan=t.id_pelanggan";$params=[];
if($q!==""){$sql.=" WHERE p.nama_pelanggan LIKE ? OR CAST(t.id_transaksi AS CHAR) LIKE ? OR t.tanggal LIKE ?";$params=["%$q%","%$q%","%$q%"];}
$sql.=" ORDER BY t.tanggal DESC,t.id_transaksi DESC";$s=$pdo->prepare($sql);$s->execute($params);$rows=$s->fetchAll();
$sum=(float)$pdo->query("SELECT COALESCE(SUM(total_belanja),0) FROM tbl_transaksi")->fetchColumn();
require "includes/header.php";
?>
<div class="page-intro"><div><span class="eyebrow">RIWAYAT PENJUALAN</span><h2>Daftar Transaksi</h2><p>Pantau semua transaksi dan nilai belanja pelanggan.</p></div><?php if($user["role"]==="admin"): ?><a class="btn btn-primary" href="penjualan_form.php">＋ Transaksi Penjualan</a><?php endif; ?></div>
<div class="stats-grid compact-stats"><div class="stat-card"><div class="stat-top"><span class="stat-icon peach">▤</span></div><p>Jumlah Transaksi</p><h3><?= count($rows) ?></h3><small>Data sesuai pencarian</small></div><div class="stat-card"><div class="stat-top"><span class="stat-icon green">↗</span></div><p>Total Pendapatan</p><h3 class="money-stat"><?= rupiah($sum) ?></h3><small>Akumulasi seluruh transaksi</small></div></div>
<div class="panel table-panel"><div class="panel-head"><div><h3>Riwayat Transaksi</h3><p>Data diambil dari tbl_transaksi dan tbl_pelanggan</p></div><form class="search-form"><input class="input search-input" name="q" value="<?= e($q) ?>" placeholder="Cari pelanggan, ID, tanggal..."><button class="btn btn-outline">Cari</button></form></div><div class="table-scroll"><table><thead><tr><th>ID Transaksi</th><th>Pelanggan</th><th>Tanggal</th><th>Total Belanja</th><th>Struk</th><?php if($user["role"]==="admin"): ?><th>Aksi</th><?php endif; ?></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td class="muted-cell">#<?= e($r["id_transaksi"]) ?></td><td><b><?= e($r["nama_pelanggan"]) ?></b></td><td><?= e($r["tanggal"]) ?></td><td><b><?= rupiah($r["total_belanja"]) ?></b></td><td><a class="action-btn" href="struk.php?id=<?=e($r['id_transaksi'])?>" target="_blank">Cetak Struk</a></td><?php if($user["role"]==="admin"): ?><td><div class="actions"><a class="action-btn" href="transaksi_form.php?id=<?= e($r["id_transaksi"]) ?>">Edit</a><form method="post" action="transaksi_hapus.php" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')"><input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>"><input type="hidden" name="id" value="<?= e($r["id_transaksi"]) ?>"><button class="action-btn danger">Hapus</button></form></div></td><?php endif; ?></tr><?php endforeach; ?>
<?php if(!$rows): ?><tr><td colspan="6" class="empty-state">Belum ada transaksi yang cocok.</td></tr><?php endif; ?>
</tbody></table></div></div>
<?php require "includes/footer.php"; ?>
