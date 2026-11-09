<?php
require_once "config.php";require_once "includes/functions.php";wajibAdmin();cekCsrf();$id=(int)($_POST["id"]??0);
try{$s=$pdo->prepare("DELETE FROM tbl_transaksi WHERE id_transaksi=?");$s->execute([$id]);pesan("success","Transaksi berhasil dihapus.");}catch(PDOException $e){pesan("error","Transaksi gagal dihapus.");}
header("Location: transaksi.php");exit;
