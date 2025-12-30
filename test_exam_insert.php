<?php
include 'sim_adhyaksa/koneksi.php';

echo "Testing INSERT into rekam_medis...\n";

// Dummy data
$id_pasien = 1; // Assuming exists from previous test or randomness, but safer to insert one.
// Let's just try to insert with 0 if FK checks aren't strict, or use the one from previous test if not deleted?
// Previous test deleted data.
// Let's insert a temp patient again.
$q1 = mysqli_query($conn, "INSERT INTO pasien (no_rm, nik, nama_pasien, alamat, tanggal_lahir, jenis_kelamin, no_bpjs) VALUES ('TEST-RM', '123', 'Test Insert', 'Addr', '1990-01-01', 'L', '000')");
$id_pasien = mysqli_insert_id($conn);

$id_dokter = 1;
$id_poli = 1;
$tanggal = date('Y-m-d');
$keluhan = "Sakit kepala";
$diagnosa = "Migrain";
$resep = "Paracetamol";

$query = "INSERT INTO rekam_medis (id_pasien, id_dokter, id_poli, tanggal, keluhan, diagnosa, resep) 
          VALUES ('$id_pasien', '$id_dokter', '$id_poli', '$tanggal', '$keluhan', '$diagnosa', '$resep')";

if (mysqli_query($conn, $query)) {
    echo "SUCCESS: Record inserted. ID: " . mysqli_insert_id($conn) . "\n";
    // Clean up
    mysqli_query($conn, "DELETE FROM rekam_medis WHERE id_pasien = $id_pasien");
    mysqli_query($conn, "DELETE FROM pasien WHERE id_pasien = $id_pasien");
} else {
    echo "FAILURE: " . mysqli_error($conn) . "\n";
}
?>