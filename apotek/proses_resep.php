<?php
session_start();
include '../sim_adhyaksa/koneksi.php';

if (!isset($_POST['proses_resep'])) {
    header("location:index.php");
    exit;
}

$id_rm = $_POST['id_rm'];
$obat_ids = $_POST['id_obat']; // Array
$qtys = $_POST['qty']; // Array

// Start Transaction
mysqli_begin_transaction($conn);

try {
    for ($i = 0; $i < count($obat_ids); $i++) {
        $id_obat = $obat_ids[$i];
        $qty = $qtys[$i];

        if ($qty > 0 && !empty($id_obat)) {
            // 1. Check current stock
            $stock_query = mysqli_query($conn, "SELECT stok, nama_obat FROM obat WHERE id_obat = '$id_obat'");
            $stock_data = mysqli_fetch_assoc($stock_query);

            if ($stock_data['stok'] < $qty) {
                throw new Exception("Stok obat " . $stock_data['nama_obat'] . " tidak cukup!");
            }

            // 2. Insert into resep_obat
            $insert = mysqli_query($conn, "INSERT INTO resep_obat (id_rm, id_obat, jumlah) VALUES ('$id_rm', '$id_obat', '$qty')");
            if (!$insert)
                throw new Exception(mysqli_error($conn));

            // 3. Deduct stock
            $update = mysqli_query($conn, "UPDATE obat SET stok = stok - $qty WHERE id_obat = '$id_obat'");
            if (!$update)
                throw new Exception(mysqli_error($conn));
        }
    }

    // 4. Update rekam_medis status
    $update_rm = mysqli_query($conn, "UPDATE rekam_medis SET status_obat = 'Selesai' WHERE id_rm = '$id_rm'");
    if (!$update_rm)
        throw new Exception(mysqli_error($conn));

    mysqli_commit($conn);
    echo "<script>alert('Resep berhasil diproses & stok berkurang otomatis!'); window.location='index.php';</script>";

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "<script>alert('Gagal: " . $e->getMessage() . "'); window.location='index.php';</script>";
}
?>