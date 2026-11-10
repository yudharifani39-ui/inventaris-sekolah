<?php require 'fungsi.php';wajib_login();$id=(int)$_SESSION['user']['id_user'];
if(isset($_POST['simpan'])){$n=esc($_POST['nama_lengkap']);$em=esc($_POST['email']);$tp=esc($_POST['no_telp']);$pw=$_POST['password'];
 if(satu("SELECT id_user FROM user WHERE (email='$em' OR username='$em') AND id_user<>$id"))flash('Email sudah dipakai akun lain.');
 else{q("UPDATE user SET nama_lengkap='$n',email='$em',username='$em',no_telp='$tp'".($pw!==''?",password='".md5($pw)."'":'')." WHERE id_user=$id");$_SESSION['user']=satu("SELECT * FROM user WHERE id_user=$id");flash('Profil disimpan.');}
 pindah('profil.php');}
$d=satu("SELECT * FROM user WHERE id_user=$id");include 'header.php';?>
<div class="profil"><img src="img/<?=$d['role']=='Administrator'?'admin':'petugas'?>.png" alt=""><h1>Profil Petugas</h1></div>
<div class="panel" style="max-width:760px;margin:20px auto"><form method="post">
<label>Nama Lengkap</label><input name="nama_lengkap" value="<?=e($d['nama_lengkap'])?>" required>
<label>Email</label><input type="email" name="email" value="<?=e($d['email'])?>" required>
<label>No.Telpon</label><input name="no_telp" value="<?=e($d['no_telp'])?>">
<label>Password Baru (kosongkan jika tidak diganti)</label><input type="password" name="password">
<div class="kanan"><button class="biru" name="simpan" style="background:#2563eb">💾 Simpan Perubahan</button></div></form></div>
<?php include 'footer.php';
