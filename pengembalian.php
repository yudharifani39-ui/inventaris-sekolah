<?php require 'fungsi.php';wajib_login();$uid=(int)$_SESSION['user']['id_user'];$K=['Baik','Rusak Ringan','Rusak Berat'];
if(isset($_POST['simpan'])){$id=(int)$_POST['id_peminjaman'];$tg=esc($_POST['tanggal_kembali']);$kon=in_array($_POST['kondisi_kembali'],$K)?$_POST['kondisi_kembali']:'Baik';$ket=esc($_POST['keterangan']);
 $p=satu("SELECT p.*,b.nama_barang FROM peminjaman p JOIN barang b ON b.id_barang=p.id_barang WHERE p.id_peminjaman=$id AND p.status='Dipinjam'");
 if(!$p)flash('Peminjaman tidak ditemukan atau sudah dikembalikan.');
 else{q("INSERT INTO pengembalian(id_peminjaman,id_user,tanggal_kembali,kondisi_kembali,keterangan) VALUES($id,$uid,'$tg','$kon','$ket')");
  q("UPDATE peminjaman SET status='Kembali' WHERE id_peminjaman=$id");
  q("UPDATE barang SET kondisi='$kon' WHERE id_barang={$p['id_barang']}");sinkron_status($p['id_barang']);
  catat('Pengembalian '.$p['nama_barang'].' ('.kode_pj($id).')');flash('Pengembalian dicatat, status & kondisi barang diperbarui.');}
 pindah('pengembalian.php');}
$cari=trim($_GET['cari']??'');$pj=null;
if($cari!==''){$no=(int)preg_replace('/\D/','',$cari);$pj=satu("SELECT p.*,b.nama_barang FROM peminjaman p JOIN barang b ON b.id_barang=p.id_barang WHERE p.id_peminjaman=$no");}
$aktif=semua("SELECT p.id_peminjaman,p.nama_peminjam,b.nama_barang FROM peminjaman p JOIN barang b ON b.id_barang=p.id_barang WHERE p.status='Dipinjam'");
$data=semua("SELECT g.*,p.nama_peminjam,p.jumlah,b.nama_barang FROM pengembalian g JOIN peminjaman p ON p.id_peminjaman=g.id_peminjaman JOIN barang b ON b.id_barang=p.id_barang ORDER BY g.id_pengembalian DESC");include 'header.php';?>
<h1>Pengembalian Barang</h1>
<div class="panel"><form method="get" style="display:flex;gap:10px"><input name="cari" placeholder="Cari nomor peminjaman... (contoh PJ-001)" value="<?=e($cari)?>" style="margin:0"><button>Cari</button></form>
<?php if($cari!==''&&!$pj)echo "<p>Nomor peminjaman tidak ditemukan.</p>"; elseif($pj&&$pj['status']!='Dipinjam')echo "<p>Peminjaman ".kode_pj($pj['id_peminjaman'])." sudah dikembalikan.</p>";
elseif(!$pj&&$aktif){echo "<p>Peminjaman aktif: ";foreach($aktif as $a)echo "<a href='?cari=".kode_pj($a['id_peminjaman'])."'>".kode_pj($a['id_peminjaman'])."</a> (".e($a['nama_peminjam']).") &nbsp; ";echo "</p>";}?></div>
<?php if($pj&&$pj['status']=='Dipinjam'){?>
<div class="panel"><div class="info"><div><small>No. Peminjaman</small><b><?=kode_pj($pj['id_peminjaman'])?></b></div><div><small>Nama Peminjam</small><b><?=e($pj['nama_peminjam'])?></b></div><div><small>Tanggal Pinjam</small><b><?=tgl($pj['tanggal_pinjam'])?></b></div></div>
<form method="post"><input type="hidden" name="id_peminjaman" value="<?=$pj['id_peminjaman']?>"><h3>Barang yang Dikembalikan</h3>
<table><tr><th>No</th><th>Nama Barang</th><th>Jumlah Dipinjam</th><th>Jumlah Dikembalikan</th><th>Kondisi</th></tr>
<tr><td>1</td><td><?=e($pj['nama_barang'])?></td><td><?=$pj['jumlah']?></td><td><input value="<?=$pj['jumlah']?>" readonly style="margin:0;text-align:center"></td><td><select name="kondisi_kembali" style="margin:0"><?php pilihan($K,'Baik')?></select></td></tr></table><br>
<label>Tanggal Kembali</label><input type="date" name="tanggal_kembali" value="<?=date('Y-m-d')?>" required>
<label>Keterangan (Opsional)</label><textarea name="keterangan" rows="3" placeholder="Masukkan keterangan..."></textarea>
<div class="kanan"><a class="btn putih" href="pengembalian.php">Batal</a> <button name="simpan">Simpan Pengembalian</button></div></form></div><?php }?>
<div class="panel"><h3>Riwayat Pengembalian</h3><table><tr><th>No. Peminjaman</th><th>Barang</th><th>Peminjam</th><th>Jumlah</th><th>Tgl Kembali</th><th>Kondisi</th><th>Keterangan</th></tr>
<?php foreach($data as $d)echo "<tr><td>".kode_pj($d['id_peminjaman'])."</td><td>".e($d['nama_barang'])."</td><td>".e($d['nama_peminjam'])."</td><td>{$d['jumlah']}</td><td>".tgl($d['tanggal_kembali'])."</td><td>".e($d['kondisi_kembali'])."</td><td>".e($d['keterangan'])."</td></tr>";?></table></div>
<?php include 'footer.php';
