DROP DATABASE IF EXISTS db_inventaris;
CREATE DATABASE db_inventaris;
USE db_inventaris;
CREATE TABLE user(id_user INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(255) NOT NULL UNIQUE, email VARCHAR(255) NOT NULL UNIQUE, password VARCHAR(32) NOT NULL, nama_lengkap VARCHAR(255) NOT NULL, no_telp VARCHAR(20), role ENUM('Administrator','Petugas') NOT NULL DEFAULT 'Petugas');
CREATE TABLE kategori(id_kategori INT AUTO_INCREMENT PRIMARY KEY, nama_kategori VARCHAR(100) NOT NULL, keterangan TEXT);
CREATE TABLE ruangan(id_ruangan INT AUTO_INCREMENT PRIMARY KEY, kode_ruangan VARCHAR(20) NOT NULL UNIQUE, nama_ruangan VARCHAR(100) NOT NULL, penanggung_jawab VARCHAR(255));
CREATE TABLE barang(id_barang INT AUTO_INCREMENT PRIMARY KEY, id_kategori INT NOT NULL, id_ruangan INT NOT NULL, kode_barang VARCHAR(30) NOT NULL UNIQUE, nama_barang VARCHAR(255) NOT NULL, merk VARCHAR(100), tahun_perolehan INT, jumlah INT NOT NULL DEFAULT 1, kondisi ENUM('Baik','Rusak Ringan','Rusak Berat') NOT NULL DEFAULT 'Baik', status ENUM('Tersedia','Dipinjam') NOT NULL DEFAULT 'Tersedia',
 FOREIGN KEY(id_kategori) REFERENCES kategori(id_kategori), FOREIGN KEY(id_ruangan) REFERENCES ruangan(id_ruangan));
CREATE TABLE peminjaman(id_peminjaman INT AUTO_INCREMENT PRIMARY KEY, id_barang INT NOT NULL, id_user INT NOT NULL, nama_peminjam VARCHAR(255) NOT NULL, jumlah INT NOT NULL DEFAULT 1, keperluan TEXT, tanggal_pinjam DATE NOT NULL, tanggal_kembali_rencana DATE NOT NULL, status ENUM('Dipinjam','Kembali') NOT NULL DEFAULT 'Dipinjam',
 FOREIGN KEY(id_barang) REFERENCES barang(id_barang), FOREIGN KEY(id_user) REFERENCES user(id_user));
CREATE TABLE pengembalian(id_pengembalian INT AUTO_INCREMENT PRIMARY KEY, id_peminjaman INT NOT NULL UNIQUE, id_user INT NOT NULL, tanggal_kembali DATE NOT NULL, kondisi_kembali VARCHAR(30) NOT NULL, keterangan TEXT,
 FOREIGN KEY(id_peminjaman) REFERENCES peminjaman(id_peminjaman) ON DELETE CASCADE, FOREIGN KEY(id_user) REFERENCES user(id_user));
CREATE TABLE kerusakan(id_kerusakan INT AUTO_INCREMENT PRIMARY KEY, id_barang INT NOT NULL, id_user INT NOT NULL, tanggal_lapor DATE NOT NULL, tingkat ENUM('Rusak Ringan','Rusak Berat') NOT NULL, deskripsi TEXT, tindakan TEXT, status ENUM('Dilaporkan','Diperbaiki') NOT NULL DEFAULT 'Dilaporkan',
 FOREIGN KEY(id_barang) REFERENCES barang(id_barang), FOREIGN KEY(id_user) REFERENCES user(id_user));
CREATE TABLE aktivitas(id INT AUTO_INCREMENT PRIMARY KEY, keterangan VARCHAR(255) NOT NULL, waktu DATETIME DEFAULT CURRENT_TIMESTAMP);
INSERT INTO user(username,email,password,nama_lengkap,no_telp,role) VALUES
('adminsekolah@gmail.com','adminsekolah@gmail.com',MD5('admin123'),'Mariokusuma Suhai','','Administrator'),
('petugassekolah@gmail.com','petugassekolah@gmail.com',MD5('petugas123'),'Nur Azizah','0813 9876 5432','Petugas');
INSERT INTO kategori(nama_kategori,keterangan) VALUES('Elektronik','Komputer, proyektor, dll'),('Mebel','Meja, kursi, lemari'),('Olahraga','Peralatan olahraga');
INSERT INTO ruangan(kode_ruangan,nama_ruangan,penanggung_jawab) VALUES('R-LAB1','Laboratorium Komputer 1','Pak Budi'),('R-KLS1','Kelas X RPL 1','Bu Sari'),('R-GOR','Gudang Olahraga','Pak Andi');
INSERT INTO barang(id_kategori,id_ruangan,kode_barang,nama_barang,merk,tahun_perolehan,jumlah,kondisi) VALUES(1,1,'BRG-001','Proyektor','Epson',2022,3,'Baik'),(1,1,'BRG-002','PC Desktop','Asus',2021,1,'Rusak Ringan'),(2,2,'BRG-003','Meja Siswa','Olympic',2020,30,'Baik'),(3,3,'BRG-004','Bola Basket','Molten',2023,5,'Baik');
INSERT INTO aktivitas(keterangan) VALUES('Data inventaris awal dibuat');
