<?php
include 'sim_adhyaksa/koneksi.php';

echo "<h2>Debug Login</h2>";

// 1. Cek Koneksi
if ($conn) {
    echo "<p style='color:green'>✅ Koneksi Database Berhasil!</p>";
} else {
    echo "<p style='color:red'>❌ Koneksi Database Gagal: " . mysqli_connect_error() . "</p>";
    exit; // Stop jika koneksi gagal
}

// 2. Cek User 'admin'
$username = 'admin';
$password_plain = 'admin123';
$password_md5 = md5($password_plain);

echo "<p>Mencari user: <b>$username</b></p>";
echo "<p>Password input: <b>$password_plain</b></p>";
echo "<p>MD5 Hash (PHP): <b>$password_md5</b></p>";

$query = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "<p style='color:red'>❌ Query Error: " . mysqli_error($conn) . "</p>";
    echo "<p>Kemungkinan tabel <b>users</b> belum dibuat.</p>";
} else {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo "<p style='color:green'>✅ User ditemukan!</p>";
        echo "<ul>";
        echo "<li>ID: " . $row['id'] . "</li>";
        echo "<li>Username di DB: " . $row['username'] . "</li>";
        echo "<li>Password di DB: " . $row['password'] . "</li>";
        echo "<li>Role: " . $row['role'] . "</li>";
        echo "</ul>";

        if ($row['password'] == $password_md5) {
            echo "<h3 style='color:green'>✅ LOGIN SEHARUSNYA BERHASIL! (Password COCOK)</h3>";
        } else {
            echo "<h3 style='color:red'>❌ PASSWORD TIDAK COCOK!</h3>";
            echo "<p>Hash di Database berbeda dengan Hash PHP.</p>";
        }
    } else {
        echo "<p style='color:red'>❌ User 'admin' TIDAK DITEMUKAN di database.</p>";
        echo "<p>Pastikan Anda sudah menjalankan perintah SQL INSERT sebelumnya.</p>";
    }
}
?>