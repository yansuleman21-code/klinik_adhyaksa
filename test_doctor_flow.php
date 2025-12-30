<?php
include 'sim_adhyaksa/koneksi.php';

echo "1. Adding Test Patient...\n";
$rm = "TEST-" . rand(100, 999);
$nama = "Test Patient " . rand(1, 100);
$date = date('Y-m-d');
// Insert patient
$q1 = mysqli_query($conn, "INSERT INTO pasien (no_rm, nik, nama_pasien, alamat, tanggal_lahir, jenis_kelamin, no_bpjs) VALUES ('$rm', '123456789', '$nama', 'Test Address', '1990-01-01', 'L', '000111222')");
$id_pasien = mysqli_insert_id($conn);

if ($q1) {
    echo "Patient Added: ID $id_pasien ($nama)\n";
} else {
    die("Failed to add patient: " . mysqli_error($conn));
}

echo "2. Adding to Queue (Poli Umum)...\n";
$id_poli = 1; // Assuming poli umum exists
$q2 = mysqli_query($conn, "INSERT INTO antrian (id_pasien, id_poli, tanggal, no_antrian, status) VALUES ('$id_pasien', '$id_poli', '$date', 1, 'Menunggu')");
$id_antrian = mysqli_insert_id($conn);

if ($q2) {
    echo "Queue Added: ID $id_antrian\n";
} else {
    die("Failed to queue: " . mysqli_error($conn));
}

echo "3. Simulating Doctor View Query...\n";
$query = mysqli_query($conn, "
    SELECT antrian.*, pasien.nama_pasien AS nama, pasien.no_rm, poli.nama_poli 
    FROM antrian 
    JOIN pasien ON antrian.id_pasien = pasien.id_pasien 
    JOIN poli ON antrian.id_poli = poli.id 
    WHERE antrian.id = '$id_antrian'
");

if ($row = mysqli_fetch_assoc($query)) {
    echo "SUCCESS! Doctor sees: " . $row['nama'] . " (" . $row['status'] . ") in " . $row['nama_poli'] . "\n";

    // Clean up
    mysqli_query($conn, "DELETE FROM antrian WHERE id = $id_antrian");
    mysqli_query($conn, "DELETE FROM pasien WHERE id_pasien = $id_pasien");
    echo "Test data cleaned up.\n";
} else {
    echo "FAILURE! Query returned no results.\n";
}
?>