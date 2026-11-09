# TOKOKU
## APLIKASI PENJUALAN DAN MANAJEMEN DATA TOKO BERBASIS WEB

---

# DAFTAR ISI

1. Informasi Umum Aplikasi
2. Latar Belakang
3. Tujuan Pembuatan Aplikasi
4. Deskripsi Aplikasi
5. Teknologi yang Digunakan
6. Spesifikasi Sistem
7. Fitur dan Menu Aplikasi
8. Hak Akses Pengguna
9. Struktur Folder dan File
10. Struktur Database
11. Penjelasan Tabel Database
12. View, Trigger, Function, dan Stored Procedure
13. Persiapan Sebelum Instalasi
14. Cara Instalasi Aplikasi
15. Konfigurasi Database
16. Cara Menjalankan Aplikasi
17. Panduan Login
18. Panduan Penggunaan Setiap Menu
19. Alur Proses Transaksi Penjualan
20. Cara Mencetak Struk
21. Pengelolaan Stok Barang
22. Laporan dan Statistik
23. Keamanan Aplikasi
24. Pengujian Aplikasi
25. Pemecahan Masalah (Troubleshooting)
26. Pemeliharaan dan Pengembangan
27. Penutup

---

# 1. INFORMASI UMUM APLIKASI

| Keterangan | Informasi |
|---|---|
| Nama Aplikasi | TOKOKU |
| Jenis Aplikasi | Website Penjualan dan Manajemen Toko |
| Platform | Web Browser |
| Bahasa Pemrograman | PHP Native |
| Database | MySQL/MariaDB |
| Web Server | Apache |
| Local Server | XAMPP |
| Code Editor | Visual Studio Code |
| Nama Database | tokoku |
| Bahasa Tampilan | Bahasa Indonesia |

TOKOKU merupakan aplikasi berbasis website yang dikembangkan untuk membantu proses pengelolaan toko, mulai dari pengelolaan barang, kategori, supplier, pelanggan, stok, transaksi penjualan, hingga laporan.

# 2. LATAR BELAKANG

Dalam kegiatan operasional sebuah toko, pengelolaan data merupakan salah satu hal yang penting. Data barang, jumlah persediaan, informasi pelanggan, dan transaksi penjualan perlu dicatat dengan baik agar kegiatan operasional dapat berjalan secara teratur.

Apabila pengelolaan masih dilakukan secara manual, beberapa kendala dapat terjadi, seperti kesulitan mencari data barang, kesalahan pencatatan transaksi, ketidaksesuaian jumlah stok, serta kesulitan dalam membuat laporan penjualan.

Berdasarkan permasalahan tersebut, dibuatlah aplikasi TOKOKU sebagai sistem pengelolaan toko berbasis website.

Dengan adanya aplikasi ini, proses pengelolaan data dapat dilakukan melalui satu sistem yang terhubung dengan database sehingga informasi lebih mudah disimpan, dicari, diperbarui, dan ditampilkan kembali.

# 3. TUJUAN PEMBUATAN APLIKASI

Tujuan pembuatan aplikasi TOKOKU adalah:

1. Mempermudah pengelolaan data barang yang tersedia di toko.
2. Mempermudah pengelompokan barang berdasarkan kategori.
3. Menyimpan informasi supplier atau pemasok barang.
4. Mengelola data pelanggan secara terstruktur.
5. Membantu proses pencatatan transaksi penjualan.
6. Mengurangi kesalahan dalam perhitungan total belanja.
7. Membantu pemantauan jumlah stok barang.
8. Mempermudah pembuatan dan pencetakan struk transaksi.
9. Menyediakan informasi laporan penjualan.
10. Mengelola akun pengguna berdasarkan hak akses.
11. Menggunakan database untuk menyimpan informasi secara terpusat.
12. Menerapkan konsep pengelolaan database seperti tabel relasi, view, trigger, function, dan stored procedure sesuai kebutuhan sistem.

# 4. DESKRIPSI APLIKASI

TOKOKU adalah aplikasi penjualan berbasis web yang menggunakan PHP Native sebagai bahasa pemrograman sisi server dan MySQL/MariaDB sebagai sistem pengelolaan database.

Aplikasi ini memiliki beberapa bagian utama, yaitu:

- Dashboard: halaman utama untuk menampilkan ringkasan informasi.
- Master Data: bagian untuk mengelola barang, kategori, supplier, dan pelanggan.
- Transaksi: bagian untuk mencatat kegiatan penjualan.
- Stok Barang: bagian untuk melihat dan memantau persediaan.
- Laporan: bagian untuk melihat informasi hasil transaksi.
- Pengguna: bagian untuk mengelola akun aplikasi.
- Struk: bagian untuk menampilkan bukti transaksi penjualan.

