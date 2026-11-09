<?php
require_once "config.php";require_once "includes/functions.php";wajibAdmin();cekCsrf();
$id=(int)($_POST["id"]??0);
try{$s=$pdo->prepare("DELETE FROM tbl_pelanggan WHERE id_pelanggan=?");$s->execute([$id]);pesan("success","Data pelanggan berhasil dihapus.");}
catch(PDOException $e){pesan("error","Pelanggan tidak dapat dihapus karena masih memiliki transaksi. Hapus atau ubah transaksi terkait terlebih dahulu.");}
header("Location: pelanggan.php");exit;
