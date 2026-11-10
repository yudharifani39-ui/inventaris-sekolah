<?php require 'fungsi.php';wajib_login();$uid=(int)$_SESSION['user']['id_user'];$T=['Rusak Ringan','Rusak Berat'];$S=['Dilaporkan','Diperbaiki'];
if(isset($_POST['simpan'])){$id=(int)$_POST['id'];$ds=esc($_POST['deskripsi']);$tn=esc($_POST['tindakan']);$st=in_array($_POST['status'],$S)?$_POST['status']:'Dilaporkan';
 if($id){$k=satu("SELECT * FROM kerusakan WHERE id_kerusakan=$id");q("UPDATE kerusakan SET deskripsi='$ds',tindakan='$tn',status='$st' WHERE id_kerusakan=$id");
  if($k)q("UPDATE barang SET kondisi='".($st=='Diperbaiki'?'Baik':$k['tingkat'])."' WHERE id_barang={$k['id_barang']}");flash('Data diubah.');}
 else{$b=(int)$_POST['id_barang'];$tg=esc($_POST['tanggal_lapor']);$tk=in_array($_POST['tingkat'],$T)?$_POST['tingkat']:'Rusak Ringan';
  q("INSERT INTO kerusakan(id_barang,id_user,tanggal_lapor,tingkat,deskripsi,tindakan,status) VALUES($b,$uid,'$tg','$tk','$ds','$tn','$st')");
  q("UPDATE barang SET kondisi='".($st=='Diperbaiki'?'Baik':$tk)."' WHERE id_barang=$b");catat('Kerusakan barang dicatat (ID barang '.$b.')');flash('Kerusakan dicatat, kondisi barang diperbarui otomatis.');}
 pindah('kerusakan.php');}
if(isset($_GET['hapus'])){q("DELETE FROM kerusakan WHERE id_kerusakan=".(int)$_GET['hapus']);flash('Data dihapus.');pindah('kerusakan.php');}
$ed=isset($_GET['edit'])?satu("SELECT * FROM kerusakan WHERE id_kerusakan=".(int)$_GET['edit']):null;$tampil=$ed||isset($_GET['tambah']);
$brg=semua("SELECT id_barang,kode_barang,nama_barang FROM barang");
$data=semua("SELECT k.*,b.kode_barang,b.nama_barang FROM kerusakan k JOIN barang b ON b.id_barang=k.id_barang ORDER BY k.id_kerusakan DESC");include 'header.php';?>
<h1>Kerusakan & Perawatan</h1>
<div class="kanan baris" style="justify-content:flex-end"><button type="button" onclick="document.getElementById('f').style.display='block'">+ Catat Kerusakan</button></div>
<div class="panel" id="f" style="<?=$tampil?'':'display:none'?>"><form method="post"><input type="hidden" name="id" value="<?=e($ed['id_kerusakan']??0)?>"><div class="form2">
<?php if(!$ed){?><div><label>Barang *</label><select name="id_barang"><?php foreach($brg as $x)echo "<option value='{$x['id_barang']}'>".e($x['kode_barang'].' - '.$x['nama_barang'])."</option>";?></select></div>
<div><label>Tanggal Lapor *</label><input type="date" name="tanggal_lapor" value="<?=date('Y-m-d')?>" required></div>
<div><label>Tingkat Kerusakan *</label><select name="tingkat"><?php pilihan($T,'Rusak Ringan')?></select></div><?php }?>
<div><label>Status *</label><select name="status"><?php pilihan($S,$ed['status']??'Dilaporkan')?></select></div>
<div><label>Deskripsi *</label><textarea name="deskripsi" required><?=e($ed['deskripsi']??'')?></textarea></div><div><label>Tindakan</label><textarea name="tindakan"><?=e($ed['tindakan']??'')?></textarea></div></div>
<div class="kanan"><a class="btn putih" href="kerusakan.php">Batal</a> <button name="simpan">Simpan</button></div></form></div>
<div class="panel"><table><tr><th>Tanggal</th><th>Barang</th><th>Tingkat</th><th>Deskripsi</th><th>Tindakan</th><th>Status</th><th>Aksi</th></tr>
<?php foreach($data as $d){?><tr><td><?=tgl($d['tanggal_lapor'])?></td><td><?=e($d['kode_barang'].' - '.$d['nama_barang'])?></td><td><?=e($d['tingkat'])?></td><td><?=e($d['deskripsi'])?></td><td><?=e($d['tindakan'])?></td><td><?=e($d['status'])?></td>
<td><a class="btn kecil" href="?edit=<?=$d['id_kerusakan']?>">Edit</a> <a class="btn kecil merah" href="?hapus=<?=$d['id_kerusakan']?>" onclick="return confirm('Hapus data?')">Hapus</a></td></tr><?php }?></table></div>
<?php include 'footer.php';
