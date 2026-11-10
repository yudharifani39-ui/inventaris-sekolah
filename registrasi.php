<?php require 'fungsi.php';
if(isset($_POST['daftar'])){
 $n=esc($_POST['nama_lengkap']);$em=esc($_POST['email']);$pw=$_POST['password'];
 if(strlen($pw)<4)flash('Password minimal 4 karakter.');
 elseif($pw!==$_POST['konfirmasi'])flash('Konfirmasi password tidak sama.');
 elseif(satu("SELECT id_user FROM user WHERE email='$em' OR username='$em'"))flash('Email sudah terdaftar.');
 else{q("INSERT INTO user(username,email,password,nama_lengkap,role) VALUES('$em','$em','".md5($pw)."','$n','Petugas')");flash('Registrasi berhasil, silakan login.');pindah('index.php');}
 pindah('registrasi.php');
}?>
<!DOCTYPE html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Daftar Akun</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="style.css"></head><body>
<div class="auth"><img class="besar" src="img/gedung.png" alt=""><div class="authbox"><h2>Daftar Akun</h2><p>Buatkan akun baru untuk melanjutkan</p>
<?php if($m=ambil_flash())echo "<div class='pesan'>".e($m)."</div>";?>
<form method="post"><label>Nama Lengkap</label><input name="nama_lengkap" required><label>Email</label><input type="email" name="email" required><label>Password</label><input type="password" name="password" required><label>Konfirmasi Password</label><input type="password" name="konfirmasi" required><button name="daftar">Daftar</button></form>
<p>Sudah punya akun? <a href="index.php">Login</a></p></div></div></body></html>
