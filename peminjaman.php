<?php require 'fungsi.php';wajib_login();$uid=(int)$_SESSION['user']['id_user'];
if(isset($_POST['simpan'])){$id=(int)$_POST['id'];$n=esc($_POST['nama_peminjam']);$kp=esc($_POST['keperluan']);$tp=esc($_POST['tanggal_pinjam']);$tr=esc($_POST['tanggal_kembali_rencana']);
 if($tr<$tp){flash('Tanggal pengembalian tidak boleh sebelum tanggal peminjaman.');pindah('peminjaman.php');}
 if($id){q("UPDATE peminjaman SET nama_peminjam='$n',keperluan='$kp',tanggal_pinjam='$tp',tanggal_kembali_rencana='$tr' WHERE id_peminjaman=$id");flash('Data diubah.');}
 else{$b=(int)$_POST['id_barang'];$jm=(int)$_POST['jumlah'];$br=satu("SELECT * FROM barang WHERE id_barang=$b");
  if(!$br)flash('Barang tidak ditemukan.');
  elseif($br['kondisi']=='Rusak Berat')flash('Barang rusak berat, tidak bisa dipinjam.');
  elseif(sisa($b)<=0)flash('Barang sedang dipinjam, tidak bisa dipinjam lagi.');
  elseif($jm<1||$jm>sisa($b))flash('Jumlah tidak valid. Sisa barang tersedia: '.sisa($b));
  else{q("INSERT INTO peminjaman(id_barang,id_user,nama_peminjam,jumlah,keperluan,tanggal_pinjam,tanggal_kembali_rencana) VALUES($b,$uid,'$n',$jm,'$kp','$tp','$tr')");sinkron_status($b);catat('Peminjaman '.$br['nama_barang'].' oleh '.$_POST['nama_peminjam']);flash('Peminjaman dicatat.');}}
 pindah('peminjaman.php');}
if(isset($_GET['hapus'])){$id=(int)$_GET['hapus'];$p=satu("SELECT * FROM peminjaman WHERE id_peminjaman=$id");
 if($p){q("DELETE FROM peminjaman WHERE id_peminjaman=$id");sinkron_status($p['id_barang']);flash('Data dihapus.');}pindah('peminjaman.php');}
$ed=isset($_GET['edit'])?satu("SELECT * FROM peminjaman WHERE id_peminjaman=".(int)$_GET['edit']):null;$tampil=$ed||isset($_GET['tambah']);
$brg=semua("SELECT id_barang,kode_barang,nama_barang FROM barang WHERE kondisi<>'Rusak Berat'");
$users=semua("SELECT nama_lengkap FROM user");
$data=semua("SELECT p.*,b.nama_barang FROM peminjaman p JOIN barang b ON b.id_barang=p.id_barang ORDER BY p.id_peminjaman DESC".(isset($_GET['semua'])?'':' LIMIT 5'));include 'header.php';?>
<h1>Peminjaman Barang</h1>
<div class="kanan baris" style="justify-content:flex-end"><button type="button" onclick="document.getElementById('f').style.display='block'">+ Tambah Peminjaman</button></div>
<div class="panel" id="f" style="<?=$tampil?'':'display:none'?>"><form method="post"><input type="hidden" name="id" value="<?=e($ed['id_peminjaman']??0)?>"><div class="form2">
<div><label>Nama Peminjam *</label><input name="nama_peminjam" list="dl" placeholder="Pilih atau isi nama..." value="<?=e($ed['nama_peminjam']??'')?>" required><datalist id="dl"><?php foreach($users as $x)echo "<option value='".e($x['nama_lengkap'])."'>";?></datalist></div>
<div><label>Tanggal Peminjaman *</label><input type="date" name="tanggal_pinjam" value="<?=e($ed['tanggal_pinjam']??date('Y-m-d'))?>" required></div>
<div><label>Nama Barang *</label><?php if($ed){?><input value="<?=e(satu("SELECT nama_barang n FROM barang WHERE id_barang={$ed['id_barang']}")['n'])?>" disabled><?php }else{?><select name="id_barang" required><option value="">Pilih Barang...</option><?php foreach($brg as $x)echo "<option value='{$x['id_barang']}'>".e($x['kode_barang'].' - '.$x['nama_barang'])." (sisa ".sisa($x['id_barang']).")</option>";?></select><?php }?></div>
<div><label>Tanggal Pengembalian *</label><input type="date" name="tanggal_kembali_rencana" value="<?=e($ed['tanggal_kembali_rencana']??date('Y-m-d',strtotime('+7 day')))?>" required></div>
<div><label>Jumlah Barang *</label><input type="number" min="1" name="jumlah" placeholder="Masukkan jumlah..." value="<?=e($ed['jumlah']??'')?>" <?=$ed?'disabled':'required'?>></div>
<div><label>Keperluan *</label><input name="keperluan" placeholder="Masukkan keperluan..." value="<?=e($ed['keperluan']??'')?>" required></div></div>
<div class="kanan"><a class="btn putih" href="peminjaman.php">Batal</a> <button name="simpan">Simpan</button></div></form></div>
<div class="panel"><div class="baris"><h3>Data Peminjaman Terakhir</h3><a href="?semua=1">Lihat Semua →</a></div>
<table><tr><th>No</th><th>No. Peminjaman</th><th>Nama Peminjam</th><th>Barang</th><th>Jumlah</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr>
<?php foreach($data as $i=>$d){?><tr><td><?=$i+1?></td><td><?=kode_pj($d['id_peminjaman'])?></td><td><?=e($d['nama_peminjam'])?></td><td><?=e($d['nama_barang'])?></td><td><?=$d['jumlah']?></td><td><?=tgl($d['tanggal_pinjam'])?></td><td><?=e($d['status'])?></td>
<td><?php if($d['status']=='Dipinjam')echo "<a class='btn kecil hijau' href='pengembalian.php?cari=".kode_pj($d['id_peminjaman'])."'>Kembalikan</a> ";?><a class="btn kecil" href="?edit=<?=$d['id_peminjaman']?>">Edit</a> <a class="btn kecil merah" href="?hapus=<?=$d['id_peminjaman']?>" onclick="return confirm('Hapus data?')">Hapus</a></td></tr><?php }?></table></div>
<?php include 'footer.php';
