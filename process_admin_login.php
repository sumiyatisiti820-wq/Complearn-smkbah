<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: admin_login.php');
    exit();
}

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Cari admin di tabel `admin`
$stmt = $conn->prepare('SELECT id_admin, nama, email, password FROM admin WHERE email = ? LIMIT 1');
if (!$stmt) {
    $_SESSION['error_admin'] = 'Kesalahan server: ' . $conn->error;
    header('Location: admin_login.php');
    exit();
}

$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        session_regenerate_id(true);
        $_SESSION['id_admin'] = $row['id_admin'];
        $_SESSION['nama_admin'] = $row['nama'];
        $_SESSION['email_admin'] = $row['email'];
        $_SESSION['role'] = 'admin';

        $stmt->close();
        header('Location: admin_dashboard.php');
        exit();
    }
}

$stmt->close();
$_SESSION['error_admin'] = 'Email atau password admin salah.';
header('Location: admin_login.php');
exit();
