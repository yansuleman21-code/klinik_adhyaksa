<?php
// Mengaktifkan session php
session_start();

// Menghubungkan dengan koneksi
include 'sim_adhyaksa/koneksi.php';

// Menangkap data yang dikirim dari form
$username = trim($_POST['username']);
$password = $_POST['password'];

// Mencegah SQL Injection sederhana
$username = mysqli_real_escape_string($conn, $username);

// Menyeleksi data user dengan username yang sesuai
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($result);

if ($cek > 0) {
    $row = mysqli_fetch_assoc($result);

    // Verifikasi password dengan hash
    if (password_verify($password, $row['password'])) {
        // Simpan data user ke dalam SESSION agar bisa dibaca di halaman lain
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $row['role'];
        $_SESSION['status'] = "login";
        $_SESSION['nama'] = $row['nama'];

        // Cek Level/Role User untuk diarahkan ke halaman masing-masing
        if ($row['role'] == "resepsionis") {
            header("location:resepsionis/index.php");
        } else if ($row['role'] == "dokter") {
            header("location:dokter/index.php");
        } else if ($row['role'] == "apoteker") {
            header("location:apotek/index.php");
        } else if ($row['role'] == "admin") {
            header("location:admin/index.php");
        } else {
            // Default redirect
            header("location:admin/index.php");
        }
    } else {
        // Password salah
        header("location:login.php?pesan=gagal");
    }

} else {
    // Username tidak ditemukan
    header("location:login.php?pesan=gagal");
}
?>