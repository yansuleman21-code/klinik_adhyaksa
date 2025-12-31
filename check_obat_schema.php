<?php
include 'sim_adhyaksa/koneksi.php';

$query = "SHOW COLUMNS FROM obat";
$result = mysqli_query($conn, $query);

echo "<h3>Columns in 'obat' table:</h3>";
echo "<ul>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<li>" . $row['Field'] . " (" . $row['Type'] . ")</li>";
}
echo "</ul>";
?>