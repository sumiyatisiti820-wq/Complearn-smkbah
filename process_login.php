<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Prepared statement untuk keamanan (cek status aktif)
    $stmt = $conn->prepare('SELECT id_siswa, nama_lengkap, email, password, kelas, status FROM siswa WHERE email = ? LIMIT 1');
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();

            if (($row['status'] ?? 'nonaktif') !== 'aktif') {
                $_SESSION['error'] = 'Akun Anda belum aktif. Hubungi admin.';
                header('Location: login.php');
                exit();
            }

            if (password_verify($password, $row['password'])) {
                // Login berhasil — tingkatkan keamanan session
                session_regenerate_id(true);
                $_SESSION['id_siswa'] = $row['id_siswa'];
                $_SESSION['nama_siswa'] = $row['nama_lengkap'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['kelas'] = $row['kelas'];
                $_SESSION['role'] = 'siswa';

                header('Location: dashboard.php');
                exit();
            } else {
                $_SESSION['error'] = 'Password salah!';
                header('Location: login.php');
                exit();
            }
        } else {
            $_SESSION['error'] = 'Email tidak ditemukan!';
            header('Location: login.php');
            exit();
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = 'Terjadi kesalahan pada server.';
        header('Location: login.php');
        exit();
    }
}
?>