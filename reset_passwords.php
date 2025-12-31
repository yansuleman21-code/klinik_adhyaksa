<?php
include 'sim_adhyaksa/koneksi.php';

$title = "Reset Password";
$hashed_password = password_hash('admin123', PASSWORD_DEFAULT);

// Reset all users or specific roles if needed. Here we target the role 'dokter' specifically or all.
$users = [
    ['username' => 'admin', 'role' => 'admin', 'nama' => 'Administrator'],
    ['username' => 'dokter', 'role' => 'dokter', 'nama' => 'Dr. Budi'],
    ['username' => 'apotek', 'role' => 'apoteker', 'nama' => 'Apoteker Sari'],
    ['username' => 'pendaftaran', 'role' => 'resepsionis', 'nama' => 'Resepsionis Ani']
];

foreach ($users as $u) {
    $u_name = $u['username'];
    $role = $u['role'];
    $nama = $u['nama'];

    // Check if user exists
    $check = mysqli_query($conn, "SELECT id FROM users WHERE username='$u_name'");

    if (mysqli_num_rows($check) > 0) {
        $query = "UPDATE users SET password='$hashed_password', nama='$nama' WHERE username='$u_name'";
        if (mysqli_query($conn, $query)) {
            echo "Password for user <b>$u_name</b> reset to: admin123<br>";
        } else {
            echo "Error updating $u_name: " . mysqli_error($conn) . "<br>";
        }
    } else {
        $query = "INSERT INTO users (nama, username, password, role) VALUES ('$nama', '$u_name', '$hashed_password', '$role')";
        if (mysqli_query($conn, $query)) {
            echo "Created user <b>$u_name</b> with password: admin123<br>";
        } else {
            echo "Error creating $u_name: " . mysqli_error($conn) . "<br>";
        }
    }
}
?>