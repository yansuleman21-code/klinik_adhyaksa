<?php
include 'sim_adhyaksa/koneksi.php';

$doctors = [
    [
        'nama' => 'dr. Annisa S. Puspa',
        'username' => 'annisa',
        'password' => '123',
        'role' => 'dokter'
    ],
    [
        'nama' => 'dr. Muhamad Arief',
        'username' => 'arief',
        'password' => '123',
        'role' => 'dokter'
    ],
    [
        'nama' => 'drg. Devy N. Tilolango',
        'username' => 'devy',
        'password' => '123',
        'role' => 'dokter'
    ]
];

foreach ($doctors as $doc) {
    $nama = $doc['nama'];
    $username = $doc['username'];
    $password = password_hash($doc['password'], PASSWORD_DEFAULT);
    $role = $doc['role'];

    // Check if distinct username exists
    $check = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        echo "User $username already exists.\n";
    } else {
        $query = "INSERT INTO users (nama, username, password, role) VALUES ('$nama', '$username', '$password', '$role')";
        if (mysqli_query($conn, $query)) {
            echo "Created user: $nama ($username)\n";
        } else {
            echo "Error creating $username: " . mysqli_error($conn) . "\n";
        }
    }
}
?>