<?php
session_start();
// Cek Login
if ($_SESSION['status'] != "login" || $_SESSION['role'] != "dokter") {
    header("location:../login.php?pesan=belum_login");
    exit;
}
include '../sim_adhyaksa/koneksi.php';

$title = "Dashboard Dokter - Klinik Adhyaksa";
include '../sim_adhyaksa/layout_header.php';
include '../sim_adhyaksa/layout_sidebar.php';
?>

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Pemeriksaan Pasien</h1>
    <p class="text-gray-600">Daftar antrian pasien hari ini (<?php echo date('d F Y'); ?>)</p>
</div>

<?php
// Calculate Stats for Doctor
$today = date('Y-m-d');
$username = $_SESSION['username'];
$user_check = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
$user = mysqli_fetch_assoc($user_check);
$id_dokter = $user['id'];

$count_menunggu = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM antrian WHERE tanggal='$today' AND id_dokter='$id_dokter' AND status='Menunggu'"));
$count_diperiksa = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM antrian WHERE tanggal='$today' AND id_dokter='$id_dokter' AND status='Diperiksa'"));
$count_selesai = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM antrian WHERE tanggal='$today' AND id_dokter='$id_dokter' AND status='Selesai'"));
?>

<!-- Doctor Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg p-5 shadow-sm border-l-4 border-gray-400 flex items-center justify-between">
        <div>
            <p class="text-gray-500 text-sm font-semibold uppercase">Menunggu</p>
            <h3 class="text-2xl font-bold text-gray-700"><?php echo $count_menunggu; ?></h3>
        </div>
        <div class="bg-gray-100 p-3 rounded-full text-gray-500">
            <i class="fas fa-hourglass-half text-xl"></i>
        </div>
    </div>

    <div class="bg-white rounded-lg p-5 shadow-sm border-l-4 border-yellow-500 flex items-center justify-between">
        <div>
            <p class="text-yellow-600 text-sm font-semibold uppercase">Sedang Diperiksa</p>
            <h3 class="text-2xl font-bold text-yellow-700"><?php echo $count_diperiksa; ?></h3>
        </div>
        <div class="bg-yellow-100 p-3 rounded-full text-yellow-600">
            <i class="fas fa-stethoscope text-xl"></i>
        </div>
    </div>

    <div class="bg-white rounded-lg p-5 shadow-sm border-l-4 border-green-500 flex items-center justify-between">
        <div>
            <p class="text-green-600 text-sm font-semibold uppercase">Selesai</p>
            <h3 class="text-2xl font-bold text-green-700"><?php echo $count_selesai; ?></h3>
        </div>
        <div class="bg-green-100 p-3 rounded-full text-green-600">
            <i class="fas fa-check-circle text-xl"></i>
        </div>
    </div>
</div>

<!-- Antrian Table -->
<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">Antrian Poli Umum</h3>
    </div>
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    No Antrian</th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Pasien</th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Status</th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $today = date('Y-m-d');
            // Note: Assuming Doctor sees all poli for now, or specifically Poli Umum (id usually 1, but we use join)
            // Ideally filtered by the specific poli the doctor is assigned to.
            // Get current doctor's ID
            $username = $_SESSION['username'];
            $user_check = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
            $user = mysqli_fetch_assoc($user_check);
            $id_dokter = $user['id'];

            $query = mysqli_query($conn, "
    SELECT antrian.*, pasien.nama_pasien AS nama, pasien.no_rm, poli.nama_poli 
    FROM antrian 
    JOIN pasien ON antrian.id_pasien = pasien.id_pasien 
    JOIN poli ON antrian.id_poli = poli.id 
    WHERE antrian.tanggal = CURDATE() AND antrian.status != 'Selesai' AND antrian.id_dokter = '$id_dokter'
    ORDER BY antrian.no_antrian ASC
");

            if (mysqli_num_rows($query) == 0) {
                echo "<tr><td colspan='4' class='text-center py-4 text-gray-500'>Tidak ada pasien antri saat ini.</td></tr>";
            }

            while ($row = mysqli_fetch_array($query)) {
                $statusColor = 'bg-gray-200 text-gray-800';
                if ($row['status'] == 'Diperiksa')
                    $statusColor = 'bg-yellow-200 text-yellow-800';
                ?>
                <tr>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <span class="font-bold text-xl"><?php echo $row['no_antrian']; ?></span>
                        <span class="text-xs block text-gray-500"><?php echo $row['nama_poli']; ?></span>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="font-bold text-gray-900"><?php echo $row['nama']; ?></p>
                        <p class="text-xs text-gray-500"><?php echo $row['no_rm']; ?></p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <span
                            class="relative inline-block px-3 py-1 font-semibold leading-tight rounded-full <?php echo $statusColor; ?>">
                            <span class="relative"><?php echo $row['status']; ?></span>
                        </span>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <a href="periksa.php?id=<?php echo $row['id']; ?>"
                            class="bg-primary-green hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition">
                            <i class="fas fa-stethoscope mr-2"></i> Periksa
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
echo "</main></div></div></body></html>";
?>