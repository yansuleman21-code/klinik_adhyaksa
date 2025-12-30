<?php
include 'sim_adhyaksa/koneksi.php';
$tables = [];
$result = mysqli_query($conn, "SHOW TABLES");
while ($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
}

foreach ($tables as $table) {
    echo "TABLE: $table\n";
    $query = mysqli_query($conn, "DESCRIBE $table");
    while ($row = mysqli_fetch_assoc($query)) {
        echo "{$row['Field']} - {$row['Type']}\n";
    }
    echo "----------------\n";
}
?>