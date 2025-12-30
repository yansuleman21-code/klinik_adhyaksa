<?php
include 'sim_adhyaksa/koneksi.php';

$queries = [
    "ALTER TABLE pasien ADD COLUMN tanggal_lahir DATE AFTER alamat",
    "ALTER TABLE pasien ADD COLUMN no_bpjs VARCHAR(20) AFTER jenis_kelamin"
];

foreach ($queries as $q) {
    if (mysqli_query($conn, $q)) {
        echo "Success: $q\n";
    } else {
        echo "Error or already exists: " . mysqli_error($conn) . "\n";
    }
}
echo "Database schema updated.\n";
?>