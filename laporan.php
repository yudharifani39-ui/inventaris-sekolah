<?php require 'fungsi.php';wajib_admin();
$harian=semua("SELECT tanggal_pinjam,COUNT(*) jumlah FROM peminjaman GROUP BY tanggal_pinjam ORDER BY tanggal_pinjam DESC");
$rekap=semua("SELECT r.nama_ruangan,COALESCE(SUM(IF(b.kondisi='Baik',b.jumlah,0)),0) baik,COALESCE(SUM(IF(b.kondisi='Rusak Ringan',b.jumlah,0)),0) ringan,COALESCE(SUM(IF(b.kondisi='Rusak Berat',b.jumlah,0)),0) berat,COALESCE(SUM(b.jumlah),0) total FROM ruangan r LEFT JOIN barang b ON b.id_ruangan=r.id_ruangan GROUP BY r.id_ruangan,r.nama_ruangan");
include 'header.php';?>
<h1>Laporan Inventaris</h1><p class="sub">Hanya dapat dilihat oleh Administrator</p>
<div class="panel"><h3>Jumlah Transaksi Peminjaman per Hari</h3><table><tr><th>Tanggal</th><th>Jumlah Transaksi</th></tr>
<?php foreach($harian as $d)echo "<tr><td>".tgl($d['tanggal_pinjam'])."</td><td>{$d['jumlah']}</td></tr>";if(!$harian)echo "<tr><td colspan=2>Belum ada data</td></tr>";?></table></div>
<div class="panel"><h3>Rekap Barang per Ruangan berdasarkan Kondisi</h3><table><tr><th>Ruangan</th><th>Baik</th><th>Rusak Ringan</th><th>Rusak Berat</th><th>Total</th></tr>
<?php foreach($rekap as $d)echo "<tr><td>".e($d['nama_ruangan'])."</td><td>{$d['baik']}</td><td>{$d['ringan']}</td><td>{$d['berat']}</td><td>{$d['total']}</td></tr>";?></table></div>
<button onclick="window.print()">Cetak</button>
<?php include 'footer.php';
