<?php
include 'sim_adhyaksa/koneksi.php';

$username = 'admin';
$password = password_hash('admin123', PASSWORD_DEFAULT);
$nama = 'Administrator';
$role = 'admin';

// Check if admin already exists just in case
$check = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
if (mysqli_num_rows($check) == 0) {
    $query = "INSERT INTO users (nama, username, password, role) VALUES ('$nama', '$username', '$password', '$role')";
    if (mysqli_query($conn, $query)) {
        echo "User Admin berhasil dikembalikan.<br>";
        echo "Username: <b>admin</b><br>";
        echo "Password: <b>admin123</b>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "User admin ternyata masih ada di database.";
}
?>