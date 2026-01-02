<?php
session_start();
include '../sim_adhyaksa/koneksi.php';

if ($_SESSION['status'] != "login" || $_SESSION['role'] != "resepsionis") {
    header("location:../login.php?pesan=belum_login");
    exit;
}

$title = "Data Pasien - Klinik Adhyaksa";
include '../sim_adhyaksa/layout_header.php';
include '../sim_adhyaksa/layout_sidebar.php';

// Handle Form Submission
if (isset($_POST['submit'])) {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $no_rm = $_POST['no_rm'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_bpjs = $_POST['no_bpjs'];

    $stmt = mysqli_prepare($conn, "INSERT INTO pasien (no_rm, nik, nama_pasien, alamat, tanggal_lahir, jenis_kelamin, no_bpjs) VALUES (?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssssss", $no_rm, $nik, $nama, $alamat, $tanggal_lahir, $jenis_kelamin, $no_bpjs);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Data pasien berhasil ditambahkan!'); window.location='pasien.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan: " . mysqli_error($conn) . "');</script>";
    }
}

?>

<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800">Data Pasien</h1>
    <button onclick="document.getElementById('modalAdd').classList.remove('hidden')"
        class="bg-primary-green hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-md">
        <i class="fas fa-user-plus mr-2"></i> Pasien Baru
    </button>
</div>

<!-- Table Data Pasien -->
<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    No RM</th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Nama Pasien</th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    NIK</th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Alamat</th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    BPJS</th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = mysqli_query($conn, "SELECT *, nama_pasien as nama, id_pasien as id FROM pasien ORDER BY id_pasien DESC LIMIT 50");
            while ($row = mysqli_fetch_array($query)) {
                ?>
                <tr>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <span class="font-bold text-gray-900"><?php echo $row['no_rm']; ?></span>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap"><?php echo $row['nama']; ?></p>
                        <p class="text-gray-500 text-xs">
                            <?php echo $row['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?>,
                            <?php echo date('d-m-Y', strtotime($row['tanggal_lahir'])); ?>
                        </p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo $row['nik']; ?></td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <?php echo substr($row['alamat'], 0, 30); ?>...
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo $row['no_bpjs'] ?: '-'; ?>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                        <a href="antrian.php?id_pasien=<?php echo $row['id']; ?>"
                            class="text-green-600 hover:text-green-900">Daftar</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Pasien -->
<div id="modalAdd" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Tambah Pasien Baru</h3>
            <form method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">No. Rekam Medis</label>
                    <input type="text" name="no_rm"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required placeholder="Contoh: RM-0001">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">NIK</label>
                    <input type="text" name="nik"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                    <input type="text" name="nama"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>
                <div class="flex gap-4 mb-4">
                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tgl Lahir</label>
                        <input type="date" name="tanggal_lahir"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                    </div>
                    <div class="w-1/2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Alamat</label>
                    <textarea name="alamat"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">No. BPJS (Opsional)</label>
                    <input type="text" name="no_bpjs"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="document.getElementById('modalAdd').classList.add('hidden')"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Batal</button>
                    <button type="submit" name="submit"
                        class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
echo "</main></div></div></body></html>";
?>