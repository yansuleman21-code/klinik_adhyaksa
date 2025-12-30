<?php
include 'sim_adhyaksa/koneksi.php';

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$tables_to_drop = ['poli', 'pasien', 'antrian', 'obat', 'rekam_medis', 'users'];
foreach ($tables_to_drop as $table) {
  mysqli_query($conn, "DROP TABLE IF EXISTS `$table`");
}

$queries = [
  // Table Poli
  "CREATE TABLE `poli` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `nama_poli` varchar(50) NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

  // Table Pasien
  "CREATE TABLE `pasien` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `no_rm` varchar(20) NOT NULL,
        `nik` varchar(20) NOT NULL,
        `nama` varchar(100) NOT NULL,
        `alamat` text NOT NULL,
        `tanggal_lahir` date NOT NULL,
        `jenis_kelamin` enum('L','P') NOT NULL,
        `no_bpjs` varchar(20) DEFAULT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

  // Table Antrian
  "CREATE TABLE `antrian` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `id_pasien` int(11) NOT NULL,
        `id_poli` int(11) NOT NULL,
        `tanggal` date NOT NULL,
        `no_antrian` int(11) NOT NULL,
        `status` enum('Menunggu','Diperiksa','Selesai') NOT NULL DEFAULT 'Menunggu',
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

  // Table Obat
  "CREATE TABLE `obat` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `nama_obat` varchar(100) NOT NULL,
        `jenis` varchar(50) NOT NULL,
        `stok` int(11) NOT NULL,
        `harga` decimal(10,2) NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

  // Table Rekam Medis
  "CREATE TABLE `rekam_medis` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `id_pasien` int(11) NOT NULL,
        `id_dokter` int(11) NOT NULL,
        `id_poli` int(11) NOT NULL,
        `tanggal` date NOT NULL,
        `keluhan` text NOT NULL,
        `diagnosa` text NOT NULL,
        `resep` text NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

  // Table Users
  "CREATE TABLE `users` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `nama` varchar(255) NOT NULL,
      `username` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL,
      `role` varchar(20) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

  // Seed Poli Data
  "INSERT INTO `poli` (`nama_poli`) VALUES ('Poli Umum'), ('Poli Gigi'), ('Poli KIA/KB');"
];

foreach ($queries as $query) {
  if (mysqli_query($conn, $query)) {
    echo "Query executed successfully.<br>";
  } else {
    echo "Error executing query: " . mysqli_error($conn) . "<br>";
  }
}

// Reset and Upgrade Passwords
$default_password = 'admin123';
$hash = password_hash($default_password, PASSWORD_DEFAULT);

$users = [
  ['Administrator', 'admin', 'admin'],
  ['Dr. Budi', 'dokter', 'dokter'],
  ['Apoteker Sari', 'apotek', 'apoteker'],
  ['Resepsionis Ani', 'pendaftaran', 'resepsionis']
];

$stmt = mysqli_prepare($conn, "INSERT INTO users (nama, username, password, role) VALUES (?, ?, ?, ?)");

if ($stmt === false) {
  die("Error preparing statement: " . mysqli_error($conn));
}

foreach ($users as $user) {
  mysqli_stmt_bind_param($stmt, "ssss", $user[0], $user[1], $hash, $user[2]);
  if (!mysqli_stmt_execute($stmt)) {
    echo "Error inserting user " . $user[1] . ": " . mysqli_stmt_error($stmt) . "<br>";
  }
}

echo "Database fully reset and seeded.<br>";
?>