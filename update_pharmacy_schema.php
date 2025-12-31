<?php
include 'sim_adhyaksa/koneksi.php';

// 1. Create resep_obat table
$query1 = "CREATE TABLE IF NOT EXISTS resep_obat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_rm INT NOT NULL,
    id_obat INT NOT NULL,
    jumlah INT NOT NULL,
    FOREIGN KEY (id_rm) REFERENCES rekam_medis(id_rm),
    FOREIGN KEY (id_obat) REFERENCES obat(id_obat)
)";

if (mysqli_query($conn, $query1)) {
    echo "Tabel resep_obat berhasil dibuat.<br>";
} else {
    echo "Error create table: " . mysqli_error($conn) . "<br>";
}

// 2. Add status column to rekam_medis
$check = mysqli_query($conn, "SHOW COLUMNS FROM rekam_medis LIKE 'status_obat'");
if (mysqli_num_rows($check) == 0) {
    $query2 = "ALTER TABLE rekam_medis ADD COLUMN status_obat VARCHAR(20) DEFAULT 'Menunggu'";
    if (mysqli_query($conn, $query2)) {
        echo "Kolom status_obat berhasil ditambahkan.<br>";
    } else {
        echo "Error alter table: " . mysqli_error($conn) . "<br>";
    }
} else {
    echo "Kolom status_obat sudah ada.<br>";
}
?>