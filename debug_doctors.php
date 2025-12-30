<?php
include 'sim_adhyaksa/koneksi.php';
$query = mysqli_query($conn, "SELECT id, nama, username, role FROM users WHERE role='dokter'");
while ($row = mysqli_fetch_assoc($query)) {
    echo "ID: " . $row['id'] . " | Nama: " . $row['nama'] . " | Username: " . $row['username'] . "\n";
}
?>