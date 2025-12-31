<?php
include 'sim_adhyaksa/koneksi.php';

$query = "ALTER TABLE antrian 
ADD COLUMN tensi VARCHAR(20) DEFAULT NULL,
ADD COLUMN berat_badan INT(3) DEFAULT NULL,
ADD COLUMN tinggi_badan INT(3) DEFAULT NULL,
ADD COLUMN suhu DECIMAL(4,1) DEFAULT NULL";

if (mysqli_query($conn, $query)) {
    echo "Berhasil menambahkan kolom tanda vital ke tabel antrian.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>