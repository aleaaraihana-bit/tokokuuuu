<?php
require_once "config.php";require_once "includes/functions.php";wajibLogin();$pageTitle="Fitur BAB 1–5";
$views=$pdo->query("SHOW FULL TABLES WHERE Table_type='VIEW'")->fetchAll(PDO::FETCH_NUM);
$procedures=$pdo->query("SHOW PROCEDURE STATUS WHERE Db=DATABASE()")->fetchAll();
$functions=$pdo->query("SHOW FUNCTION STATUS WHERE Db=DATABASE()")->fetchAll();
$triggers=$pdo->query("SHOW TRIGGERS")->fetchAll();
$logs=[];$logs2=[];
try{$logs=$pdo->query("SELECT * FROM log_pelanggan ORDER BY waktu DESC LIMIT 10")->fetchAll();}catch(Throwable $e){}
try{$logs2=$pdo->query("SELECT * FROM log_perubahan_pelanggan ORDER BY waktu DESC LIMIT 10")->fetchAll();}catch(Throwable $e){}
require "includes/header.php";
?>
<div class="page-intro"><div><span class="eyebrow">INTEGRASI DATABASE</span><h2>Fitur Database BAB 1–5</h2><p>Ringkasan objek database yang sudah dibuat pada latihan SQL lanjutan.</p></div></div>
<div class="feature-grid">
<div class="feature-card"><span class="feature-symbol">▧</span><h3>BAB 1 · View</h3><p>View digunakan untuk menyimpan query laporan agar mudah dipanggil kembali.</p><b><?= count($views) ?> View terdeteksi</b><?php foreach($views as $v): ?><small>• <?= e($v[0]) ?></small><?php endforeach; ?></div>
<div class="feature-card"><span class="feature-symbol">⌘</span><h3>BAB 3 · Stored Procedure</h3><p>Procedure menjalankan kumpulan perintah SQL melalui pemanggilan CALL.</p><b><?= count($procedures) ?> Procedure terdeteksi</b><?php foreach($procedures as $v): ?><small>• <?= e($v["Name"]) ?></small><?php endforeach; ?></div>
<div class="feature-card"><span class="feature-symbol">ƒ</span><h3>BAB 4 · Stored Function</h3><p>Function mengembalikan nilai yang dapat digunakan dalam query SQL.</p><b><?= count($functions) ?> Function terdeteksi</b><?php foreach($functions as $v): ?><small>• <?= e($v["Name"]) ?></small><?php endforeach; ?></div>
<div class="feature-card"><span class="feature-symbol">⚡</span><h3>BAB 5 · Trigger</h3><p>Trigger berjalan otomatis saat operasi tertentu dilakukan pada tabel.</p><b><?= count($triggers) ?> Trigger terdeteksi</b><?php foreach($triggers as $v): ?><small>• <?= e($v["Trigger"]) ?> (<?= e($v["Event"]) ?>)</small><?php endforeach; ?></div>
</div>
<div class="panel table-panel"><div class="panel-head"><div><h3>Log Pelanggan Baru</h3><p>Catatan dari Trigger AFTER INSERT</p></div></div><div class="table-scroll"><table><thead><tr><th>ID Log</th><th>Aktivitas</th><th>ID Pelanggan</th><th>Waktu</th></tr></thead><tbody><?php foreach($logs as $r): ?><tr><td><?= e($r["id_log"]) ?></td><td><?= e($r["aktivitas"]) ?></td><td><?= e($r["id_pelanggan"]) ?></td><td><?= e($r["waktu"]) ?></td></tr><?php endforeach; ?><?php if(!$logs): ?><tr><td colspan="4" class="empty-state">Belum ada catatan log.</td></tr><?php endif; ?></tbody></table></div></div>
<div class="panel table-panel"><div class="panel-head"><div><h3>Log Perubahan Pelanggan</h3><p>Catatan dari Trigger AFTER UPDATE</p></div></div><div class="table-scroll"><table><thead><tr><th>ID Pelanggan</th><th>Nama Lama</th><th>Nama Baru</th><th>Waktu</th></tr></thead><tbody><?php foreach($logs2 as $r): ?><tr><td><?= e($r["id_pelanggan"]) ?></td><td><?= e($r["nama_lama"]) ?></td><td><?= e($r["nama_baru"]) ?></td><td><?= e($r["waktu"]) ?></td></tr><?php endforeach; ?><?php if(!$logs2): ?><tr><td colspan="4" class="empty-state">Belum ada perubahan yang tercatat.</td></tr><?php endif; ?></tbody></table></div></div>
<?php require "includes/footer.php"; ?>
