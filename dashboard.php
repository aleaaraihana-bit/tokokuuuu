<?php
require_once "config.php";
require_once "includes/functions.php";
wajibLogin();
$pageTitle = "Dashboard";
$totalPelanggan = (int)$pdo->query("SELECT COUNT(*) FROM tbl_pelanggan")->fetchColumn();
$totalTransaksi = (int)$pdo->query("SELECT COUNT(*) FROM tbl_transaksi")->fetchColumn();
$totalPendapatan = (float)$pdo->query("SELECT COALESCE(SUM(total_belanja),0) FROM tbl_transaksi")->fetchColumn();
$rataRata = $totalTransaksi ? $totalPendapatan / $totalTransaksi : 0;
$terbaru = $pdo->query("SELECT t.id_transaksi,t.tanggal,t.total_belanja,p.nama_pelanggan FROM tbl_transaksi t JOIN tbl_pelanggan p ON p.id_pelanggan=t.id_pelanggan ORDER BY t.tanggal DESC,t.id_transaksi DESC LIMIT 6")->fetchAll();
$top = $pdo->query("SELECT p.nama_pelanggan, COALESCE(SUM(t.total_belanja),0) total FROM tbl_pelanggan p LEFT JOIN tbl_transaksi t ON p.id_pelanggan=t.id_pelanggan GROUP BY p.id_pelanggan,p.nama_pelanggan ORDER BY total DESC LIMIT 5")->fetchAll();
$chartRows = $pdo->query("SELECT DATE_FORMAT(tanggal,'%Y-%m') bulan, SUM(total_belanja) total, COUNT(*) jumlah FROM tbl_transaksi GROUP BY DATE_FORMAT(tanggal,'%Y-%m') ORDER BY bulan")->fetchAll();
$labels = array_column($chartRows, "bulan");
$values = array_map("floatval", array_column($chartRows, "total"));
$counts = array_map("intval", array_column($chartRows, "jumlah"));
$topLabels = array_column($top, "nama_pelanggan");
$topValues = array_map("floatval", array_column($top, "total"));
require "includes/header.php";
?>
<div class="welcome-row"><div><span class="eyebrow">✦ RINGKASAN TOKO ✦</span><h2>Halo, <?= e($user["nama"]) ?>! <span class="wave">✦</span></h2><p>Selamat datang di TOKOKU. Berikut ringkasan aktivitas tokomu.</p></div><div class="date-chip">◷ <?= date("d F Y") ?></div></div>
<div class="stats-grid">
 <div class="stat-card"><div class="stat-top"><span class="stat-icon purple">♙</span><span class="stat-tag">DATA</span></div><p>Total Pelanggan</p><h3><?= number_format($totalPelanggan) ?></h3><small>Seluruh pelanggan terdaftar</small></div>
 <div class="stat-card"><div class="stat-top"><span class="stat-icon peach">▤</span><span class="stat-tag">AKTIVITAS</span></div><p>Total Transaksi</p><h3><?= number_format($totalTransaksi) ?></h3><small>Transaksi tersimpan</small></div>
 <div class="stat-card"><div class="stat-top"><span class="stat-icon green">↗</span><span class="stat-tag">PENDAPATAN</span></div><p>Total Pendapatan</p><h3 class="money-stat"><?= rupiah($totalPendapatan) ?></h3><small>Akumulasi seluruh transaksi</small></div>
 <div class="stat-card"><div class="stat-top"><span class="stat-icon blue">◎</span><span class="stat-tag">RATA-RATA</span></div><p>Rata-rata Belanja</p><h3 class="money-stat"><?= rupiah($rataRata) ?></h3><small>Per transaksi</small></div>
</div>
<div class="dashboard-grid chart-grid">
 <div class="panel chart-panel"><div class="panel-head"><div><h3>Grafik Pendapatan</h3><p>Perkembangan pendapatan setiap bulan</p></div><span class="mini-pill">Grafik garis</span></div><div class="chart-wrap"><canvas id="incomeChart"></canvas></div></div>
 <div class="panel chart-panel"><div class="panel-head"><div><h3>Jumlah Transaksi</h3><p>Perbandingan transaksi setiap bulan</p></div><span class="mini-pill">Grafik batang</span></div><div class="chart-wrap"><canvas id="transactionChart"></canvas></div></div>
