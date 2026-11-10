<?php require 'fungsi.php';wajib_admin();
if(isset($_POST['simpan'])){$id=(int)$_POST['id'];$kd=esc($_POST['kode_ruangan']);$n=esc($_POST['nama_ruangan']);$p=esc($_POST['penanggung_jawab']);
 $ok=$id?q("UPDATE ruangan SET kode_ruangan='$kd',nama_ruangan='$n',penanggung_jawab='$p' WHERE id_ruangan=$id"):q("INSERT INTO ruangan(kode_ruangan,nama_ruangan,penanggung_jawab) VALUES('$kd','$n','$p')");
 flash($ok?'Data tersimpan.':'Gagal (kode ruangan mungkin sudah ada).');pindah('ruangan.php');}
if(isset($_GET['hapus'])){flash(q("DELETE FROM ruangan WHERE id_ruangan=".(int)$_GET['hapus'])?'Data dihapus.':'Tidak bisa dihapus, ruangan masih berisi barang.');pindah('ruangan.php');}
$ed=isset($_GET['edit'])?satu("SELECT * FROM ruangan WHERE id_ruangan=".(int)$_GET['edit']):null;
$data=semua("SELECT * FROM ruangan ORDER BY id_ruangan");include 'header.php';?>
<h1>Pendataan Ruangan</h1>
<div class="panel"><form method="post"><input type="hidden" name="id" value="<?=e($ed['id_ruangan']??0)?>"><div class="form2">
<div><label>Kode Ruangan *</label><input name="kode_ruangan" maxlength="20" value="<?=e($ed['kode_ruangan']??'')?>" required></div><div><label>Nama Ruangan *</label><input name="nama_ruangan" value="<?=e($ed['nama_ruangan']??'')?>" required></div>
<div><label>Penanggung Jawab</label><input name="penanggung_jawab" value="<?=e($ed['penanggung_jawab']??'')?>"></div></div>
<div class="kanan"><a class="btn putih" href="ruangan.php">Batal</a> <button name="simpan"><?=$ed?'Ubah':'Simpan'?></button></div></form></div>
<div class="panel"><table><tr><th>No</th><th>Kode</th><th>Nama</th><th>Penanggung Jawab</th><th>Aksi</th></tr>
<?php foreach($data as $i=>$d){?><tr><td><?=$i+1?></td><td><?=e($d['kode_ruangan'])?></td><td><?=e($d['nama_ruangan'])?></td><td><?=e($d['penanggung_jawab'])?></td><td><a class="btn kecil" href="?edit=<?=$d['id_ruangan']?>">Edit</a> <a class="btn kecil merah" href="?hapus=<?=$d['id_ruangan']?>" onclick="return confirm('Hapus data?')">Hapus</a></td></tr><?php }?></table></div>
<?php include 'footer.php';
