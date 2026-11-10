<?php require 'fungsi.php';wajib_admin();
if(isset($_POST['simpan'])){$id=(int)$_POST['id'];$em=esc($_POST['email']);$n=esc($_POST['nama_lengkap']);$tp=esc($_POST['no_telp']);$r=$_POST['role']=='Administrator'?'Administrator':'Petugas';$pw=$_POST['password'];
 if($id){$s="UPDATE user SET username='$em',email='$em',nama_lengkap='$n',no_telp='$tp',role='$r'".($pw!==''?",password='".md5($pw)."'":'')." WHERE id_user=$id";}
 else{$s="INSERT INTO user(username,email,password,nama_lengkap,no_telp,role) VALUES('$em','$em','".md5($pw)."','$n','$tp','$r')";}
 flash(q($s)?'Data tersimpan.':'Gagal (email mungkin sudah dipakai).');pindah('user.php');}
if(isset($_GET['hapus'])){$id=(int)$_GET['hapus'];
 if($id==$_SESSION['user']['id_user'])flash('Tidak bisa menghapus akun sendiri.');else flash(q("DELETE FROM user WHERE id_user=$id")?'User dihapus.':'Tidak bisa dihapus, user sudah punya transaksi.');pindah('user.php');}
$ed=isset($_GET['edit'])?satu("SELECT * FROM user WHERE id_user=".(int)$_GET['edit']):null;
$data=semua("SELECT * FROM user ORDER BY id_user");include 'header.php';?>
<h1>Pengelolaan Pengguna</h1><p class="sub">Atur akun dan hak akses pengguna sekolah.</p>
<div class="panel"><form method="post"><input type="hidden" name="id" value="<?=e($ed['id_user']??0)?>"><div class="form2">
<div><label>Nama Lengkap *</label><input name="nama_lengkap" value="<?=e($ed['nama_lengkap']??'')?>" required></div><div><label>Email *</label><input type="email" name="email" value="<?=e($ed['email']??'')?>" required></div>
<div><label>No. Telpon</label><input name="no_telp" value="<?=e($ed['no_telp']??'')?>"></div><div><label>Peran *</label><select name="role"><?php pilihan(['Administrator','Petugas'],$ed['role']??'Petugas')?></select></div>
<div><label>Password <?=$ed?'(kosongkan jika tidak diganti)':'*'?></label><input type="password" name="password" <?=$ed?'':'required'?>></div></div>
<div class="kanan"><a class="btn putih" href="user.php">Batal</a> <button name="simpan"><?=$ed?'Ubah':'+ Tambah Pengguna'?></button></div></form></div>
<div class="panel"><table><tr><th>No</th><th>Nama Pengguna</th><th>Email</th><th>No. Telpon</th><th>Peran</th><th>Tindakan</th></tr>
<?php foreach($data as $i=>$d){?><tr><td><?=$i+1?></td><td><?=e($d['nama_lengkap'])?></td><td><?=e($d['email'])?></td><td><?=e($d['no_telp'])?></td><td><?=e($d['role'])?></td><td><a href="?edit=<?=$d['id_user']?>">Edit</a> · <a href="?hapus=<?=$d['id_user']?>" onclick="return confirm('Hapus user?')">Hapus</a></td></tr><?php }?></table></div>
<?php include 'footer.php';
