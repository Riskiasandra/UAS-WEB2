<?php
// Memulai sesi
session_start();

// Koneksi ke database
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'kelasjahit';

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Ambil data kelas dari tabel
$query = "SELECT id_kelas, nama_kelas FROM kelas";
$result = $conn->query($query);

// Siapkan array untuk kelas
$kelas_options = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $kelas_options[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran Kelas Jahit</title>
    <style>
        /* Gaya CSS */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding-top: 100px; /* Memberikan jarak pada bagian atas */
            padding-bottom: 200px; /* Memberikan jarak pada bagian bawah */
        }

        .container {
            width: 90%;
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 18px;
        }

        header {
            text-align: center;
            padding: 15px 0;
            background: #00796b;
            color: #fff;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        h1 {
            font-size: 24px;
            margin: 0;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 14px; /* Ukuran font label lebih kecil */
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px; /* Mengurangi padding */
            margin: 2px 0; /* Mengurangi jarak antar elemen */
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            height: 30px; /* Membuat kolom lebih pendek */
        }

        .form-group input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #00796b;
            color: white;
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 3px;
            transition: background-color 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .form-group input[type="submit"]:hover {
            background-color: #00796b;
        }

        .form-group {
            display: flex;
            align-items: center;
            justify-content: center; /* Mengatur agar tombol "Daftar" terlihat penuh */
            height: 40px; /* Mengatur tinggi tombol */
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Formulir Pendaftaran Kelas Jahit</h1>
        </header>

        <form action="proses_pendaftaran.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat" required>
            </div>
            <div class="form-group">
                <label for="telepon">Nomor Telepon</label>
                <input type="tel" id="telepon" name="telepon" required>
            </div>
            <div class="form-group">
                <label for="keahlian">Keahlian</label>
                <input type="text" id="keahlian" name="keahlian" required>
            </div>
            <div class="form-group">
                <label for="hasil_karya">Hasil Karya</label>
                <textarea id="hasil_karya" name="hasil_karya" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="foto_diri">Foto Diri</label>
                <input type="file" id="foto_diri" name="foto_diri" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="kelas">Kelas</label>
                <select id="nama_kelas" name="id_kelas" required>
                    <option value="">-- Pilih kelas --</option>
                    <?php foreach ($kelas_options as $kelas): ?>
                        <option value="<?= htmlspecialchars($kelas['id_kelas']); ?>">
                            <?= htmlspecialchars($kelas['nama_kelas']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" value="Daftar">
            </div>
        </form>
    </div>
</body>
</html>