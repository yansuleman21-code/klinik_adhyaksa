<?php
session_start();
include '../sim_adhyaksa/koneksi.php';

if ($_SESSION['status'] != "login" || $_SESSION['role'] != "dokter") {
    header("location:../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("location:index.php"); // Relative to dokter folder, so index.php is correct
    exit;
}

$id_antrian = $_GET['id'];

// Get Antrian & Pasien Data
// Get Antrian & Pasien Data
$stmt = mysqli_prepare($conn, "
    SELECT antrian.*, pasien.id_pasien, pasien.nama_pasien AS nama, pasien.no_rm, pasien.tanggal_lahir, pasien.jenis_kelamin, poli.nama_poli 
    FROM antrian 
    JOIN pasien ON antrian.id_pasien = pasien.id_pasien 
    JOIN poli ON antrian.id_poli = poli.id 
    WHERE antrian.id = ?
");
mysqli_stmt_bind_param($stmt, "i", $id_antrian);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "Data antrian tidak ditemukan.";
    exit;
}

// Update Status to 'Diperiksa' if currently 'Menunggu'
if ($data['status'] == 'Menunggu') {
    $stmt_update = mysqli_prepare($conn, "UPDATE antrian SET status='Diperiksa' WHERE id=?");
    mysqli_stmt_bind_param($stmt_update, "i", $id_antrian);
    mysqli_stmt_execute($stmt_update);
}

// Handle Form Submit
if (isset($_POST['submit'])) {
    $id_pasien = $data['id_pasien'];
    $id_poli = $data['id_poli'];
    $id_dokter = 0; // Placeholder

    // Get logged in doctor ID
    $stmt_user = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt_user, "s", $_SESSION['username']);
    mysqli_stmt_execute($stmt_user);
    $check_user = mysqli_stmt_get_result($stmt_user);
    if ($u = mysqli_fetch_assoc($check_user)) {
        $id_dokter = $u['id'];
    }

    $tanggal = date('Y-m-d');
    $keluhan = $_POST['keluhan'];
    $diagnosa = $_POST['diagnosa'];
    $resep = $_POST['resep'];

    // Insert Rekam Medis
    $stmt_insert = mysqli_prepare($conn, "INSERT INTO rekam_medis (id_pasien, id_dokter, id_poli, tanggal, keluhan, diagnosa, resep) VALUES (?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt_insert, "iiissss", $id_pasien, $id_dokter, $id_poli, $tanggal, $keluhan, $diagnosa, $resep);

    if (mysqli_stmt_execute($stmt_insert)) {
        // Update Antrian to Selesai
        $stmt_done = mysqli_prepare($conn, "UPDATE antrian SET status='Selesai' WHERE id=?");
        mysqli_stmt_bind_param($stmt_done, "i", $id_antrian);
        mysqli_stmt_execute($stmt_done);
        echo "<script>alert('Pemeriksaan Selesai!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan: " . mysqli_error($conn) . "');</script>";
    }
}

$title = "Pemeriksaan Pasien - Klinik Adhyaksa";
include '../sim_adhyaksa/layout_header.php';
include '../sim_adhyaksa/layout_sidebar.php';
?>

<div class="mb-6 flex items-center gap-4">
    <a href="index.php" class="text-gray-500 hover:text-gray-700"><i class="fas fa-arrow-left text-xl"></i></a>
    <h1 class="text-3xl font-bold text-gray-800">Pemeriksaan Pasien</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Patient Info Side -->
    <div class="lg:col-span-1">
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6 border-t-4 border-blue-500">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Data Pasien</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-xs text-gray-500">Nama Lengkap</p>
                    <p class="font-semibold text-gray-900"><?php echo $data['nama']; ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">No. Rekam Medis</p>
                    <p class="font-semibold text-gray-900"><?php echo $data['no_rm']; ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Jenis Kelamin</p>
                    <p class="font-semibold text-gray-900">
                        <?php echo $data['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?>
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Poli Tujuan</p>
                    <p class="font-semibold text-gray-900"><?php echo $data['nama_poli']; ?></p>
                </div>
            </div>
        </div>

        <!-- History (Simple) -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Riwayat Kunjungan</h3>
            <div class="space-y-4">
                <?php
                $hist = mysqli_query($conn, "SELECT tanggal, diagnosa FROM rekam_medis WHERE id_pasien = '$data[id_pasien]' ORDER BY tanggal DESC LIMIT 3");
                if (mysqli_num_rows($hist) == 0) {
                    echo "<p class='text-sm text-gray-500'>Belum ada riwayat.</p>";
                }
                while ($h = mysqli_fetch_array($hist)) {
                    echo "<div class='border-b pb-2'>";
                    echo "<p class='text-xs text-gray-500'>" . date('d M Y', strtotime($h['tanggal'])) . "</p>";
                    echo "<p class='text-sm font-medium'>" . $h['diagnosa'] . "</p>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Exam Form -->
    <div class="lg:col-span-2">
        <!-- Vital Signs Card -->
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6 border-l-4 border-yellow-500">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Tanda Vital (Pemeriksaan Awal)</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-3 bg-gray-50 rounded">
                    <p class="text-xs text-gray-500">Tekanan Darah</p>
                    <p class="font-bold text-xl text-gray-800">
                        <?php echo !empty($data['tensi']) ? $data['tensi'] : '-'; ?>
                    </p>
                    <span class="text-xs text-gray-400">mmHg</span>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded">
                    <p class="text-xs text-gray-500">Suhu Tubuh</p>
                    <p class="font-bold text-xl text-gray-800">
                        <?php echo !empty($data['suhu']) ? $data['suhu'] : '-'; ?>
                    </p>
                    <span class="text-xs text-gray-400">°C</span>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded">
                    <p class="text-xs text-gray-500">Berat Badan</p>
                    <p class="font-bold text-xl text-gray-800">
                        <?php echo !empty($data['berat_badan']) ? $data['berat_badan'] : '-'; ?>
                    </p>
                    <span class="text-xs text-gray-400">kg</span>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded">
                    <p class="text-xs text-gray-500">Tinggi Badan</p>
                    <p class="font-bold text-xl text-gray-800">
                        <?php echo !empty($data['tinggi_badan']) ? $data['tinggi_badan'] : '-'; ?>
                    </p>
                    <span class="text-xs text-gray-400">cm</span>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Keluhan Pasien (Anamnesis)</label>
                    <textarea name="keluhan" rows="4"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Diagnosa Dokter</label>
                    <textarea name="diagnosa" rows="3"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required></textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Resep Obat / Tindakan</label>
                    <textarea name="resep" rows="4"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Tuliskan nama obat dan dosis..."></textarea>
                </div>

                <div class="flex items-center justify-between">
                    <a href="index.php" class="text-gray-500 hover:text-gray-700 font-bold">Kembali</a>
                    <button type="submit" name="submit"
                        class="bg-primary-green hover:bg-green-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">
                        <i class="fas fa-save mr-2"></i> Simpan & Selesai
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
echo "</main></div></div></body></html>";
?>