</div>
<div class="dashboard-grid chart-grid second-chart-grid">
 <div class="panel chart-panel"><div class="panel-head"><div><h3>Komposisi Belanja Pelanggan</h3><p>Lima pelanggan berdasarkan total belanja</p></div><span class="mini-pill">Diagram lingkaran</span></div><div class="chart-wrap doughnut-wrap"><canvas id="customerChart"></canvas></div></div>
 <div class="panel"><div class="panel-head"><div><h3>Pelanggan Teratas</h3><p>Berdasarkan total belanja</p></div></div>
 <?php if ($top): foreach ($top as $i=>$r): ?><div class="top-customer"><span class="rank"><?= $i+1 ?></span><div class="customer-initial"><?= strtoupper(substr($r["nama_pelanggan"],0,1)) ?></div><div class="customer-info"><b><?= e($r["nama_pelanggan"]) ?></b><small><?= rupiah($r["total"]) ?></small></div></div><?php endforeach; else: ?><div class="empty-state">Belum ada data pelanggan.</div><?php endif; ?>
 </div>
</div>
<div class="panel table-panel"><div class="panel-head"><div><h3>Transaksi Terbaru</h3><p>Enam transaksi terakhir yang tercatat</p></div><a class="text-link" href="transaksi.php">Lihat semua →</a></div>
<div class="table-scroll"><table><thead><tr><th>ID</th><th>Nama Pelanggan</th><th>Tanggal</th><th>Total Belanja</th><th>Status Data</th></tr></thead><tbody>
<?php if ($terbaru): foreach($terbaru as $t): ?><tr><td class="muted-cell">#<?= e($t["id_transaksi"]) ?></td><td><b><?= e($t["nama_pelanggan"]) ?></b></td><td><?= e($t["tanggal"]) ?></td><td><b><?= rupiah($t["total_belanja"]) ?></b></td><td><span class="status status-ok">Tercatat</span></td></tr><?php endforeach; else: ?><tr><td colspan="5" class="empty-state">Belum ada transaksi.</td></tr><?php endif; ?>
</tbody></table></div></div>
<script>
const chartLabels = <?= json_encode($labels) ?>;
const chartValues = <?= json_encode($values) ?>;
const chartCounts = <?= json_encode($counts) ?>;
const customerLabels = <?= json_encode($topLabels) ?>;
const customerValues = <?= json_encode($topValues) ?>;
const palette = ['#8d304c','#bd7186','#d7a4ae','#e4c4bd','#a45b70','#6e263b'];
const commonOptions = {responsive:true,maintainAspectRatio:false,plugins:{legend:{labels:{color:'#684b54',font:{family:'DM Sans',size:11},usePointStyle:true}}}};
if (window.Chart) {
 const income = document.getElementById('incomeChart');
 if (income) new Chart(income,{type:'line',data:{labels:chartLabels,datasets:[{label:'Pendapatan',data:chartValues,borderColor:'#8d304c',backgroundColor:'rgba(141,48,76,.15)',fill:true,tension:.38,pointRadius:4,pointBackgroundColor:'#8d304c'}]},options:{...commonOptions,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,grid:{color:'rgba(141,48,76,.09)'},ticks:{color:'#8b7279',callback:v=>'Rp '+Number(v).toLocaleString('id-ID')}},x:{grid:{display:false},ticks:{color:'#8b7279'}}}}});
 const trans = document.getElementById('transactionChart');
 if (trans) new Chart(trans,{type:'bar',data:{labels:chartLabels,datasets:[{label:'Jumlah transaksi',data:chartCounts,backgroundColor:'#b96c82',borderRadius:7,maxBarThickness:38}]},options:{...commonOptions,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,grid:{color:'rgba(141,48,76,.09)'},ticks:{precision:0,color:'#8b7279'}},x:{grid:{display:false},ticks:{color:'#8b7279'}}}}});
 const cust = document.getElementById('customerChart');
 if (cust) new Chart(cust,{type:'doughnut',data:{labels:customerLabels,datasets:[{data:customerValues,backgroundColor:palette,borderColor:'#fff8f6',borderWidth:3,hoverOffset:7}]},options:{...commonOptions,cutout:'58%'}});
}
</script>
<?php require "includes/footer.php"; ?>
