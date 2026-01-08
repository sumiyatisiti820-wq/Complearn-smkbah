<?php
/**
 * File untuk Memproses Registrasi Siswa
 */

session_start();
require 'config.php';

// Jika sudah login, arahkan pengguna
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: admin_dashboard.php');
        exit();
    } elseif ($_SESSION['role'] === 'siswa') {
        header('Location: dashboard.php');
        exit();
    }
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = isset($_POST['nim']) ? trim($_POST['nim']) : '';
    $nama_lengkap = isset($_POST['nama_lengkap']) ? trim($_POST['nama_lengkap']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $kelas = isset($_POST['kelas']) ? trim($_POST['kelas']) : '';
    $nomor_hp = isset($_POST['nomor_hp']) ? trim($_POST['nomor_hp']) : '';

    if (empty($nim) || empty($nama_lengkap) || empty($email) || empty($password)) {
        $error = "❌ Semua field harus diisi!";
    } elseif (strlen($password) < 6) {
        $error = "❌ Password harus minimal 6 karakter!";
    } else {
        // Cek apakah email atau NIM sudah terdaftar menggunakan prepared statement
        $stmt = $conn->prepare('SELECT id_siswa FROM siswa WHERE email = ? OR nim = ? LIMIT 1');
        if (!$stmt) {
            $error = 'DB Error: ' . $conn->error;
        } else {
            $stmt->bind_param('ss', $email, $nim);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $error = "❌ Email atau NIM sudah terdaftar!";
                $stmt->close();
            } else {
                $stmt->close();

                $password_hashed = password_hash($password, PASSWORD_DEFAULT);
                $status = 'aktif';

                $ins = $conn->prepare('INSERT INTO siswa (nim, nama_lengkap, email, password, kelas, nomor_hp, status) VALUES (?, ?, ?, ?, ?, ?, ?)');
                if (!$ins) {
                    $error = 'DB Error: ' . $conn->error;
                } else {
                    $ins->bind_param('sssssss', $nim, $nama_lengkap, $email, $password_hashed, $kelas, $nomor_hp, $status);
                    if ($ins->execute()) {
                        $success = "✅ Registrasi berhasil! Silakan login dengan akun Anda.";
                        $_SESSION['success'] = $success;
                        $ins->close();
                        header('Location: login.php');
                        exit();
                    } else {
                        $error = '❌ Error saat menyimpan: ' . $ins->error;
                        $ins->close();
                    }
                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - CompLearn</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #2957D1 0%, #1d3fa3 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .card {
            width: 100%;
            max-width: 500px;
            background: white;
            padding: 40px 35px;
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(0,0,0,0.2);
        }

        .card h2 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
            color: #111;
            text-align: center;
        }

        .card p {
            font-size: 14px;
            color: #666;
            margin-bottom: 25px;
            text-align: center;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .input-box {
            width: 100%;
            margin-bottom: 15px;
        }

        .input-box label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
        }

        .input-box input {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 12px;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }

        .input-box input:focus {
            border-color: #2957D1;
            box-shadow: 0 0 0 3px rgba(41, 87, 209, 0.1);
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2957D1;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
            transition: 0.3s;
        }

        button:hover {
            background: #1d3fa3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(41, 87, 209, 0.3);
        }

        .link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }

        .link a {
            color: #2957D1;
            text-decoration: none;
            font-weight: 600;
        }

        .link a:hover {
            text-decoration: underline;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .form-row .input-box {
            margin-bottom: 0;
        }

        @media (max-width: 480px) {
            .card {
                padding: 30px 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>📚 Daftar <img src="husodo logo.png" alt="CompLearn" style="height:20px; vertical-align: middle;"></h2>
        <p>Buat akun untuk memulai pembelajaran</p>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <div class="form-row">
                <div class="input-box">
                    <label>NIM / No. Induk</label>
                    <input type="text" name="nim" placeholder="Contoh: 12001" required>
                </div>
                <div class="input-box">
                    <label>Kelas</label>
                    <input type="text" name="kelas" placeholder="Contoh: 12-A" required>
                </div>
            </div>

            <div class="input-box">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="input-box">
                <label>Email</label>
                <input type="email" name="email" placeholder="Contoh: siswa@sekolah.com" required>
            </div>

            <div class="input-box">
                <label>Nomor HP (Opsional)</label>
                <input type="tel" name="nomor_hp" placeholder="Contoh: 081234567890">
            </div>

            <div class="input-box">
                <label>Password</label>
                <input type="password" name="password" placeholder="Minimal 6 karakter" required minlength="6">
            </div>

            <button type="submit">Daftar Sekarang</button>
        </form>

        <div class="link">
            Sudah punya akun? <a href="login.php">Login di sini</a>
        </div>

        <div class="link" style="margin-top: 10px; border-top: 1px solid #eee; padding-top: 15px;">
            <p style="margin-bottom: 10px; color: #666;">Ingin daftar sebagai Admin?</p>
            <a href="#" onclick="alert('Pendaftaran admin dilakukan oleh administrator. Hubungi admin untuk membuat akun.')" style="color: #9C27B0; font-weight: 600;">Daftar sebagai Admin</a>
        </div>
    </div>
</body>
</html>
