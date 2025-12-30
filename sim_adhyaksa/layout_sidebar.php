<!-- Sidebar -->
<aside class="w-64 bg-primary-green text-white hidden md:block flex-shrink-0">
    <div class="p-6 flex items-center justify-center border-b border-green-800">
        <span class="text-xl font-bold">SIM Adhyaksa</span>
    </div>
    <nav class="mt-6">
        <!-- Role: Resepsionis -->
        <?php if ($_SESSION['role'] == 'resepsionis'): ?>
            <a href="/klinikAdhyaksa/resepsionis/index.php"
                class="block py-3 px-6 hover:bg-green-800 <?php echo (strpos($_SERVER['PHP_SELF'], 'resepsionis/index.php') !== false) ? 'sidebar-active' : ''; ?>">
                <i class="fas fa-users w-6"></i> Pendaftaran
            </a>
            <a href="/klinikAdhyaksa/resepsionis/antrian.php"
                class="block py-3 px-6 hover:bg-green-800 <?php echo (strpos($_SERVER['PHP_SELF'], 'antrian.php') !== false) ? 'sidebar-active' : ''; ?>">
                <i class="fas fa-list-ol w-6"></i> Antrian
            </a>
            <a href="/klinikAdhyaksa/resepsionis/pasien.php"
                class="block py-3 px-6 hover:bg-green-800 <?php echo (strpos($_SERVER['PHP_SELF'], 'pasien.php') !== false) ? 'sidebar-active' : ''; ?>">
                <i class="fas fa-user-injured w-6"></i> Data Pasien
            </a>
        <?php endif; ?>

        <!-- Role: Dokter -->
        <?php if ($_SESSION['role'] == 'dokter'): ?>
            <a href="/klinikAdhyaksa/dokter/index.php"
                class="block py-3 px-6 hover:bg-green-800 <?php echo (strpos($_SERVER['PHP_SELF'], 'dokter/index.php') !== false) ? 'sidebar-active' : ''; ?>">
                <i class="fas fa-stethoscope w-6"></i> Pemeriksaan
            </a>
        <?php endif; ?>

        <!-- Role: Apoteker -->
        <?php if ($_SESSION['role'] == 'apoteker'): ?>
            <a href="/klinikAdhyaksa/apotek/index.php"
                class="block py-3 px-6 hover:bg-green-800 <?php echo (strpos($_SERVER['PHP_SELF'], 'apotek/index.php') !== false) ? 'sidebar-active' : ''; ?>">
                <i class="fas fa-prescription-bottle-alt w-6"></i> Resep Masuk
            </a>
            <a href="/klinikAdhyaksa/apotek/data_obat.php"
                class="block py-3 px-6 hover:bg-green-800 <?php echo (strpos($_SERVER['PHP_SELF'], 'data_obat.php') !== false) ? 'sidebar-active' : ''; ?>">
                <i class="fas fa-medkit w-6"></i> Data Obat
            </a>
        <?php endif; ?>

        <!-- Role: Admin -->
        <?php if ($_SESSION['role'] == 'admin'): ?>
            <a href="/klinikAdhyaksa/admin/index.php"
                class="block py-3 px-6 hover:bg-green-800 <?php echo (strpos($_SERVER['PHP_SELF'], 'admin/index.php') !== false) ? 'sidebar-active' : ''; ?>">
                <i class="fas fa-tachometer-alt w-6"></i> Dashboard
            </a>
            <a href="/klinikAdhyaksa/admin/manajemen_user.php"
                class="block py-3 px-6 hover:bg-green-800 <?php echo (strpos($_SERVER['PHP_SELF'], 'manajemen_user.php') !== false) ? 'sidebar-active' : ''; ?>">
                <i class="fas fa-users-cog w-6"></i> Manajemen User
            </a>
        <?php endif; ?>

        <a href="/klinikAdhyaksa/logout.php" class="block py-3 px-6 hover:bg-red-600 mt-4">
            <i class="fas fa-sign-out-alt w-6"></i> Logout
        </a>
    </nav>
</aside>

<!-- Main Content Wrapper -->
<div class="flex-1 flex flex-col overflow-hidden">
    <!-- Top Header -->
    <header class="bg-white shadow-sm py-4 px-6 flex justify-between items-center">
        <button class="md:hidden text-gray-700">
            <i class="fas fa-bars text-xl"></i>
        </button>
        <div class="text-gray-800 font-semibold">
            Halo, <?php echo $_SESSION['username']; ?> (<?php echo ucfirst($_SESSION['role']); ?>)
        </div>
    </header>

    <!-- Content -->
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">