Setiap bagian memiliki fungsi masing-masing dan menggunakan database TOKOKU sebagai tempat penyimpanan data.

# 5. TEKNOLOGI YANG DIGUNAKAN

## 5.1 PHP Native

PHP Native digunakan untuk membangun logika aplikasi tanpa menggunakan framework seperti Laravel.

PHP digunakan untuk:
- Memproses data formulir.
- Menghubungkan website dengan database.
- Menampilkan data dari database.
- Menyimpan data baru.
- Mengubah data.
- Menghapus data.
- Memproses transaksi penjualan.
- Mengatur proses login dan logout.

## 5.2 MySQL/MariaDB

MySQL/MariaDB digunakan sebagai sistem manajemen database.

Database menyimpan:
- Data pelanggan.
- Data transaksi.
- Data pengguna.
- Data barang.
- Data kategori.
- Data supplier.
- Detail transaksi.
- Riwayat stok.
- Log aktivitas.

## 5.3 HTML

HTML digunakan untuk menyusun struktur halaman website, seperti judul, formulir, tabel, tombol, dan navigasi.

## 5.4 CSS

CSS digunakan untuk mengatur tampilan aplikasi, termasuk warna, ukuran tulisan, tata letak, tombol, tabel, dan desain halaman.

## 5.5 JavaScript

JavaScript digunakan untuk mendukung interaksi pada halaman website sesuai kebutuhan aplikasi.

## 5.6 XAMPP

XAMPP digunakan sebagai server lokal yang menyediakan Apache dan MySQL/MariaDB sehingga aplikasi dapat dijalankan melalui komputer sendiri.

## 5.7 Visual Studio Code

Visual Studio Code digunakan untuk membuat, mengedit, dan mengelola file program aplikasi TOKOKU.

# 6. SPESIFIKASI SISTEM

## 6.1 Perangkat Keras

Spesifikasi perangkat keras yang disarankan:

- Komputer atau laptop.
- Keyboard dan mouse.
- RAM minimal 4 GB.
- Ruang penyimpanan yang cukup.
- Monitor atau layar komputer.

## 6.2 Perangkat Lunak

Perangkat lunak yang diperlukan:

- Sistem operasi Windows.
- XAMPP.
- PHP.
- MySQL/MariaDB.
- Visual Studio Code.
- Browser seperti Google Chrome, Microsoft Edge, atau Mozilla Firefox.

## 6.3 Koneksi Sistem

Aplikasi dijalankan menggunakan server lokal dengan alamat:

`http://localhost/tokoku_website/`

Database menggunakan nama:

`tokoku`

# 7. FITUR DAN MENU APLIKASI

## 7.1 Dashboard

Dashboard merupakan halaman utama aplikasi setelah pengguna berhasil login.

Fungsinya:
- Menampilkan ringkasan informasi toko.
- Menjadi halaman awal navigasi aplikasi.
- Mempermudah pengguna mengakses menu lainnya.
- Menampilkan informasi statistik jika fitur statistik telah tersedia.

## 7.2 Data Barang

Menu Data Barang digunakan untuk mengelola informasi barang yang dijual.

Informasi barang meliputi:
- ID barang.
- Nama barang.
- Kategori.
- Supplier.
- Harga.
- Jumlah stok.
- Deskripsi barang.

Operasi pengelolaan:
- Menambah barang.
- Melihat daftar barang.
- Mengubah informasi barang.
- Menghapus barang.

## 7.3 Data Kategori

Menu kategori digunakan untuk mengelompokkan barang berdasarkan jenisnya.

Contoh kategori:
- Makanan.
- Minuman.
- Perlengkapan.

Tujuannya agar data barang lebih mudah dikelompokkan dan dicari.

## 7.4 Data Supplier

Menu supplier digunakan untuk menyimpan informasi pemasok barang.

Informasi yang disimpan:
- ID supplier.
- Nama supplier.
- Nomor telepon.
- Alamat supplier.

## 7.5 Data Pelanggan

Menu pelanggan digunakan untuk mengelola informasi pelanggan.

Data pelanggan meliputi:
- ID pelanggan.
- Nama pelanggan.
- Kota.

Fitur pengelolaan:
- Tambah pelanggan.
- Lihat data pelanggan.
- Edit pelanggan.
- Hapus pelanggan.

## 7.6 Transaksi Penjualan

Menu transaksi digunakan untuk mencatat penjualan barang kepada pelanggan.

Informasi transaksi:
- ID transaksi.
- Tanggal transaksi.
- Pelanggan.
- Barang yang dibeli.
- Jumlah barang.
- Harga barang.
- Subtotal.
- Total belanja.

## 7.7 Detail Transaksi

