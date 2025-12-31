<?php
include 'sim_adhyaksa/koneksi.php';

$today = date('Y-m-d');
$username = 'dokter';

// Get current doctor ID
$u_check = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
$u = mysqli_fetch_assoc($u_check);
$current_id = $u['id'];

// Check who is ID 12 (if exists)
$old_check = mysqli_query($conn, "SELECT nama FROM users WHERE id=12");
$old_user = mysqli_fetch_assoc($old_check);
$old_name = $old_user ? $old_user['nama'] : "Unknown/Deleted";

echo "Current Doctor ($username): ID $current_id<br>";
echo "Queue assigned to ID: 12 ($old_name)<br>";

// Update 
$query = "UPDATE antrian SET id_dokter='$current_id' WHERE tanggal='$today'";
if (mysqli_query($conn, $query)) {
    echo "SUCCESS: Updated queue entries to be assigned to Dr. ID $current_id.";
} else {
    echo "Error updating queue: " . mysqli_error($conn);
}
?>