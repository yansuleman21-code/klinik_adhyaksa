<?php
include 'sim_adhyaksa/koneksi.php';

$query = "ALTER TABLE antrian ADD COLUMN id_dokter INT(11) NOT NULL AFTER id_poli";

if (mysqli_query($conn, $query)) {
    echo "Success: Added id_dokter column to antrian table.\n";
} else {
    echo "Error: " . mysqli_error($conn) . "\n";
}
?>