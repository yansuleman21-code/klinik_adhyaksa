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
            // 1. Check current stock
            $stmt_stock = mysqli_prepare($conn, "SELECT stok, nama_obat FROM obat WHERE id_obat = ?");
            mysqli_stmt_bind_param($stmt_stock, "i", $id_obat);
            mysqli_stmt_execute($stmt_stock);
            $res_stock = mysqli_stmt_get_result($stmt_stock);
            $stock_data = mysqli_fetch_assoc($res_stock);

            if ($stock_data['stok'] < $qty) {
                throw new Exception("Stok obat " . $stock_data['nama_obat'] . " tidak cukup!");
            }

            // 2. Insert into resep_obat
            // 2. Insert into resep_obat
            $stmt_insert = mysqli_prepare($conn, "INSERT INTO resep_obat (id_rm, id_obat, jumlah) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt_insert, "iii", $id_rm, $id_obat, $qty);
            $insert = mysqli_stmt_execute($stmt_insert);
            if (!$insert)
                throw new Exception(mysqli_error($conn));

            // 3. Deduct stock
            // 3. Deduct stock
            $stmt_update = mysqli_prepare($conn, "UPDATE obat SET stok = stok - ? WHERE id_obat = ?");
            mysqli_stmt_bind_param($stmt_update, "ii", $qty, $id_obat);
            $update = mysqli_stmt_execute($stmt_update);
            if (!$update)
                throw new Exception(mysqli_error($conn));
        }
    }

    // 4. Update rekam_medis status
    // 4. Update rekam_medis status
    $stmt_rm = mysqli_prepare($conn, "UPDATE rekam_medis SET status_obat = 'Selesai' WHERE id_rm = ?");
    mysqli_stmt_bind_param($stmt_rm, "i", $id_rm);
    $update_rm = mysqli_stmt_execute($stmt_rm);
    if (!$update_rm)
        throw new Exception(mysqli_error($conn));

    mysqli_commit($conn);
    echo "<script>alert('Resep berhasil diproses & stok berkurang otomatis!'); window.location='index.php';</script>";

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "<script>alert('Gagal: " . $e->getMessage() . "'); window.location='index.php';</script>";
}
?>