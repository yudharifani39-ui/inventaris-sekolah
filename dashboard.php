<?php require 'fungsi.php';wajib_login();
$s=statistik();$adm=$_SESSION['user']['role']=='Administrator';$tot=max(1,$s['total']);
$kat=semua("SELECT k.nama_kategori n,COALESCE(SUM(b.jumlah),0) j FROM kategori k LEFT JOIN barang b ON b.id_kategori=k.id_kategori GROUP BY k.id_kategori,k.nama_kategori");
$mx=1;foreach($kat as $k)$mx=max($mx,$k['j']);
$pengguna=semua("SELECT * FROM user ORDER BY id_user LIMIT 5");
include 'header.php';?>
<div class="sambut"><div><h1>Selamat Datang, <?=e($_SESSION['user']['nama_lengkap'])?>!</h1><p class="sub">Kelola data inventaris sekolah dengan mudah.</p></div><img src="img/laptop.png" alt=""></div>
<?php kartu_stat();?>
<div class="panel"><h3>Grafik Inventaris</h3><div class="grafik"><?php foreach($kat as $k){?><div class="kol"><div class="bar" style="height:<?=round($k['j']/$mx*85)?>%"></div><small><?=e($k['n'])?> (<?=$k['j']?>)</small></div><?php }?></div></div>
<?php if($adm){?>
<div class="dua"><div class="panel"><h3>Kondisi Inventaris</h3><div class="tumpuk"><span style="width:<?=$s['baik']/$tot*100?>%;background:#46b680"></span><span style="width:<?=$s['perlu']/$tot*100?>%;background:#f39c3d"></span><span style="width:<?=$s['rusak']/$tot*100?>%;background:#e74c3c"></span></div>
Baik: <b><?=$s['baik']?></b> &nbsp; Perlu perbaikan: <b><?=$s['perlu']?></b> &nbsp; Rusak: <b><?=$s['rusak']?></b></div>
<div class="panel"><h3>Akses Cepat</h3><a class="btn" href="barang.php?tambah=1">+ Tambah Barang</a> <a class="btn putih" href="laporan.php">Lihat Laporan</a></div></div>
<div class="panel"><div class="baris"><div><h3>Pengelolaan Pengguna</h3>Atur akun dan hak akses pengguna sekolah.</div><a class="btn" href="user.php">+ Tambah Pengguna</a></div>
<table><tr><th>No</th><th>Nama Pengguna</th><th>Peran</th><th>Status</th><th>Tindakan</th></tr>
<?php foreach($pengguna as $i=>$d)echo "<tr><td>".($i+1)."</td><td>".e($d['nama_lengkap'])."</td><td>".e($d['role'])."</td><td>Aktif</td><td><a href='user.php?edit={$d['id_user']}'>Edit</a></td></tr>";?></table></div>
<?php }?>
<?php include 'footer.php';
