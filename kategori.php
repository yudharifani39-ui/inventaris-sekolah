<?php require 'fungsi.php';wajib_admin();
if(isset($_POST['simpan'])){$id=(int)$_POST['id'];$n=esc($_POST['nama_kategori']);$k=esc($_POST['keterangan']);
 $ok=$id?q("UPDATE kategori SET nama_kategori='$n',keterangan='$k' WHERE id_kategori=$id"):q("INSERT INTO kategori(nama_kategori,keterangan) VALUES('$n','$k')");
 flash($ok?'Data tersimpan.':'Gagal: '.galat());pindah('kategori.php');}
if(isset($_GET['hapus'])){flash(q("DELETE FROM kategori WHERE id_kategori=".(int)$_GET['hapus'])?'Data dihapus.':'Tidak bisa dihapus, kategori masih dipakai barang.');pindah('kategori.php');}
$ed=isset($_GET['edit'])?satu("SELECT * FROM kategori WHERE id_kategori=".(int)$_GET['edit']):null;
$data=semua("SELECT * FROM kategori ORDER BY id_kategori");include 'header.php';?>
<h1>Pendataan Kategori Barang</h1>
<div class="panel"><form method="post"><input type="hidden" name="id" value="<?=e($ed['id_kategori']??0)?>">
<label>Nama Kategori *</label><input name="nama_kategori" value="<?=e($ed['nama_kategori']??'')?>" required><label>Keterangan</label><textarea name="keterangan"><?=e($ed['keterangan']??'')?></textarea>
<div class="kanan"><a class="btn putih" href="kategori.php">Batal</a> <button name="simpan"><?=$ed?'Ubah':'Simpan'?></button></div></form></div>
<div class="panel"><table><tr><th>No</th><th>Nama</th><th>Keterangan</th><th>Aksi</th></tr>
<?php foreach($data as $i=>$d){?><tr><td><?=$i+1?></td><td><?=e($d['nama_kategori'])?></td><td><?=e($d['keterangan'])?></td><td><a class="btn kecil" href="?edit=<?=$d['id_kategori']?>">Edit</a> <a class="btn kecil merah" href="?hapus=<?=$d['id_kategori']?>" onclick="return confirm('Hapus data?')">Hapus</a></td></tr><?php }?></table></div>
<?php include 'footer.php';
