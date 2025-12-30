<?php
session_start();
include '../sim_adhyaksa/koneksi.php';

if ($_SESSION['status'] != "login" || $_SESSION['role'] != "admin") {
    header("location:../login.php");
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Prevent deleting self
    $cek = mysqli_query($conn, "SELECT username FROM users WHERE id='$id'");
    $u = mysqli_fetch_assoc($cek);
    if ($u['username'] == $_SESSION['username']) {
        echo "<script>alert('Anda tidak bisa menghapus akun sendiri!'); window.location='manajemen_user.php';</script>";
    } else {
        mysqli_query($conn, "DELETE FROM users WHERE id='$id'");
        header("location:manajemen_user.php");
    }
}

// Handle Add/Edit
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $role = $_POST['role'];

    if ($_POST['id'] != "") {
        // Update
        $id = $_POST['id'];
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $query = "UPDATE users SET nama='$nama', username='$username', password='$password', role='$role' WHERE id='$id'";
        } else {
            $query = "UPDATE users SET nama='$nama', username='$username', role='$role' WHERE id='$id'";
        }
    } else {
        // Insert
        // Check duplicate username
        $cek = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users WHERE username='$username'"));
        if ($cek > 0) {
            echo "<script>alert('Username sudah digunakan!'); window.location='manajemen_user.php';</script>";
            exit;
        }
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $query = "INSERT INTO users (nama, username, password, role) VALUES ('$nama', '$username', '$password', '$role')";
    }

    if (mysqli_query($conn, $query)) {
        header("location:manajemen_user.php");
    } else {
        echo "<script>alert('Gagal: " . mysqli_error($conn) . "');</script>";
    }
}

$title = "Manajemen User - Klinik Adhyaksa";
include '../sim_adhyaksa/layout_header.php';
include '../sim_adhyaksa/layout_sidebar.php';
?>

<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800">Manajemen User</h1>
    <button onclick="openModal()"
        class="bg-primary-green hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-md">
        <i class="fas fa-user-plus mr-2"></i> Tambah User
    </button>
</div>

<!-- Table Data User -->
<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Nama</th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Username</th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Role</th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = mysqli_query($conn, "SELECT * FROM users ORDER BY role ASC");
            while ($row = mysqli_fetch_array($query)) {
                ?>
                <tr>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm font-semibold">
                        <?php echo $row['nama']; ?>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo $row['username']; ?></td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <span class="relative inline-block px-3 py-1 font-semibold leading-tight rounded-full 
                        <?php
                        if ($row['role'] == 'admin')
                            echo 'bg-red-200 text-red-900';
                        elseif ($row['role'] == 'dokter')
                            echo 'bg-blue-200 text-blue-900';
                        elseif ($row['role'] == 'apoteker')
                            echo 'bg-green-200 text-green-900';
                        else
                            echo 'bg-gray-200 text-gray-900';
                        ?>">
                            <span class="relative"><?php echo ucfirst($row['role']); ?></span>
                        </span>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <button onclick="editUser(<?php echo htmlspecialchars(json_encode($row)); ?>)"
                            class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                        <?php if ($row['username'] != $_SESSION['username']): ?>
                            <a href="manajemen_user.php?delete=<?php echo $row['id']; ?>"
                                onclick="return confirm('Hapus user ini?')" class="text-red-600 hover:text-red-900">Hapus</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Modal Form -->
<div id="modalUser" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <h3 id="modalTitle" class="text-lg font-medium text-gray-900 mb-4">Tambah User</h3>
        <form method="POST">
            <input type="hidden" name="id" id="id">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                <input type="text" name="nama" id="nama"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                <input type="text" name="username" id="username"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" id="password"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                    placeholder="Kosongkan jika tidak ubah password">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                <select name="role" id="role" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                    <option value="resepsionis">Resepsionis</option>
                    <option value="dokter">Dokter</option>
                    <option value="apoteker">Apoteker</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="document.getElementById('modalUser').classList.add('hidden')"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Batal</button>
                <button type="submit" name="submit"
                    class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('modalUser').classList.remove('hidden');
        document.getElementById('modalTitle').innerText = 'Tambah User';
        document.getElementById('id').value = '';
        document.getElementById('nama').value = '';
        document.getElementById('username').value = '';
        document.getElementById('password').value = '';
        document.getElementById('role').value = 'resepsionis';
    }

    function editUser(data) {
        document.getElementById('modalUser').classList.remove('hidden');
        document.getElementById('modalTitle').innerText = 'Edit User';
        document.getElementById('id').value = data.id;
        document.getElementById('nama').value = data.nama;
        document.getElementById('username').value = data.username;
        document.getElementById('password').value = ''; // Reset for security
        document.getElementById('role').value = data.role;
    }
</script>

<?php echo "</main></div></div></body></html>"; ?>