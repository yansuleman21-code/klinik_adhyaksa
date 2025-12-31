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

// Data for Charts
// 1. Poli Distribution (Based on Queues/Visits today or total)
// Using total visits in antrian table for better data visualization
$poli_query = mysqli_query($conn, "
    SELECT p.nama_poli, COUNT(a.id) as count 
    FROM antrian a 
    JOIN poli p ON a.id_poli = p.id 
    GROUP BY p.id
");
$poli_labels = [];
$poli_data = [];
while ($row = mysqli_fetch_assoc($poli_query)) {
    $poli_labels[] = $row['nama_poli'];
    $poli_data[] = $row['count'];
}

// 2. Weekly Visits (Last 7 Days)
$dates = [];
$visits = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $dates[] = date('d M', strtotime($date));

    $visit_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM antrian WHERE tanggal = '$date'");
    $visit_row = mysqli_fetch_assoc($visit_query);
    $visits[] = $visit_row['count'];
}
?>

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard Overview</h1>
    <p class="text-gray-600">Ringkasan aktivitas klinik hari ini.</p>
</div>

<!-- Modern Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card 1 -->
    <div
        class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-blue-100 text-sm font-medium uppercase tracking-wider">Total User</p>
                <h2 class="text-3xl font-bold mt-1"><?php echo $total_user; ?></h2>
            </div>
            <div class="bg-white bg-opacity-20 p-3 rounded-full">
                <i class="fas fa-users text-2xl"></i>
            </div>
        </div>
        <p class="text-blue-100 text-xs mt-4 flex items-center">
            <i class="fas fa-arrow-up mr-1"></i> Admin, Dokter, & Staff
        </p>
    </div>

    <!-- Card 2 -->
    <div
        class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-emerald-100 text-sm font-medium uppercase tracking-wider">Total Pasien</p>
                <h2 class="text-3xl font-bold mt-1"><?php echo $total_pasien; ?></h2>
            </div>
            <div class="bg-white bg-opacity-20 p-3 rounded-full">
                <i class="fas fa-user-injured text-2xl"></i>
            </div>
        </div>
        <p class="text-emerald-100 text-xs mt-4 flex items-center">
            <i class="fas fa-check-circle mr-1"></i> Terdaftar di database
        </p>
    </div>

    <!-- Card 3 -->
    <div
        class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-amber-100 text-sm font-medium uppercase tracking-wider">Poliklinik</p>
                <h2 class="text-3xl font-bold mt-1"><?php echo $total_poli; ?></h2>
            </div>
            <div class="bg-white bg-opacity-20 p-3 rounded-full">
                <i class="fas fa-hospital text-2xl"></i>
            </div>
        </div>
        <p class="text-amber-100 text-xs mt-4 flex items-center">
            <i class="fas fa-heartbeat mr-1"></i> Layanan Aktif
        </p>
    </div>

    <!-- Card 4 -->
    <div
        class="bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-rose-100 text-sm font-medium uppercase tracking-wider">Jenis Obat</p>
                <h2 class="text-3xl font-bold mt-1"><?php echo $total_obat; ?></h2>
            </div>
            <div class="bg-white bg-opacity-20 p-3 rounded-full">
                <i class="fas fa-pills text-2xl"></i>
            </div>
        </div>
        <p class="text-rose-100 text-xs mt-4 flex items-center">
            <i class="fas fa-box-open mr-1"></i> Stok Tersedia
        </p>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Line Chart (Weekly Trends) -->
    <div class="bg-white rounded-xl shadow-sm p-6 lg:col-span-2">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Tren Kunjungan (7 Hari Terakhir)</h3>
        <div class="relative h-64 w-full">
            <canvas id="visitChart"></canvas>
        </div>
    </div>

    <!-- Doughnut Chart (Poli Distribution) -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Sebaran Pasien per Poli</h3>
        <div class="relative h-64 w-full flex justify-center">
            <canvas id="poliChart"></canvas>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white p-6 rounded-xl shadow-sm mb-8">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi Cepat</h3>
    <div class="flex gap-4">
        <a href="manajemen_user.php"
            class="flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
            <i class="fas fa-user-plus mr-2"></i> Tambah User
        </a>
        <button onclick="alert('Fitur laporan akan segera hadir!')"
            class="flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
            <i class="fas fa-file-alt mr-2"></i> Unduh Laporan
        </button>
    </div>
</div>

<!-- Scripts for Charts -->
<script>
    // Poli Distribution Chart
    const poliCtx = document.getElementById('poliChart').getContext('2d');
    new Chart(poliCtx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($poli_labels); ?>,
            datasets: [{
                data: <?php echo json_encode($poli_data); ?>,
                backgroundColor: [
                    '#3b82f6', // Blue
                    '#10b981', // Emerald
                    '#f59e0b', // Amber
                    '#ef4444', // Rose
                    '#8b5cf6'  // Violet
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Weekly Visits Chart
    const visitCtx = document.getElementById('visitChart').getContext('2d');
    new Chart(visitCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($dates); ?>,
            datasets: [{
                label: 'Jumlah Pasien',
                data: <?php echo json_encode($visits); ?>,
                borderColor: '#0284c7', // Sky 600
                backgroundColor: 'rgba(2, 132, 199, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#0284c7',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        borderDash: [2, 2]
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>

<?php echo "</main></div></div></body></html>"; ?>