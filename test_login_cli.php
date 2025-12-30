<?php
// Mocking session and post data
$_SESSION = [];
$_POST['username'] = 'admin';
$_POST['password'] = 'admin123';

echo "Testing login with: admin / admin123\n";

include 'sim_adhyaksa/koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

echo "Querying for user: $username\n";
$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

$cek = mysqli_num_rows($query);
echo "Users found: $cek\n";

if ($cek > 0) {
    $row = mysqli_fetch_assoc($query);
    echo "User found in DB. Hash: " . substr($row['password'], 0, 10) . "...\n";

    if (password_verify($password, $row['password'])) {
        echo "Password Match! Login SUCCESS.\n";
        echo "Role: " . $row['role'] . "\n";
    } else {
        echo "Password Mismatch! Login FAILED.\n";
    }
} else {
    echo "User not found.\n";
}
?>