Detail transaksi digunakan untuk menyimpan rincian barang yang terdapat dalam suatu transaksi.

Setiap detail transaksi terhubung dengan:
- ID transaksi.
- ID barang.
- Jumlah pembelian.
- Harga barang.
- Subtotal.

## 7.8 Stok Barang

Menu stok digunakan untuk melihat jumlah persediaan barang.

Fitur ini membantu pengguna mengetahui barang yang masih tersedia dan memantau perubahan jumlah stok.

## 7.9 Cetak Struk

Menu cetak struk digunakan untuk menampilkan bukti transaksi.

Informasi struk dapat meliputi:
- Nomor transaksi.
- Tanggal transaksi.
- Nama pelanggan.
- Nama barang.
- Jumlah barang.
- Harga satuan.
- Subtotal.
- Total belanja.

## 7.10 Laporan

Menu laporan digunakan untuk melihat informasi hasil pengelolaan toko.

Laporan dapat mencakup:
- Laporan transaksi.
- Total belanja pelanggan.
- Laporan stok barang.
- Rekap penjualan barang.

## 7.11 Kelola Pengguna

Menu pengguna digunakan untuk mengelola akun yang dapat mengakses aplikasi.

Data pengguna mengikuti struktur tabel `users` yang digunakan oleh aplikasi.

Pengaturan hak akses ditentukan oleh sistem login dan pemeriksaan role pengguna.

# 8. HAK AKSES PENGGUNA

Aplikasi TOKOKU dirancang menggunakan dua jenis hak akses.

## 8.1 Admin

Admin memiliki hak akses pengelolaan aplikasi sesuai aturan yang diterapkan.

Tugas admin meliputi:
- Mengakses dashboard.
- Mengelola data barang.
- Mengelola kategori.
- Mengelola supplier.
- Mengelola pelanggan.
- Mengakses transaksi.
- Memantau stok.
- Melihat laporan.
- Mengelola pengguna.

## 8.2 User

User merupakan pengguna aplikasi dengan hak akses yang dibatasi sesuai pengaturan sistem.

Hak akses user mengikuti pemeriksaan role pada setiap halaman. User hanya dapat membuka fitur yang memang diizinkan oleh aplikasi.

Catatan: Hak akses setiap menu harus disesuaikan dengan implementasi kode program yang digunakan.

# 9. STRUKTUR FOLDER DAN FILE

Berikut struktur folder utama aplikasi TOKOKU:

```text
tokoku_website/
│
├── assets/
│   ├── style.css
│   ├── app.js
│   └── file pendukung lainnya
│
├── includes/
│   ├── header.php
│   ├── footer.php
│   └── functions.php
│
├── config.php
├── database.php
├── index.php
├── login.php
├── logout.php
├── dashboard.php
│
├── master.php
├── stok.php
│
├── pelanggan.php
├── pelanggan_form.php
├── pelanggan_hapus.php
│
├── transaksi.php
├── transaksi_form.php
├── transaksi_hapus.php
├── penjualan_form.php
├── struk.php
│
├── laporan.php
├── pengguna.php
├── setup.php
│
├── README.md
└── README.txt
```

## Penjelasan File

### config.php
Digunakan untuk mengatur koneksi aplikasi dengan database menggunakan PDO.

### database.php
Digunakan sebagai file pendukung pengelolaan database sesuai implementasi program.

### index.php
Merupakan halaman awal yang mengarahkan pengguna ke halaman aplikasi.

### login.php
Digunakan untuk proses autentikasi atau masuk ke aplikasi.

### logout.php
Digunakan untuk mengakhiri sesi pengguna.

### dashboard.php
Digunakan untuk menampilkan halaman utama aplikasi.

### master.php
Digunakan untuk mengelola data master seperti barang, kategori, dan supplier sesuai fitur yang tersedia.

### stok.php
Digunakan untuk menampilkan informasi persediaan barang.

### pelanggan.php
Digunakan untuk menampilkan dan mengelola data pelanggan.

### pelanggan_form.php
Digunakan untuk menambah atau mengubah data pelanggan.

### pelanggan_hapus.php
Digunakan untuk menghapus data pelanggan.

### transaksi.php
Digunakan untuk menampilkan daftar transaksi penjualan.

### transaksi_form.php
Digunakan untuk formulir transaksi sesuai implementasi aplikasi.

### penjualan_form.php
Digunakan untuk membuat transaksi penjualan baru.

### transaksi_hapus.php
Digunakan untuk menghapus transaksi sesuai aturan aplikasi.

### struk.php
Digunakan untuk menampilkan bukti transaksi dan menyediakan proses pencetakan jika fitur cetak sudah diaktifkan.

### laporan.php
Digunakan untuk menampilkan informasi laporan.

