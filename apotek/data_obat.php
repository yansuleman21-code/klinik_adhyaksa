<?php
session_start();
include '../sim_adhyaksa/koneksi.php';

if ($_SESSION['status'] != "login" || $_SESSION['role'] != "apoteker") {
    header("location:../login.php");
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM obat WHERE id_obat='$id'");
    header("location:data_obat.php");
}

// Handle Add/Edit
if (isset($_POST['submit'])) {
    $nama = $_POST['nama_obat'];
    $jenis = $_POST['jenis_obat'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    if ($_POST['id_obat'] != "") {
        $id = $_POST['id_obat'];
        mysqli_query($conn, "UPDATE obat SET nama_obat='$nama', jenis_obat='$jenis', stok='$stok', harga='$harga' WHERE id_obat='$id'");
    } else {
        mysqli_query($conn, "INSERT INTO obat (nama_obat, jenis_obat, stok, harga) VALUES ('$nama', '$jenis', '$stok', '$harga')");
    }
    header("location:data_obat.php");
}

$title = "Data Obat - Klinik Adhyaksa";
include '../sim_adhyaksa/layout_header.php';
include '../sim_adhyaksa/layout_sidebar.php';
?>

<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800">Manajemen Obat</h1>
    <button onclick="openModal()"
        class="bg-primary-green hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-md">
        <i class="fas fa-plus mr-2"></i> Tambah Obat
    </button>
</div>

<!-- Table Data Obat -->
<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Nama Obat</th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Jenis</th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Stok</th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Harga</th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = mysqli_query($conn, "SELECT * FROM obat ORDER BY nama_obat ASC");
            while ($row = mysqli_fetch_array($query)) {
                ?>
                <tr>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm font-semibold">
                        <?php echo $row['nama_obat']; ?>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo $row['jenis_obat']; ?></td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <span class="<?php echo $row['stok'] < 10 ? 'text-red-600 font-bold' : 'text-gray-900'; ?>">
                            <?php echo $row['stok']; ?>
                        </span>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">Rp
                        <?php echo number_format($row['harga'], 0, ',', '.'); ?>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <button onclick="editObat(<?php echo htmlspecialchars(json_encode($row)); ?>)"
                            class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                        <a href="data_obat.php?delete=<?php echo $row['id_obat']; ?>"
                            onclick="return confirm('Hapus obat ini?')" class="text-red-600 hover:text-red-900">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Modal Form -->
<div id="modalObat" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <h3 id="modalTitle" class="text-lg font-medium text-gray-900 mb-4">Tambah Obat</h3>
        <form method="POST">
            <input type="hidden" name="id_obat" id="id_obat">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Obat</label>
                <input type="text" name="nama_obat" id="nama_obat"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Jenis</label>
                <input type="text" name="jenis_obat" id="jenis_obat"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                    placeholder="Contoh: Tablet" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Stok</label>
                <input type="number" name="stok" id="stok"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp)</label>
                <input type="number" name="harga" id="harga"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="document.getElementById('modalObat').classList.add('hidden')"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Batal</button>
                <button type="submit" name="submit"
                    class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('modalObat').classList.remove('hidden');
        document.getElementById('modalTitle').innerText = 'Tambah Obat';
        document.getElementById('id_obat').value = '';
        document.getElementById('nama_obat').value = '';
        document.getElementById('jenis_obat').value = '';
        document.getElementById('stok').value = '';
        document.getElementById('harga').value = '';
    }

    function editObat(data) {
        document.getElementById('modalObat').classList.remove('hidden');
        document.getElementById('modalTitle').innerText = 'Edit Obat';
        document.getElementById('id_obat').value = data.id_obat;
        document.getElementById('nama_obat').value = data.nama_obat;
        document.getElementById('jenis_obat').value = data.jenis_obat;
        document.getElementById('stok').value = data.stok;
        document.getElementById('harga').value = data.harga;
    }
</script>

<?php echo "</main></div></div></body></html>"; ?>