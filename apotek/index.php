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
// Only show those with status_obat = 'Menunggu' (or NULL for backward compatibility)
$query_resep = mysqli_query($conn, "
    SELECT rekam_medis.*, pasien.nama_pasien, pasien.no_rm, users.nama as nama_dokter 
    FROM rekam_medis 
    JOIN pasien ON rekam_medis.id_pasien = pasien.id_pasien
    JOIN users ON rekam_medis.id_dokter = users.id
    WHERE rekam_medis.tanggal = CURDATE() AND (rekam_medis.status_obat = 'Menunggu' OR rekam_medis.status_obat IS NULL)
    ORDER BY rekam_medis.id_rm DESC
");

// Get Medicine List for Dropdown
$obat_list = [];
$q_obat = mysqli_query($conn, "SELECT id_obat, nama_obat, stok FROM obat ORDER BY nama_obat ASC");
while ($o = mysqli_fetch_assoc($q_obat)) {
    $obat_list[] = $o;
}
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
            Tidak ada resep baru yang belum diproses.
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
                    <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded">Menunggu
                        Obat</span>
                </div>

                <div class="bg-gray-50 p-4 rounded border border-gray-200 mb-4">
                    <h4 class="font-semibold text-gray-700 mb-2">Catatan Dokter:</h4>
                    <p class="whitespace-pre-line text-gray-800 italic"><?php echo $r['resep']; ?></p>
                </div>

                <div class="flex justify-end">
                    <button
                        onclick="openModal('<?php echo $r['id_rm']; ?>', '<?php echo addslashes($r['nama_pasien']); ?>')"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                        <i class="fas fa-mortar-pestle mr-2"></i> Proses & Ambil Obat
                    </button>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<!-- Modal Proses Resep -->
<div id="modalProses" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-900">Proses Obat: <span id="modalPasienName"></span></h3>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>

        <form action="proses_resep.php" method="POST">
            <input type="hidden" name="id_rm" id="modalIdRm">

            <div id="obatContainer" class="space-y-3 mb-4 max-h-96 overflow-y-auto p-2">
                <!-- Rows will be added here -->
            </div>

            <button type="button" onclick="addObatRow()"
                class="text-blue-600 hover:text-blue-800 font-bold text-sm mb-4">
                <i class="fas fa-plus-circle"></i> Tambah Obat Lain
            </button>

            <div class="flex justify-end pt-4 border-t">
                <button type="button" onclick="closeModal()"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">Batal</button>
                <button type="submit" name="proses_resep"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Selesai & Kurangi Stok
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const obatList = <?php echo json_encode($obat_list); ?>;

    function openModal(idRm, namaPasien) {
        document.getElementById('modalIdRm').value = idRm;
        document.getElementById('modalPasienName').innerText = namaPasien;
        document.getElementById('obatContainer').innerHTML = ''; // Clear previous
        addObatRow(); // Add first row
        document.getElementById('modalProses').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalProses').classList.add('hidden');
    }

    function addObatRow() {
        const container = document.getElementById('obatContainer');
        const div = document.createElement('div');
        div.className = "flex gap-4 items-center bg-gray-50 p-3 rounded border";

        let options = '<option value="">-- Pilih Obat --</option>';
        obatList.forEach(obat => {
            options += `<option value="${obat.id_obat}">${obat.nama_obat} (Stok: ${obat.stok})</option>`;
        });

        div.innerHTML = `
            <div class="flex-1">
                <select name="id_obat[]" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    ${options}
                </select>
            </div>
            <div class="w-24">
                <input type="number" name="qty[]" placeholder="Jml" min="1" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(div);
    }
</script>

<?php echo "</main></div></div></body></html>"; ?>