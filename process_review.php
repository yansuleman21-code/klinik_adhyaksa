<?php
include 'sim_adhyaksa/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars($_POST['nama']);
    $rating = intval($_POST['rating']);
    $komentar = htmlspecialchars($_POST['komentar']);

    if (!empty($nama) && !empty($rating) && !empty($komentar)) {
        // Use $conn instead of $koneksi
        $stmt = $conn->prepare("INSERT INTO ulasan (nama, rating, komentar) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $nama, $rating, $komentar);

        if ($stmt->execute()) {
            echo "<script>alert('Terima kasih atas ulasan Anda!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Gagal mengirim ulasan.'); window.location.href='index.php';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Mohon lengkapi semua data.'); window.location.href='index.php';</script>";
    }
} else {
    header("Location: index.php");
}
?>