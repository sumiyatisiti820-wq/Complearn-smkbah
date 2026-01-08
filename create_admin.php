<?php
/**
 * Script kecil untuk membuat tabel `admin` dan menambahkan akun admin contoh.
 * Hapus file ini setelah digunakan untuk alasan keamanan.
 */
require 'config.php';

// Buat tabel admin jika belum ada
$sql = "CREATE TABLE IF NOT EXISTS admin (
    id_admin INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) DEFAULT NULL,
    nama VARCHAR(100) DEFAULT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (!$conn->query($sql)) {
    echo "Gagal membuat tabel admin: " . $conn->error;
    exit();
}

$email = 'admin@localhost';
$existing = $conn->prepare('SELECT id_admin FROM admin WHERE email = ? LIMIT 1');
$existing->bind_param('s', $email);
$existing->execute();
$existing->store_result();
if ($existing->num_rows > 0) {
    echo "Admin dengan email $email sudah ada. Hapus create_admin.php setelah selesai.";
    exit();
}

$password_plain = 'admin123';
$password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

$ins = $conn->prepare('INSERT INTO admin (username, nama, email, password) VALUES (?, ?, ?, ?)');
$user = 'admin';
$name = 'Admin';
$ins->bind_param('ssss', $user, $name, $email, $password_hashed);
if ($ins->execute()) {
    echo "Admin berhasil dibuat. Email: $email, Password: $password_plain\n";
    echo "Hapus file create_admin.php sekarang untuk keamanan.";
} else {
    echo "Gagal membuat admin: " . $ins->error;
}
