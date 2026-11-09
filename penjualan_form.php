
<?php
require_once 'config.php';
require_once 'includes/functions.php';

wajibAdmin();

$pageTitle = 'Transaksi Penjualan';

$pelanggan = $pdo->query(
    'SELECT id_pelanggan, nama_pelanggan
     FROM tbl_pelanggan
     ORDER BY nama_pelanggan'
)->fetchAll();

$barang = $pdo->query(
    'SELECT id_barang, nama_barang, harga, stok
     FROM tokoku_barang
     WHERE stok > 0
     ORDER BY nama_barang'
)->fetchAll();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cekCsrf();

    $pid = (int) ($_POST['id_pelanggan'] ?? 0);
    $bid = (int) ($_POST['id_barang'] ?? 0);
    $qty = (int) ($_POST['jumlah'] ?? 0);
    $tanggal = $_POST['tanggal'] ?? date('Y-m-d');

    try {
        if ($pid <= 0 || $bid <= 0 || $qty <= 0) {
            throw new Exception('Lengkapi semua data transaksi dengan benar.');
        }

        $pdo->beginTransaction();

        // Periksa pelanggan
        $cekPelanggan = $pdo->prepare(
            'SELECT id_pelanggan FROM tbl_pelanggan WHERE id_pelanggan = ?'
        );
        $cekPelanggan->execute([$pid]);

        if (!$cekPelanggan->fetch()) {
            throw new Exception('Pelanggan tidak ditemukan.');
        }

        // Ambil barang dan kunci stok selama transaksi
        $stmt = $pdo->prepare(
            'SELECT * FROM tokoku_barang
             WHERE id_barang = ?
             FOR UPDATE'
        );
        $stmt->execute([$bid]);
        $b = $stmt->fetch();

        if (!$b) {
            throw new Exception('Barang tidak ditemukan.');
        }

        if ($b['stok'] < $qty) {
            throw new Exception('Stok barang tidak mencukupi.');
        }

        $harga = (float) $b['harga'];
        $total = $harga * $qty;

        // Simpan transaksi utama
        $stmt = $pdo->prepare(
            'INSERT INTO tbl_transaksi
             (tanggal, id_pelanggan, total_belanja)
             VALUES (?, ?, ?)'
        );
        $stmt->execute([$tanggal, $pid, $total]);

        $tid = (int) $pdo->lastInsertId();

        // Simpan detail transaksi
        // Stok dan total akan diperbarui oleh trigger database
        $stmt = $pdo->prepare(
            'INSERT INTO tokoku_detail_transaksi
             (id_transaksi, id_barang, jumlah, harga, subtotal)
             VALUES (?, ?, ?, ?, ?)'
        );

        $stmt->execute([
            $tid,
            $bid,
            $qty,
            $harga,
            $total
        ]);

        $pdo->commit();

        pesan('success', 'Transaksi berhasil disimpan.');

        header('Location: struk.php?id=' . $tid);
        exit;

    } catch (Throwable $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        $error = $e->getMessage();
    }
}

require 'includes/header.php';
?>

<div class="page-intro">
    <div>
        <span class="eyebrow">PENJUALAN TOKOKU</span>
        <h2>Buat Transaksi Baru</h2>
        <p>Pilih pelanggan dan barang yang dibeli.</p>
    </div>

    <a class="btn btn-outline" href="transaksi.php">
        Kembali
    </a>
</div>

<div class="panel form-panel">

    <div class="form-section-title">
        <span class="stat-icon peach">▤</span>
        <div>
            <h3>Detail Penjualan</h3>
            <p>Stok akan otomatis berkurang setelah transaksi disimpan.</p>
        </div>
    </div>

    <?php if ($error): ?>
        <div class="alert error">
            <?= e($error) ?>
        </div>
    <?php endif; ?>

    <form method="post" class="data-form">

        <input
            type="hidden"
            name="csrf"
            value="<?= e(csrfToken()) ?>"
        >

        <div class="form-grid">

            <div class="field">
                <label>Tanggal</label>
                <input
                    class="input"
                    type="date"
                    name="tanggal"
                    value="<?= date('Y-m-d') ?>"
                    required
                >
            </div>

            <div class="field">
                <label>Pelanggan</label>
                <select class="input" name="id_pelanggan" required>
                    <option value="">Pilih pelanggan</option>

                    <?php foreach ($pelanggan as $p): ?>
                        <option value="<?= $p['id_pelanggan'] ?>">
                            <?= e($p['nama_pelanggan']) ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <div class="field">
                <label>Barang</label>
                <select class="input" name="id_barang" required>
                    <option value="">Pilih barang</option>

                    <?php foreach ($barang as $b): ?>
                        <option value="<?= $b['id_barang'] ?>">
                            <?= e($b['nama_barang']) ?>
                            — <?= rupiah($b['harga']) ?>
                            (Stok <?= $b['stok'] ?>)
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <div class="field">
                <label>Jumlah</label>
                <input
                    class="input"
                    type="number"
                    name="jumlah"
                    min="1"
                    value="1"
                    required
                >
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                Simpan & Buat Struk
            </button>
        </div>

    </form>
</div>

<?php require 'includes/footer.php'; ?>
