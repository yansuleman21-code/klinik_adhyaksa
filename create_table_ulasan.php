<?php
include __DIR__ . '/sim_adhyaksa/koneksi.php';

$sql = "CREATE TABLE IF NOT EXISTS `ulasan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `rating` int(1) NOT NULL,
  `komentar` text NOT NULL,
  `tanggal` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// Use $conn instead of $koneksi
if (mysqli_query($conn, $sql)) {
    echo "Tabel ulasan berhasil dibuat.";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}
?>