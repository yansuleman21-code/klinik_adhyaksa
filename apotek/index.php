<?php
session_start();
include '../sim_adhyaksa/koneksi.php';

if ($_SESSION['status'] != "login" || $_SESSION['role'] != "apoteker") {
    header("location:../login.php?pesan=belum_login");
    exit;
}

$title = "Dashboard Apoteker - Klinik Adhyaksa";
include '../sim_adhyaksa/layout_header.php';
include '../sim_adhyaksa/layout_sidebar.php';

// Get prescription stats
// Assuming recipes that are 'Selesai' from doctor but maybe we can add a flag later for 'Taken'?
// For now, let's just list the recent checkups (Selesai status in Antrian usually means done by doctor)
$query_resep = mysqli_query($conn, "
    SELECT rekam_medis.*, pasien.nama_pasien, pasien.no_rm, users.nama as nama_dokter 
    FROM rekam_medis 
    JOIN pasien ON rekam_medis.id_pasien = pasien.id_pasien
    JOIN users ON rekam_medis.id_dokter = users.id
    WHERE rekam_medis.tanggal = CURDATE()
    ORDER BY rekam_medis.id_rm DESC
");
?>

<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Resep Masuk</h1>
        <p class="text-gray-600">Daftar resep dari pemeriksaan hari ini (<?php echo date('d F Y'); ?>)</p>
    </div>
    <a href="data_obat.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-md">
        <i class="fas fa-pills mr-2"></i> Kelola Stok Obat
    </a>
</div>

<div class="grid grid-cols-1 gap-6">
    <?php if (mysqli_num_rows($query_resep) == 0): ?>
        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
            Belum ada resep masuk hari ini.
        </div>
    <?php endif; ?>

    <?php while ($r = mysqli_fetch_array($query_resep)): ?>
        <div class="bg-white shadow-md rounded-lg overflow-hidden border-l-4 border-purple-500">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800"><?php echo $r['nama_pasien']; ?></h3>
                        <p class="text-sm text-gray-500">No. RM: <?php echo $r['no_rm']; ?></p>
                        <p class="text-sm text-gray-500">Dokter: <?php echo $r['nama_dokter']; ?></p>
                    </div>
                    <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded">Resep
                        Baru</span>
                </div>

                <div class="bg-gray-50 p-4 rounded border border-gray-200">
                    <h4 class="font-semibold text-gray-700 mb-2">Rincian Obat / Resep:</h4>
                    <p class="whitespace-pre-line text-gray-800"><?php echo $r['resep']; ?></p>
                </div>

                <div class="mt-4 flex justify-end">
                    <button
                        onclick="alert('Fitur proses resep (potong stok otomatis) belum diimplementasikan. Silakan potong stok manual di menu Data Obat.')"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                        <i class="fas fa-check mr-2"></i> Tandai Selesai
                    </button>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php echo "</main></div></div></body></html>"; ?>