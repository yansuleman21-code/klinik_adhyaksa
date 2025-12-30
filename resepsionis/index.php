<?php
session_start();
include '../sim_adhyaksa/koneksi.php';

// Check Login
if ($_SESSION['status'] != "login" || $_SESSION['role'] != "resepsionis") {
    header("location:../login.php?pesan=belum_login");
    exit;
}

$title = "Dashboard Resepsionis - Klinik Adhyaksa";
include '../sim_adhyaksa/layout_header.php';
include '../sim_adhyaksa/layout_sidebar.php';


// Get Stats
$total_pasien = mysqli_num_rows(mysqli_query($conn, "SELECT id_pasien FROM pasien"));
$antrian_hari_ini = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM antrian WHERE tanggal = CURDATE()"));
?>

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard Pendaftaran</h1>
    <p class="text-gray-600">Selamat datang kembali, <?php echo $_SESSION['nama'] ?? $_SESSION['username']; ?>.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total Pasien</p>
                <h2 class="text-2xl font-bold text-gray-800"><?php echo $total_pasien; ?></h2>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500">
                <i class="fas fa-clipboard-list text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Antrian Hari Ini</p>
                <h2 class="text-2xl font-bold text-gray-800"><?php echo $antrian_hari_ini; ?></h2>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
        <div class="flex flex-col gap-3">
            <a href="pasien.php?action=add"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center transition">
                <i class="fas fa-user-plus mr-2"></i> Tambah Pasien Baru
            </a>
            <a href="antrian.php?action=add"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center transition">
                <i class="fas fa-ticket-alt mr-2"></i> Ambil Nomor Antrian
            </a>
        </div>
    </div>
</div>

<?php
// Close main content div (opened in sidebar) and body/html (opened in header)
echo "</main></div></div></body></html>";
?>