<?php
session_start();
if (!isset($_SESSION['id_siswa'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard CompLearn</title>

    <style>
        html {
            scroll-behavior: smooth;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #ffffff;
        }

        /* HEADER BIRU */
        .header {
            background: #2957D1;
            padding: 35px 20px 60px 20px;
            color: white;
            text-align: left;
            position: relative;
        }

        .header .top {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
        }

        .header .top img {
            width: 45px;
        }

        .header h1 {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .header-img {
            width: 420px;
            position: absolute;
            right: -5px;
            bottom: 0;
            object-fit: cover;
        }

        .btn-header {
            display: inline-block;
            background: white;
            color: black;
            padding: 10px 20px;
            border-radius: 8px;
            margin-top: 25px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        /* SECTION PUTIH */
        .section {
            padding: 40px 20px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 22px;
            font-weight: 600;
        }

        /* LANGKAH */
        .steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            justify-content: center;
        }

        .step-box {
            background: #F8F8F8;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            transition: transform 0.3s;
        }

        .step-box:hover {
            transform: translateY(-5px);
        }

        .step-box img {
            width: 45px;
            margin-bottom: 10px;
        }

        .step-box p {
            font-size: 14px;
            margin-top: 5px;
        }

        /* PERBAIKAN GAMBAR TATA CARA 3 & 4 */
.steps .step-box:nth-child(3) img {
    width: 70px !important;      
    margin-top: 10px !important;
}

.steps .step-box:nth-child(3) p {
    margin-top: 0px !important;     /* teks dinaikkan (lebih rapat ke gambar) */
    display: block !important;      /* memastikan margin bekerja */
}

.steps .step-box:nth-child(4) img {
    width: 70px !important;
    margin-top: 10px !important;
}

        /* GAMBAR SEKOLAH */
        .school-img {
            width: 100%;
            margin: 40px 0 20px 0;
            border-radius: 12px;
        }

        /* PROFIL SEKOLAH */
        .content-box {
            padding: 20px;
            line-height: 1.7;
        }

        .content-box h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .content-box p,
        .content-box li {
            font-size: 14px;
            margin-bottom: 10px;
            text-align: justify;
        }

        /* KELAS */
        .kelas-container {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .kelas-box {
            width: 230px;
            border-radius: 16px;
            padding: 20px;
            color: white;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .kelas-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
        }

        .kelas-top {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .kelas-box h4 {
            font-size: 20px;
            margin: 0;
        }

        .kelas-icon {
            width: 40px;
            height: auto;
        }

        .kelas-btn {
            background: white;
            color: black;
            padding: 10px 0;
            width: 100%;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            margin-top: 10px;
            cursor: pointer;
        }

        .kelas-10 { background: #4CC8B4; }
        .kelas-11 { background: #7A77EE; }
        .kelas-12 { background: #F2A23A; }

        /* HIGHLIGHT EFFECT */
        .highlight {
            animation: highlightAnim 2s ease forwards;
        }

        @keyframes highlightAnim {
            0% { box-shadow: 0 0 0px 0 rgba(255,255,0,0); }
            50% { box-shadow: 0 0 20px 5px rgba(255,255,0,0.7); }
            100% { box-shadow: 0 0 0px 0 rgba(255,255,0,0); }
        }

        /* FOOTER */
        .footer {
            background: #2957D1;
            color: white;
            text-align: center;
            padding: 25px 10px;
            margin-top: 40px;
        }
        /* === PERBAIKAN SEJAJAR KELAS 10, 11, 12 (TEMPATKAN DI PALING BAWAH) === */

.kelas-container {
    display: flex !important;
    justify-content: center !important;
    align-items: stretch !important;    /* semua kotak sama tinggi */
    gap: 25px !important;
    flex-wrap: nowrap !important;       /* supaya tetap sejajar 1 baris */
}

.kelas-box {
    width: 260px !important;            /* buat ukurannya seragam */
    min-height: 170px !important;       /* tingginya disamakan */
    display: flex !important;
    flex-direction: column !important;
    justify-content: flex-start !important;
    align-items: center !important;
    padding: 25px !important;
}

/* bagian atas diseragamkan */
.kelas-top {
    height: 75px !important;            /* tinggi fixed agar icon + teks sejajar */
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 10px !important;
}

.kelas-top h4 {
    margin: 0 !important;
    padding: 0 !important;
    font-size: 20px !important;
}

.kelas-top img.kelas-icon {
    width: 45px !important;
    height: auto !important;
}

/* tombol tetap rapi */
.kelas-btn {
    margin-top: 12px !important;
}

/* ===== FIX FINAL KELAS 10 (FORCE OVERRIDE) ===== */
.kelas-container .kelas-box.kelas-10 {
    height: 190px !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: space-between !important;
    align-items: center !important;
    padding: 25px !important;
}

/* posisi judul + icon */
.kelas-container .kelas-box.kelas-10 .kelas-top {
    height: 90px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 12px !important;
}

/* judul */
.kelas-container .kelas-box.kelas-10 h4 {
    font-size: 22px !important;
    margin: 0 !important;
}

/* icon */
.kelas-container .kelas-box.kelas-10 img {
    width: 48px !important;
}

/* tombol */
.kelas-container .kelas-box.kelas-10 .kelas-btn {
    margin-top: 0 !important;
    margin-bottom: 5px !important;
}


    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="header">
        <div class="top">
            <img src="husodo logo.png" alt="Logo Sekolah">
            <span style="font-size:20px; font-weight:600;">CompLearn</span>
        </div>

        <h1>Selamat Datang Di Website CompLearn</h1>
        <p>Platform Pembelajaran Online SMK Bhakti Adi Husodo</p>
        <p style="margin-top:8px; font-weight:600;">Halo, <?php echo htmlspecialchars(
            isset($_SESSION['nama_siswa']) ? $_SESSION['nama_siswa'] : 'Pengguna'
        ); ?></p>

        <a class="btn-header" href="#kelas">Lihat Kelas</a>
        <a class="btn-header" href="logout.php" style="margin-left:10px;">Logout</a>

        <img src="foto 1.png" class="header-img" alt="Foto Header">
    </div>

    <!-- TATA CARA -->
    <div class="section">
        <div class="section-title">Tata Cara Penggunaan Website</div>
        <div class="steps">
            <div class="step-box">
                <img src="foto 2.png">
                <p><b>1. Buat akun</b><br>Daftar dengan menggunakan email dan membuat password.</p>
            </div>
            <div class="step-box">
                <img src="foto 3.png">
                <p><b>2. Login</b><br>Masukan username dan password yang sudah didaftarkan.</p>
            </div>
            <div class="step-box">
                <img src="foto 4.png">
                <p><b>3. Pilih kelas sesuai tingkat Anda</b><br>Kelas 10, kelas 11, kelas 12.</p>
            </div>
            <div class="step-box">
                <img src="foto 5.png">
                <p><b>4. Mulai belajar</b><br>Buka materi, video pembelajaran, rangkuman, dan kuis.</p>
            </div>
        </div>
    </div>

    <!-- FOTO SEKOLAH -->
    <img src="sekolah husodo.jpg" class="school-img" alt="Gedung Sekolah">

    <!-- PROFIL SEKOLAH -->
    <div class="content-box">
        <h3>Profil Sekolah SMK Bhakti Adi Husodo</h3>
        <p>SMKS Farmasi Bhakti Adi Husodo adalah sekolah menengah kejuruan swasta
yang berfokus pada bidang Farmasi, berlokasi di Jl. Raya Bayongbong KM. 10 
Saung Cendol Garut, Kabupaten Garut, Jawa Barat. Berdiri sejak 2009, sekolah
ini telah memperoleh Akreditasi B berdasarkan SK No. 058/BAN-SM/SK/2019
pada tanggal 21 Januari 2019.
     Sekolah ini berkomitmen mencetak tenaga kefarmasian tingkat menengah
yang terampil, berkarakter, dan beretika. Pembelajaran dilakukan dengan 
pendekatan teori  dan praktik secara seimbang agar siswa mampu menguasai
kompetensi yang dibutuhkan di dunia kesehatan. 
     SMKS Farmasi Bhakti Adi Husodo juga terus meningkatkan sarana 
pembelajaran, menjalin kerja sama dengan fasilitas kesehatan, serta melatih
kedisiplinan dan profesionalisme siswa sebagai bekal menghadapi dunia kerja.
</p>

        <h3>Visi Sekolah</h3>
        <p>“Menjadi lembaga pendidikan kejuruan bidang farmasi yang unggul, 
berkarakter, dan mampu menghasilkan lulusan profesional serta 
siap bersaing di dunia kesehatan.”</p>

        <h3>Misi Sekolah</h3>
        <ol>
            <li>Menyelenggarakan pembelajaran sesuai standar industri kesehatan.</li>
            <li>Mengembangkan keterampilan praktik siswa melalui laboratorium dan kerja sama dengan dunia usaha dan dunia industri (DUDI).</li>
            <li>Membentuk karakter disiplin, jujur, dan bertanggung jawab pada peserta didik.</li>
            <li>Meningkatkan kualitas tenaga pendidik dan sarana pembelajaran.</li>
            <li>Mendorong siswa untuk aktif dalam kegiatan akademik maupun non-akademik.</li>
        </ol>
    </div>

    <!-- PILIHAN KELAS -->
    <div id="kelas" class="section">
        <div class="section-title">Pilihan Kelas</div>
        <div class="kelas-container">

            <div class="kelas-box kelas-10" id="kelas10">
    <div class="kelas-top">
        <h4>Kelas 10</h4>
        <img src="foto 6.png" class="kelas-icon">
    </div>
    <a href="#kelas10" class="kelas-btn">Lihat Materi</a>
</div>


            <div class="kelas-box kelas-11" id="kelas11">
                <div class="kelas-top">
                    <h4>Kelas 11</h4>
                    <img src="foto 8.png" class="kelas-icon">
                </div>
                <a href="#kelas11" class="kelas-btn">Lihat Materi</a>
            </div>

            <div class="kelas-box kelas-12" id="kelas12">
                <div class="kelas-top">
                    <h4>Kelas 12</h4>
                    <img src="foto 7.png" class="kelas-icon">
                </div>
                <a href="kelas 12.html" class="kelas-btn page-link">Lihat Materi</a>
            </div>

        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <b>CompLearn</b><br>
        Platform pembelajaran online SMK Bhakti Adi Husodo
        <br><br>
        © Mahasiswi Pendidikan Teknologi Informasi IPI Garut<br>
        <b>Siti Sumiyati</b>, <b>Wifa Siti Hadiani</b>
    </div>

   <script>
document.querySelectorAll('.kelas-btn').forEach(btn => {
    btn.addEventListener('click', function (e) {

        // JIKA tombol halaman baru → JANGAN dicegah
        if (this.classList.contains('page-link')) {
            return; // BIARKAN PINDAH HALAMAN
        }

        // selain itu (scroll)
        e.preventDefault();
        const targetId = this.getAttribute('href');
        const target = document.querySelector(targetId);

        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'center' });
            target.classList.add('highlight');
            setTimeout(() => {
                target.classList.remove('highlight');
            }, 2000);
        }
    });
});
</script>

   
</body>
</html>
