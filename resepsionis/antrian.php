<?php
session_start();
include '../sim_adhyaksa/koneksi.php';

if ($_SESSION['status'] != "login" || $_SESSION['role'] != "resepsionis") {
    header("location:../login.php?pesan=belum_login");
    exit;
}

$title = "Antrian - Klinik Adhyaksa";
include '../sim_adhyaksa/layout_header.php';
include '../sim_adhyaksa/layout_sidebar.php';

// Handle Add Antrian
if (isset($_POST['add_antrian'])) {
    $id_pasien = $_POST['id_pasien'];
    $id_poli = $_POST['id_poli'];
    $id_dokter = $_POST['id_dokter'];

    // Vital Signs
    $tensi = $_POST['tensi'];
    $bb = $_POST['bb'];
    $tb = $_POST['tb'];
    $suhu = $_POST['suhu'];

    $tanggal = date('Y-m-d');

    // Get Last Queue Number
    $check = mysqli_query($conn, "SELECT no_antrian FROM antrian WHERE tanggal = '$tanggal' AND id_poli = '$id_poli' ORDER BY no_antrian DESC LIMIT 1");
    $last = mysqli_fetch_assoc($check);
    $no_antrian = ($last ? $last['no_antrian'] : 0) + 1;

    $query = "INSERT INTO antrian (id_pasien, id_poli, id_dokter, tanggal, no_antrian, status, tensi, berat_badan, tinggi_badan, suhu) VALUES ('$id_pasien', '$id_poli', '$id_dokter', '$tanggal', '$no_antrian', 'Menunggu', '$tensi', '$bb', '$tb', '$suhu')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Antrian berhasil ditambahkan! Nomor: $no_antrian'); window.location='antrian.php';</script>";
    } else {
        echo "<script>alert('Gagal: " . mysqli_error($conn) . "');</script>";
    }
}

// Handle Status Update
if (isset($_GET['status']) && isset($_GET['id'])) {
    $status = $_GET['status'];
    $id = $_GET['id'];
    mysqli_query($conn, "UPDATE antrian SET status='$status' WHERE id='$id'");
    echo "<script>window.location='antrian.php';</script>";
}
?>

<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Antrian Hari Ini</h1>
        <p class="text-sm text-gray-600"><?php echo date('d F Y'); ?></p>
    </div>
    <button onclick="document.getElementById('modalAntrian').classList.remove('hidden')"
        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-md">
        <i class="fas fa-plus mr-2"></i> Tambah Antrian
    </button>
</div>

<!-- Queue List -->
<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    No</th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Poli / Dokter</th>
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
            $query = mysqli_query($conn, "
                SELECT antrian.*, pasien.nama_pasien AS nama, pasien.no_rm, poli.nama_poli, users.nama AS nama_dokter 
                FROM antrian 
                JOIN pasien ON antrian.id_pasien = pasien.id_pasien 
                JOIN poli ON antrian.id_poli = poli.id 
                JOIN users ON antrian.id_dokter = users.id
                WHERE tanggal = '$today' 
                ORDER BY no_antrian DESC
            ");

            if (mysqli_num_rows($query) == 0) {
                echo "<tr><td colspan='5' class='text-center py-4 text-gray-500'>Belum ada antrian hari ini.</td></tr>";
            }

            while ($row = mysqli_fetch_array($query)) {
                $statusColor = 'bg-gray-200 text-gray-800';
                if ($row['status'] == 'Diperiksa')
                    $statusColor = 'bg-yellow-200 text-yellow-800';
                if ($row['status'] == 'Selesai')
                    $statusColor = 'bg-green-200 text-green-800';
                ?>
                <tr>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <span class="font-bold text-xl"><?php echo $row['no_antrian']; ?></span>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="font-semibold text-gray-900"><?php echo $row['nama_poli']; ?></p>
                        <p class="text-xs text-gray-500"><?php echo $row['nama_dokter']; ?></p>
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
                        <?php if ($row['status'] == 'Menunggu'): ?>
                            <a href="antrian.php?id=<?php echo $row['id']; ?>&status=Diperiksa"
                                class="text-blue-600 hover:text-blue-900 font-bold text-xs bg-blue-100 px-2 py-1 rounded">Panggil</a>
                        <?php elseif ($row['status'] == 'Diperiksa'): ?>
                            <a href="antrian.php?id=<?php echo $row['id']; ?>&status=Selesai"
                                class="text-green-600 hover:text-green-900 font-bold text-xs bg-green-100 px-2 py-1 rounded">Selesai</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Antrian -->
<div id="modalAntrian" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Antrian Baru</h3>
        <form method="POST">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Pasien</label>
                <select name="id_pasien" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                    <option value="">-- Pilih Pasien --</option>
                    <?php
                    $pasien = mysqli_query($conn, "SELECT id_pasien AS id, nama_pasien AS nama, no_rm FROM pasien ORDER BY nama_pasien ASC");
                    while ($p = mysqli_fetch_array($pasien)) {
                        $selected = (isset($_GET['id_pasien']) && $_GET['id_pasien'] == $p['id']) ? 'selected' : '';
                        echo "<option value='" . $p['id'] . "' $selected>" . $p['no_rm'] . " - " . $p['nama'] . "</option>";
                    }
                    ?>
                </select>
                <p class="text-xs text-gray-500 mt-1">Pasien belum terdaftar? <a href="pasien.php"
                        class="text-blue-500">Tambah disini</a></p>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Poli Tujuan</label>
                <select name="id_poli" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                    <?php
                    $poli = mysqli_query($conn, "SELECT * FROM poli");
                    while ($po = mysqli_fetch_array($poli)) {
                        echo "<option value='" . $po['id'] . "'>" . $po['nama_poli'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Dokter</label>
                <select name="id_dokter" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                    <option value="">-- Pilih Dokter --</option>
                    <?php
                    $dokter = mysqli_query($conn, "SELECT * FROM users WHERE role='dokter'");
                    while ($doc = mysqli_fetch_array($dokter)) {
                        echo "<option value='" . $doc['id'] . "'>" . $doc['nama'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-4 border-t pt-4">
                <h4 class="font-bold text-gray-700 mb-2">Tanda Vital (Awal)</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tensi (mmHg)</label>
                        <input type="text" name="tensi" placeholder="120/80"
                            class="shadow border rounded w-full py-2 px-3 text-gray-700">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Suhu (°C)</label>
                        <input type="number" step="0.1" name="suhu" placeholder="36.5"
                            class="shadow border rounded w-full py-2 px-3 text-gray-700">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Berat (kg)</label>
                        <input type="number" name="bb" placeholder="60"
                            class="shadow border rounded w-full py-2 px-3 text-gray-700">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tinggi (cm)</label>
                        <input type="number" name="tb" placeholder="170"
                            class="shadow border rounded w-full py-2 px-3 text-gray-700">
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="button" onclick="document.getElementById('modalAntrian').classList.add('hidden')"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Batal</button>
                <button type="submit" name="add_antrian"
                    class="bg-green-600 hover:bg-green-800 text-white font-bold py-2 px-4 rounded">Daftarkan</button>
            </div>
        </form>
    </div>
</div>

<?php
echo "</main></div></div></body></html>";
?>