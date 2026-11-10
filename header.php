<?php $u=$_SESSION['user'];$adm=$u['role']=='Administrator';$hal=basename($_SERVER['PHP_SELF']);
if(!function_exists('mn')){function mn($f,$t){global $hal;return "<a href='$f' class='".($hal==$f?'aktif':'')."'>$t</a>";}} ?>
<!DOCTYPE html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Inventaris Sekolah</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="style.css"></head><body>
<aside><img class="logo" src="img/gedung.png" alt=""><div class="brand">inventaris<br>sekolah</div>
<?=mn('dashboard.php','Beranda')?><?=mn('barang.php','Data Inventaris')?><?=mn('peminjaman.php','Peminjaman')?><?=mn('pengembalian.php','Pengembalian')?><?=mn('kerusakan.php','Kerusakan')?>
<?php if($adm){echo mn('laporan.php','Laporan').mn('kategori.php','Kategori').mn('ruangan.php','Ruangan').mn('user.php','Pengguna');}?>
<?=mn('profil.php','Pengaturan')?><a href="logout.php">Logout</a></aside>
<div class="utama"><div class="top"><button type="button" onclick="document.body.classList.toggle('tgl')">≡</button></div><div class="isi">
<?php if($m=ambil_flash())echo "<div class='pesan'>".e($m)."</div>"; ?>
