<?php
session_start();
include '../sim_adhyaksa/koneksi.php';

// Cek apakah user sudah login dan role-nya admin
if ($_SESSION['status'] != "login" || $_SESSION['role'] != "admin") {
    header("location:login.php?pesan=belum_login");
    exit;
}

$title = "Dashboard Admin - Klinik Adhyaksa";
include '../sim_adhyaksa/layout_header.php';
include '../sim_adhyaksa/layout_sidebar.php';

// Get Stats
$total_pasien = mysqli_num_rows(mysqli_query($conn, "SELECT id_pasien FROM pasien"));
$total_user = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users"));
$total_poli = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM poli"));
$total_obat = mysqli_num_rows(mysqli_query($conn, "SELECT id_obat FROM obat"));
?>

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
    <p class="text-gray-600">Selamat datang, Administrator.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total User</p>
                <h2 class="text-2xl font-bold text-gray-800"><?php echo $total_user; ?></h2>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500">
                <i class="fas fa-user-injured text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total Pasien</p>
                <h2 class="text-2xl font-bold text-gray-800"><?php echo $total_pasien; ?></h2>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-yellow-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                <i class="fas fa-hospital text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Poliklinik</p>
                <h2 class="text-2xl font-bold text-gray-800"><?php echo $total_poli; ?></h2>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-red-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-100 text-red-500">
                <i class="fas fa-pills text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Jenis Obat</p>
                <h2 class="text-2xl font-bold text-gray-800"><?php echo $total_obat; ?></h2>
            </div>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white p-6 rounded-lg shadow-sm">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Manajemen Sistem</h3>
        <div class="space-y-2">
            <a href="manajemen_user.php"
                class="block w-full text-left px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded text-gray-700">
                <i class="fas fa-user-cog mr-2"></i> Manajemen User
            </a>
            <!-- Placeholders for future features -->
            <button onclick="alert('Fitur ini akan datang!')"
                class="block w-full text-left px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded text-gray-700">
                <i class="fas fa-cog mr-2"></i> Pengaturan Aplikasi
            </button>
        </div>
    </div>
</div>

<?php echo "</main></div></div></body></html>"; ?>