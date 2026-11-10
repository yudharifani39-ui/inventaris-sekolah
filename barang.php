<?php require 'fungsi.php';wajib_login();$K=['Baik','Rusak Ringan','Rusak Berat'];
if(isset($_POST['simpan'])){$id=(int)$_POST['id'];$kat=(int)$_POST['id_kategori'];$rg=(int)$_POST['id_ruangan'];$kd=esc($_POST['kode_barang']);$n=esc($_POST['nama_barang']);$m=esc($_POST['merk']);$th=(int)$_POST['tahun_perolehan'];$jm=max(1,(int)$_POST['jumlah']);$kon=in_array($_POST['kondisi'],$K)?$_POST['kondisi']:'Baik';
 if(satu("SELECT id_barang FROM barang WHERE kode_barang='$kd' AND id_barang<>$id"))flash('Kode barang sudah dipakai, tidak boleh ganda.');
 else{
  if($id){$ok=q("UPDATE barang SET id_kategori=$kat,id_ruangan=$rg,kode_barang='$kd',nama_barang='$n',merk='$m',tahun_perolehan=$th,jumlah=$jm,kondisi='$kon' WHERE id_barang=$id");sinkron_status($id);catat('Data inventaris diperbarui: '.$_POST['nama_barang']);}
  else{$ok=q("INSERT INTO barang(id_kategori,id_ruangan,kode_barang,nama_barang,merk,tahun_perolehan,jumlah,kondisi) VALUES($kat,$rg,'$kd','$n','$m',$th,$jm,'$kon')");catat('Data inventaris baru ditambahkan: '.$_POST['nama_barang']);}
  flash($ok?'Data tersimpan.':'Gagal: '.galat());}
 pindah('barang.php');}
if(isset($_GET['hapus'])){$id=(int)$_GET['hapus'];$b=satu("SELECT nama_barang FROM barang WHERE id_barang=$id");
 if(q("DELETE FROM barang WHERE id_barang=$id")){catat('Data inventaris dihapus: '.($b['nama_barang']??''));flash('Data dihapus.');}else flash('Tidak bisa dihapus, barang punya riwayat peminjaman/kerusakan.');pindah('barang.php');}
$ed=isset($_GET['edit'])?satu("SELECT * FROM barang WHERE id_barang=".(int)$_GET['edit']):null;$tampil=$ed||isset($_GET['tambah']);
$cari=esc($_GET['cari']??'');
$data=semua("SELECT b.*,k.nama_kategori,r.nama_ruangan FROM barang b JOIN kategori k ON k.id_kategori=b.id_kategori JOIN ruangan r ON r.id_ruangan=b.id_ruangan WHERE b.nama_barang LIKE '%$cari%' OR b.kode_barang LIKE '%$cari%' ORDER BY b.id_barang");
$akt=semua("SELECT * FROM aktivitas ORDER BY id DESC LIMIT ".(isset($_GET['semua'])?100:3));
$kats=semua("SELECT * FROM kategori");$rgs=semua("SELECT * FROM ruangan");include 'header.php';?>
<div class="judul"><div><h1>Data Inventaris</h1><p class="sub">Daftar barang inventaris sekolah</p></div><img src="img/catatan.png" alt=""></div>
<?php kartu_stat();?>
<div class="baris"><form method="get" style="display:flex;gap:6px;flex:1"><input name="cari" placeholder="Cari nama/kode barang" value="<?=e($cari)?>" style="margin:0"><button>Cari</button></form>
<button type="button" onclick="document.getElementById('f').style.display='block'">+ Tambah Barang</button></div>
<div class="panel" id="f" style="<?=$tampil?'':'display:none'?>"><form method="post"><input type="hidden" name="id" value="<?=e($ed['id_barang']??0)?>"><div class="form2">
<div><label>Kode Barang *</label><input name="kode_barang" maxlength="30" value="<?=e($ed['kode_barang']??'')?>" required></div>
<div><label>Nama Barang *</label><input name="nama_barang" value="<?=e($ed['nama_barang']??'')?>" required></div>
<div><label>Kategori *</label><select name="id_kategori"><?php foreach($kats as $x)echo "<option value='{$x['id_kategori']}' ".(($ed['id_kategori']??0)==$x['id_kategori']?'selected':'').">".e($x['nama_kategori'])."</option>";?></select></div>
<div><label>Ruangan *</label><select name="id_ruangan"><?php foreach($rgs as $x)echo "<option value='{$x['id_ruangan']}' ".(($ed['id_ruangan']??0)==$x['id_ruangan']?'selected':'').">".e($x['nama_ruangan'])."</option>";?></select></div>
<div><label>Merk</label><input name="merk" value="<?=e($ed['merk']??'')?>"></div>
<div><label>Tahun Perolehan</label><input type="number" name="tahun_perolehan" value="<?=e($ed['tahun_perolehan']??date('Y'))?>"></div>
<div><label>Jumlah *</label><input type="number" min="1" name="jumlah" value="<?=e($ed['jumlah']??1)?>" required></div>
<div><label>Kondisi *</label><select name="kondisi"><?php pilihan($K,$ed['kondisi']??'Baik')?></select></div></div>
<div class="kanan"><a class="btn putih" href="barang.php">Batal</a> <button name="simpan">Simpan</button></div></form></div>
<div class="panel"><table><tr><th>Kode</th><th>Nama</th><th>Kategori</th><th>Ruangan</th><th>Merk</th><th>Tahun</th><th>Jumlah</th><th>Kondisi</th><th>Status</th><th>Aksi</th></tr>
<?php foreach($data as $d){?><tr><td><?=e($d['kode_barang'])?></td><td><?=e($d['nama_barang'])?></td><td><?=e($d['nama_kategori'])?></td><td><?=e($d['nama_ruangan'])?></td><td><?=e($d['merk'])?></td><td><?=e($d['tahun_perolehan'])?></td><td><?=$d['jumlah']?></td><td><?=e($d['kondisi'])?></td><td><?=e($d['status'])?></td>
<td><a class="btn kecil" href="?edit=<?=$d['id_barang']?>">Edit</a> <a class="btn kecil merah" href="?hapus=<?=$d['id_barang']?>" onclick="return confirm('Hapus barang?')">Hapus</a></td></tr><?php }?></table></div>
<div class="panel"><div class="baris"><h3>Aktivitas Terbaru</h3><a href="?semua=1">Lihat Semua</a></div><div class="aktv"><?php foreach($akt as $a)echo "<div><span>".e($a['keterangan'])."</span><span>".tgl($a['waktu']).". ".date('H.i',strtotime($a['waktu']))."</span></div>";?></div></div>
<?php include 'footer.php';
