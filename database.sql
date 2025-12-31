-- Database: `db_klinik_adhyaksa`

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- New Tables

CREATE TABLE IF NOT EXISTS `poli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_poli` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pasien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_rm` varchar(20) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `no_bpjs` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `antrian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pasien` int(11) NOT NULL,
  `id_poli` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `no_antrian` int(11) NOT NULL,
  `status` enum('Menunggu','Diperiksa','Selesai') NOT NULL DEFAULT 'Menunggu',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `obat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_obat` varchar(100) NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `stok` int(11) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `rekam_medis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pasien` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `id_poli` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `keluhan` text NOT NULL,
  `diagnosa` text NOT NULL,
  `resep` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `ulasan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `rating` int(1) NOT NULL,
  `komentar` text NOT NULL,
  `tanggal` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TRUNCATE & RE-INSERT USERS with BCRYPT HASH (Default: admin123)
TRUNCATE TABLE `users`;
INSERT INTO `users` (`nama`, `username`, `password`, `role`) VALUES
('Administrator', 'admin', '$2y$10$8.uQd4.M4.v./.s.t.u.v.w.x.y.z.A.B.C.D.E.F.G.H.I.J', 'admin'),
('Dr. Budi', 'dokter', '$2y$10$8.uQd4.M4.v./.s.t.u.v.w.x.y.z.A.B.C.D.E.F.G.H.I.J', 'dokter'),
('Apoteker Sari', 'apotek', '$2y$10$8.uQd4.M4.v./.s.t.u.v.w.x.y.z.A.B.C.D.E.F.G.H.I.J', 'apoteker'),
('Resepsionis Ani', 'pendaftaran', '$2y$10$8.uQd4.M4.v./.s.t.u.v.w.x.y.z.A.B.C.D.E.F.G.H.I.J', 'resepsionis');
-- Note: The hash above is a placeholder. Real BCRYPT hash for 'admin123' will be generated in the installation script.
