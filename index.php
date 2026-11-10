<?php require 'fungsi.php';
if(!empty($_SESSION['user']))pindah('dashboard.php');
if(isset($_POST['login'])){
 $u=esc($_POST['email']);$p=md5($_POST['password']);
 $d=satu("SELECT * FROM user WHERE (email='$u' OR username='$u') AND password='$p'");
 if($d){$_SESSION['user']=$d;pindah('dashboard.php');}
 flash('Email atau password salah.');pindah('index.php');
}?>
<!DOCTYPE html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="style.css"></head><body>
<div class="auth"><img class="besar" src="img/gedung.png" alt=""><div class="authbox"><h2>Masuk ke akun</h2><p>Selamat datang kembali</p>
<?php if($m=ambil_flash())echo "<div class='pesan'>".e($m)."</div>";?>
<form method="post"><label>Email</label><input name="email" required><label>Password</label><input type="password" name="password" required><button name="login">login</button></form>
<p>Belum punya akun? <a href="registrasi.php">Daftar akun</a></p></div></div></body></html>
