<?php
session_start();
mysqli_report(MYSQLI_REPORT_OFF);
$koneksi = mysqli_connect('localhost','inventaris','inventaris_tmp_2026','db_inventaris'); // konfigurasi server sementara
if(!$koneksi) die('Koneksi database gagal: '.mysqli_connect_error());
function e($s){return htmlspecialchars((string)$s,ENT_QUOTES);}
function esc($s){global $koneksi;return mysqli_real_escape_string($koneksi,trim((string)$s));}
function q($sql){global $koneksi;return mysqli_query($koneksi,$sql);}
function galat(){global $koneksi;return mysqli_error($koneksi);}
function semua($sql){$r=q($sql);$o=[];if($r)while($x=mysqli_fetch_assoc($r))$o[]=$x;return $o;}
function satu($sql){$r=q($sql);return $r?mysqli_fetch_assoc($r):null;}
function flash($t){$_SESSION['flash']=$t;}
function ambil_flash(){$t=$_SESSION['flash']??null;unset($_SESSION['flash']);return $t;}
function pindah($h){header("Location: $h");exit;}
function wajib_login(){if(empty($_SESSION['user']))pindah('index.php');}
function wajib_admin(){wajib_login();if($_SESSION['user']['role']!='Administrator'){flash('Halaman hanya untuk Administrator.');pindah('dashboard.php');}}
function pilihan($arr,$sel){foreach($arr as $a)echo "<option ".($a==$sel?'selected':'').">".e($a)."</option>";}
function tgl($d){$b=['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];$t=strtotime($d);return date('d',$t).' '.$b[(int)date('n',$t)].' '.date('Y',$t);}
function kode_pj($id){return 'PJ-'.str_pad($id,3,'0',STR_PAD_LEFT);}
function catat($t){q("INSERT INTO aktivitas(keterangan) VALUES('".esc($t)."')");}
function sisa($id){$id=(int)$id;$b=satu("SELECT jumlah FROM barang WHERE id_barang=$id");if(!$b)return 0;$d=satu("SELECT COALESCE(SUM(jumlah),0) n FROM peminjaman WHERE id_barang=$id AND status='Dipinjam'");return $b['jumlah']-$d['n'];}
function sinkron_status($id){q("UPDATE barang SET status='".(sisa($id)<=0?'Dipinjam':'Tersedia')."' WHERE id_barang=".(int)$id);}
function statistik(){return satu("SELECT COALESCE(SUM(jumlah),0) total,COALESCE(SUM(IF(kondisi='Baik',jumlah,0)),0) baik,COALESCE(SUM(IF(kondisi='Rusak Ringan',jumlah,0)),0) perlu,COALESCE(SUM(IF(kondisi='Rusak Berat',jumlah,0)),0) rusak FROM barang");}
function kartu_stat(){$s=statistik();
 echo "<div class='stat'><div class='kartu'><div class='ik'>📋</div>Total Inventaris<div class='no'>{$s['total']}</div></div>
 <div class='kartu k-baik'><div class='ik'>✅</div>Baik<div class='no'>{$s['baik']}</div></div>
 <div class='kartu k-perlu'><div class='ik'>⚠️</div>Perlu Perbaikan<div class='no'>{$s['perlu']}</div></div>
 <div class='kartu k-rusak'><div class='ik'>❌</div>Rusak<div class='no'>{$s['rusak']}</div></div></div>";}
