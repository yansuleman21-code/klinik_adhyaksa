<?php
include 'sim_adhyaksa/koneksi.php';

$queries = [
    // Rename tgl_periksa to tanggal
    "ALTER TABLE rekam_medis CHANGE tgl_periksa tanggal DATE NOT NULL",
    // Add missing columns
    "ALTER TABLE rekam_medis ADD COLUMN id_pasien INT(11) NOT NULL AFTER id_rm",
    "ALTER TABLE rekam_medis ADD COLUMN id_dokter INT(11) NOT NULL AFTER id_pasien",
    "ALTER TABLE rekam_medis ADD COLUMN id_poli INT(11) NOT NULL AFTER id_dokter",
    "ALTER TABLE rekam_medis ADD COLUMN keluhan TEXT NOT NULL AFTER tanggal",
    "ALTER TABLE rekam_medis ADD COLUMN resep TEXT NOT NULL AFTER diagnosa"
];

foreach ($queries as $q) {
    echo "Executing: $q ... ";
    if (mysqli_query($conn, $q)) {
        echo "OK\n";
    } else {
        echo "FAILED: " . mysqli_error($conn) . "\n";
    }
}
echo "Rekam Medis schema updated.\n";
?>