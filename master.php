<?php
require_once 'config.php'; require_once 'includes/functions.php'; wajibAdmin();
$jenis=$_GET['jenis']??'barang';
$config=[
 'kategori'=>['judul'=>'Kategori Barang','tabel'=>'tokoku_kategori','pk'=>'id_kategori','fields'=>['nama_kategori'=>'Nama Kategori','keterangan'=>'Keterangan'],'search'=>'nama_kategori'],
 'supplier'=>['judul'=>'Data Supplier','tabel'=>'tokoku_supplier','pk'=>'id_supplier','fields'=>['nama_supplier'=>'Nama Supplier','telepon'=>'Nomor Telepon','alamat'=>'Alamat'],'search'=>'nama_supplier'],
 'barang'=>['judul'=>'Data Barang','tabel'=>'tokoku_barang','pk'=>'id_barang','fields'=>['nama_barang'=>'Nama Barang','id_kategori'=>'Kategori','id_supplier'=>'Supplier','harga'=>'Harga (Rp)','stok'=>'Stok'],'search'=>'nama_barang']
];
if(!isset($config[$jenis])){http_response_code(404);exit('Menu tidak ditemukan');}
$c=$config[$jenis];$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 cekCsrf();$aksi=$_POST['aksi']??'';$id=(int)($_POST['id']??0);
 try{
  if($aksi==='hapus'){$st=$pdo->prepare("DELETE FROM {$c['tabel']} WHERE {$c['pk']}=?");$st->execute([$id]);pesan('success','Data berhasil dihapus.');}
  else{
   $vals=[];foreach($c['fields'] as $f=>$label){$v=$_POST[$f]??'';if($f==='harga')$v=max(0,(float)$v);if($f==='stok')$v=max(0,(int)$v);if(in_array($f,['id_kategori','id_supplier']))$v=$v!==''?(int)$v:null;$vals[$f]=$v;}
   if($aksi==='simpan' && $id){$set=implode(',',array_map(fn($f)=>"$f=?",array_keys($vals)));$st=$pdo->prepare("UPDATE {$c['tabel']} SET $set WHERE {$c['pk']}=?");$st->execute([...array_values($vals),$id]);pesan('success','Data berhasil diperbarui.');}
   else{$cols=implode(',',array_keys($vals));$marks=implode(',',array_fill(0,count($vals),'?'));$st=$pdo->prepare("INSERT INTO {$c['tabel']} ($cols) VALUES ($marks)");$st->execute(array_values($vals));pesan('success','Data baru berhasil ditambahkan.');}
  }
  header('Location: master.php?jenis='.urlencode($jenis));exit;
 }catch(Throwable $e){$err='Data gagal disimpan. Periksa isian dan pastikan data terkait tersedia.';}
}
$edit=null;if(isset($_GET['edit'])){$st=$pdo->prepare("SELECT * FROM {$c['tabel']} WHERE {$c['pk']}=?");$st->execute([(int)$_GET['edit']]);$edit=$st->fetch();}
$rows=$pdo->query("SELECT * FROM {$c['tabel']} ORDER BY {$c['pk']} DESC")->fetchAll();
$kategori=$jenis==='barang'?$pdo->query('SELECT * FROM tokoku_kategori ORDER BY nama_kategori')->fetchAll():[];
$supplier=$jenis==='barang'?$pdo->query('SELECT * FROM tokoku_supplier ORDER BY nama_supplier')->fetchAll():[];
$pageTitle=$c['judul'];require 'includes/header.php';
?>
<div class="page-intro"><div><span class="eyebrow">MASTER DATA TOKOKU</span><h2><?=e($c['judul'])?></h2><p>Tambah, ubah, cari, dan hapus data <?=strtolower(e($c['judul']))?>.</p></div></div>
<?php if($err):?><div class="alert error"><?=e($err)?></div><?php endif;?>
<div class="panel form-panel"><div class="panel-head"><div><h3><?=$edit?'Edit':'Tambah'?> <?=$c['judul']?></h3><p>Isi informasi dengan benar.</p></div></div><form method="post" class="data-form"><input type="hidden" name="csrf" value="<?=e(csrfToken())?>"><input type="hidden" name="aksi" value="simpan"><input type="hidden" name="id" value="<?=e($edit[$c['pk']]??'')?>"><div class="form-grid">
<?php foreach($c['fields'] as $f=>$label):?><div class="field"><label><?=e($label)?></label>
<?php if($f==='id_kategori'||$f==='id_supplier'): $opts=$f==='id_kategori'?$kategori:$supplier;$key=$f==='id_kategori'?'id_kategori':'id_supplier';$name=$f==='id_kategori'?'nama_kategori':'nama_supplier';?><select class="input" name="<?=$f?>"><option value="">Pilih <?=e($label)?></option><?php foreach($opts as $o):?><option value="<?=$o[$key]?>" <?=((string)($edit[$f]??'')===(string)$o[$key])?'selected':''?>><?=e($o[$name])?></option><?php endforeach;?></select>
<?php else:?><input class="input" name="<?=$f?>" type="<?=in_array($f,['harga','stok'])?'number':'text'?>" <?=in_array($f,['harga','stok'])?'min="0"':''?> <?=in_array($f,['nama_kategori','nama_supplier','nama_barang'])?'required':''?> value="<?=e($edit[$f]??'')?>" placeholder="Masukkan <?=e(strtolower($label))?>"><?php endif;?></div><?php endforeach;?></div><div class="form-actions"><button class="btn btn-primary">Simpan Data</button><?php if($edit):?><a class="btn btn-outline" href="master.php?jenis=<?=$jenis?>">Batal</a><?php endif;?></div></form></div>
<div class="panel table-panel"><div class="panel-head"><div><h3>Daftar <?=$c['judul']?></h3><p><?=count($rows)?> data tersimpan</p></div></div><div class="table-scroll"><table><thead><tr><?php foreach($c['fields'] as $label):?><th><?=e($label)?></th><?php endforeach;?><th>Aksi</th></tr></thead><tbody><?php foreach($rows as $r):?><tr><?php foreach($c['fields'] as $f=>$label):?><td><?=e($r[$f]??'-')?></td><?php endforeach;?><td><div class="actions"><a class="action-btn" href="master.php?jenis=<?=$jenis?>&edit=<?=$r[$c['pk']]?>">Edit</a><form method="post" onsubmit="return confirm('Hapus data ini?')"><input type="hidden" name="csrf" value="<?=e(csrfToken())?>"><input type="hidden" name="aksi" value="hapus"><input type="hidden" name="id" value="<?=$r[$c['pk']]?>"><button class="action-btn danger">Hapus</button></form></div></td></tr><?php endforeach;?><?php if(!$rows):?><tr><td colspan="<?=count($c['fields'])+1?>" class="empty-state">Belum ada data.</td></tr><?php endif;?></tbody></table></div></div>
<?php require 'includes/footer.php';?>
