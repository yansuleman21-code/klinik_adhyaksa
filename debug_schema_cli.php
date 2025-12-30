<?php
include 'sim_adhyaksa/koneksi.php';
$tables = ['antrian'];
foreach ($tables as $table) {
    echo "TABLE: $table\n";
    $query = mysqli_query($conn, "DESCRIBE $table");
    if (!$query) {
        echo "Error: " . mysqli_error($conn) . "\n";
        continue;
    }
    while ($row = mysqli_fetch_assoc($query)) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
    echo "----------------\n";
}
?>