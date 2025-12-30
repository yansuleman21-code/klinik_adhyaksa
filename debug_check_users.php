<?php
include 'sim_adhyaksa/koneksi.php';

echo "<h2>Debug User Data</h2>";
$query = mysqli_query($conn, "SELECT id, username, password, role FROM users");

echo "<table border='1'><tr><th>Username</th><th>Role</th><th>Password Hash (Cut)</th><th>Valid 'admin123'?</th></tr>";

while ($row = mysqli_fetch_assoc($query)) {
    $verify = password_verify('admin123', $row['password']) ? 'YES' : 'NO';
    echo "<tr>
            <td>{$row['username']}</td>
            <td>{$row['role']}</td>
            <td>" . substr($row['password'], 0, 10) . "...</td>
            <td>{$verify}</td>
          </tr>";
}
echo "</table>";
?>