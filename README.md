# TOKOKU — Sistem Manajemen Toko

Website manajemen toko menggunakan **PHP Native**, **MySQL/MariaDB**, HTML, CSS, dan JavaScript. Website ini terhubung ke database `tokoku` yang berisi materi SQL Lanjutan BAB 1–5.

## Fitur Website

- Login dan logout dengan dua hak akses: **Admin** dan **User**.
- Dashboard dengan ringkasan statistik pelanggan dan transaksi serta grafik.
- Data pelanggan: lihat, cari, tambah orang/pelanggan baru, edit, dan hapus (khusus Admin).
- Master data: kategori barang, barang, dan supplier dengan fitur tambah, edit, dan hapus.
- Stok barang: melihat persediaan dan memperbarui jumlah stok.
- Transaksi penjualan: memilih pelanggan dan barang, menghitung total otomatis, serta mengurangi stok setelah transaksi berhasil.
- Cetak struk penjualan melalui tombol Cetak Struk pada riwayat transaksi.
- Data transaksi: lihat, tambah, dan hapus transaksi (sesuai hak akses yang tersedia pada aplikasi).
- Laporan transaksi dan total belanja.
- Halaman fitur database yang menampilkan View, Stored Procedure, Stored Function, Trigger, serta log pelanggan.
- Kelola pengguna khusus Admin: tambah akun orang baru, ubah nama/username/hak akses, ganti kata sandi, dan hapus akun.
- Navigasi samping tetap tersedia pada halaman fitur agar mudah berpindah halaman.

## Persyaratan

- XAMPP dengan Apache dan MySQL/MariaDB.
- PHP 8.0 atau lebih baru.
- Database bernama `tokoku`.
- Tabel dan objek SQL BAB 1–5 yang digunakan aplikasi, yaitu `tbl_pelanggan`, `tbl_transaksi`, View, Procedure, Function, dan Trigger sesuai jobsheet.

## Cara Memasang

1. Ekstrak folder `tokoku_website` ke folder `C:\xampp\htdocs\`.
2. Jalankan **Apache** dan **MySQL** dari XAMPP Control Panel.
3. Pastikan database `tokoku` sudah dibuat dan tabel BAB 1–5 sudah tersedia.
4. Buka `config.php`. Pengaturan bawaan menggunakan host `localhost`, username MySQL `root`, dan password kosong. Sesuaikan jika konfigurasi MySQL berbeda.
5. Buka alamat berikut di browser:

   `http://localhost/tokoku_website/setup.php`

6. Jika halaman menyatakan website siap digunakan, lanjutkan ke:

   `http://localhost/tokoku_website/login.php`

7. Setelah setup berhasil, hapus `setup.php` dari folder website.

> **Catatan:** `setup.php` membuat tabel akun website serta tabel tambahan `tokoku_kategori`, `tokoku_supplier`, `tokoku_barang`, dan `tokoku_detail_transaksi` jika belum tersedia. File ini tidak menghapus atau membuat ulang tabel tugas BAB 1–5.

## Akun Demo

| Hak Akses | Username | Kata Sandi |
|---|---|---|
| Admin | `admin` | `admin123` |
| User | `user` | `user123` |

Segera ganti kata sandi demo setelah berhasil masuk.

## Hak Akses

| Fitur | Admin | User |
|---|:---:|:---:|
| Dashboard dan statistik | ✓ | ✓ |
| Melihat data pelanggan | ✓ | ✓ |
| Menambah, mengubah, dan menghapus pelanggan | ✓ | — |
| Melihat data transaksi dan laporan | ✓ | ✓ |
| Mengelola barang, kategori, supplier, dan stok | ✓ | — |
| Membuat transaksi penjualan dan mencetak struk | ✓ | — |
| Mengelola akun Admin/User | ✓ | — |
| Melihat informasi objek database BAB 1–5 | ✓ | ✓ |

## Menambahkan Orang Baru

Ada dua jenis data orang yang dapat ditambahkan:

1. **Pelanggan toko:** masuk sebagai Admin, buka menu **Data Pelanggan**, lalu klik **Tambah Pelanggan**. Isi nama pelanggan dan kota, kemudian tekan **Simpan Pelanggan**.
2. **Akun untuk login website:** masuk sebagai Admin, buka menu **Kelola Pengguna**, isi nama lengkap, nama pengguna, kata sandi minimal 6 karakter, dan hak akses. Tekan **Tambahkan Orang Baru**. Orang tersebut selanjutnya dapat login menggunakan username dan kata sandinya.

Pada menu **Kelola Pengguna**, Admin juga dapat menekan **Edit** untuk memperbarui data akun. Kata sandi boleh dikosongkan saat edit jika tidak ingin menggantinya.

## Struktur Folder

```text
tokoku_website/
├── assets/          # CSS dan JavaScript
├── includes/        # Header, footer, dan fungsi bantuan
├── config.php       # Koneksi database
├── setup.php        # Pembuatan tabel akun website (jalankan sekali)
├── login.php        # Halaman login
├── dashboard.php    # Dashboard dan statistik
├── pelanggan.php    # Daftar pelanggan
├── pelanggan_form.php # Tambah dan edit pelanggan
├── master.php       # Kategori, barang, dan supplier
├── stok.php         # Pengelolaan stok
├── penjualan_form.php # Input transaksi penjualan
├── struk.php        # Tampilan dan cetak struk
├── transaksi.php    # Riwayat transaksi dan cetak struk
├── laporan.php      # Laporan
├── database.php     # Informasi objek database BAB 1–5
└── pengguna.php     # Kelola akun Admin/User
```

## Catatan Teknis

- Koneksi database menggunakan PDO dan prepared statement.
- Kata sandi akun disimpan menggunakan `password_hash()` dan diverifikasi saat login.
- Formulir yang mengubah data menggunakan token CSRF.
- Grafik memakai Chart.js dari CDN sehingga membutuhkan koneksi internet saat memuat pustaka grafik.
- Nama tabel/kolom database harus sesuai dengan yang digunakan di file PHP. Jika muncul pesan tabel atau kolom tidak ditemukan, periksa kembali struktur database `tokoku`.