### pengguna.php
Digunakan untuk mengelola data akun pengguna.

### setup.php
Digunakan untuk proses persiapan atau pembuatan struktur database tambahan sesuai isi file tersebut.

### includes/functions.php
Berisi fungsi pendukung aplikasi, misalnya fungsi autentikasi, notifikasi, keamanan formulir, dan format tampilan data.

### includes/header.php
Berisi bagian atas halaman dan navigasi aplikasi.

### includes/footer.php
Berisi bagian bawah halaman aplikasi.

### assets/
Berisi file CSS, JavaScript, gambar, dan aset pendukung tampilan.

# 10. STRUKTUR DATABASE

Nama database yang digunakan:

`tokoku`

Database TOKOKU menggabungkan tabel dari tugas Advanced Database Programming dengan tabel tambahan untuk mendukung fitur penjualan dan manajemen toko.

Database yang telah dibuat memiliki beberapa tabel dan view.

## 10.1 Daftar Tabel

1. `users`
2. `tbl_pelanggan`
3. `tbl_transaksi`
4. `log_pelanggan`
5. `log_perubahan_pelanggan`
6. `tokoku_barang`
7. `tokoku_kategori`
8. `tokoku_supplier`
9. `tokoku_detail_transaksi`
10. `tokoku_riwayat_stok`
11. `tokoku_log_aktivitas`

## 10.2 Daftar View

1. `view_laporan_transaksi`
2. `view_total_belanja`
3. `view_laporan_stok`
4. `view_penjualan_barang`

Jumlah tabel dan view dapat bertambah apabila ada pengembangan database.

# 11. PENJELASAN TABEL DATABASE

## 11.1 Tabel users

Digunakan untuk menyimpan akun pengguna aplikasi.

Fungsinya:
- Menyimpan informasi akun.
- Menyimpan username.
- Menyimpan password yang diproses sesuai sistem autentikasi.
- Menyimpan informasi role atau hak akses jika kolom tersebut tersedia.

## 11.2 Tabel tbl_pelanggan

Digunakan untuk menyimpan informasi pelanggan.

Kolom:
- `id_pelanggan`: identitas unik pelanggan.
- `nama_pelanggan`: nama pelanggan.
- `kota`: kota asal pelanggan.

## 11.3 Tabel tbl_transaksi

Digunakan untuk menyimpan transaksi utama.

Kolom:
- `id_transaksi`: identitas transaksi.
- `tanggal`: tanggal transaksi.
- `id_pelanggan`: hubungan dengan pelanggan.
- `total_belanja`: total nilai transaksi.

## 11.4 Tabel tokoku_kategori

Digunakan untuk menyimpan kelompok barang.

Kolom:
- `id_kategori`: identitas kategori.
- `nama_kategori`: nama kategori.
- `keterangan`: penjelasan kategori.

## 11.5 Tabel tokoku_supplier

Digunakan untuk menyimpan data pemasok.

Kolom:
- `id_supplier`: identitas supplier.
- `nama_supplier`: nama pemasok.
- `no_telepon`: nomor telepon pemasok.
- `alamat`: alamat pemasok.

## 11.6 Tabel tokoku_barang

Digunakan untuk menyimpan informasi barang yang dijual.

Kolom:
- `id_barang`: identitas barang.
- `nama_barang`: nama barang.
- `id_kategori`: hubungan dengan kategori.
- `id_supplier`: hubungan dengan supplier.
- `harga`: harga barang.
- `stok`: jumlah persediaan.
- `deskripsi`: keterangan barang.
- `created_at`: waktu pembuatan data.

## 11.7 Tabel tokoku_detail_transaksi

Digunakan untuk menyimpan rincian barang dalam transaksi.

Kolom:
- `id_detail`: identitas detail transaksi.
- `id_transaksi`: hubungan dengan transaksi utama.
- `id_barang`: hubungan dengan barang.
- `jumlah`: jumlah barang yang dibeli.
- `harga`: harga satuan barang.
- `subtotal`: hasil perkalian harga dan jumlah.

Rumus subtotal:

`Subtotal = Harga Barang × Jumlah Pembelian`

## 11.8 Tabel tokoku_riwayat_stok

Digunakan untuk mencatat perubahan persediaan barang.

Kolom:
- `id_riwayat`: identitas riwayat.
- `id_barang`: barang yang mengalami perubahan.
- `jenis_perubahan`: jenis perubahan stok.
- `jumlah`: jumlah perubahan.
- `keterangan`: informasi tambahan.
- `tanggal`: waktu perubahan.

## 11.9 Tabel tokoku_log_aktivitas

Digunakan untuk menyimpan catatan aktivitas pengguna.

Kolom:
- `id_log`: identitas log.
- `id_user`: ident
