<?php
include 'sim_adhyaksa/koneksi.php';

$username = 'dokter';
$password = password_hash('admin123', PASSWORD_DEFAULT);
$nama = 'Dr. Budi Santoso';
$role = 'dokter';

// Check if user already exists
$check = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");

if (mysqli_num_rows($check) == 0) {
    // Insert new doctor
    $query = "INSERT INTO users (nama, username, password, role) VALUES ('$nama', '$username', '$password', '$role')";
    if (mysqli_query($conn, $query)) {
        echo "User Dokter berhasil dibuat.<br>";
        echo "Nama: $nama<br>";
        echo "Username: $username<br>";
        echo "Password: admin123";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "User dokter sudah ada.";
}
?>