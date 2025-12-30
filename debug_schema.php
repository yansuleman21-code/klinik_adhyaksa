<?php
include 'sim_adhyaksa/koneksi.php';

$tables = ['pasien', 'antrian', 'poli', 'obat', 'rekam_medis', 'users'];

foreach ($tables as $table) {
    echo "<h3>Table: $table</h3>";
    $query = mysqli_query($conn, "DESCRIBE $table");
    if (!$query) {
        echo "Error: " . mysqli_error($conn) . "<br>";
        continue;
    }

    echo "<table border='1'><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    while ($row = mysqli_fetch_assoc($query)) {
        echo "<tr>";
        foreach ($row as $val) {
            echo "<td>$val</td>";
        }
        echo "</tr>";
    }
    echo "</table><br>";
}
?>