<?php
// Include koneksi.php untuk menggunakan konfigurasi database
include 'koneksi.php';

// Verifikasi apakah tombol daftar telah ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari formulir
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $tanggal_lahir = trim($_POST['tanggal_lahir']);
    $alamat = trim($_POST['alamat']);
    $telepon = trim($_POST['telepon']);
    $keahlian = trim($_POST['keahlian']);
    $hasil_karya = trim($_POST['hasil_karya']);
    $id_kelas = $_POST['id_kelas'];
    $foto_diri = $_FILES['foto_diri'];

    // Validasi input wajib
    if (empty($nama) || empty($email) || empty($tanggal_lahir) || empty($alamat) || empty($telepon) || empty($keahlian) || empty($id_kelas) || empty($foto_diri['name'])) {
        echo "<p>Semua kolom wajib diisi. Silakan periksa kembali formulir Anda.</p>";
        echo "<a href='index.php'>Kembali ke Formulir</a>";
        exit();
    }

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p>Email tidak valid. Silakan masukkan email yang benar.</p>";
        echo "<a href='index.php'>Kembali ke Formulir</a>";
        exit();
    }

    // Validasi file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($foto_diri['name']);
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    $max_file_size = 2 * 1024 * 1024; // 2 MB

    if (!in_array($file_type, $allowed_types)) {
        echo "<p>Tipe file tidak valid. Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.</p>";
        echo "<a href='index.php'>Kembali ke Formulir</a>";
        exit();
    }

    if ($foto_diri['size'] > $max_file_size) {
        echo "<p>Ukuran file terlalu besar. Maksimal 2 MB.</p>";
        echo "<a href='index.php'>Kembali ke Formulir</a>";
        exit();
    }

    if ($foto_diri['error'] !== UPLOAD_ERR_OK) {
        echo "<p>Terjadi kesalahan saat mengunggah file. Silakan coba lagi.</p>";
        echo "<a href='index.php'>Kembali ke Formulir</a>";
        exit();
    }

    // Pindahkan file ke direktori target
    if (!move_uploaded_file($foto_diri['tmp_name'], $target_file)) {
        echo "<p>Gagal mengunggah file. Silakan coba lagi.</p>";
        echo "<a href='index.php'>Kembali ke Formulir</a>";
        exit();
    }

    // Siapkan query menggunakan prepared statement
    $sql = "INSERT INTO pendaftaran (nama, email, tanggal_lahir, alamat, telepon, keahlian, hasil_karya, foto_diri, id_kelas)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "ssssssssi", 
            $nama, 
            $email, 
            $tanggal_lahir, 
            $alamat, 
            $telepon, 
            $keahlian, 
            $hasil_karya, 
            $target_file, 
            $id_kelas
        );

        // Eksekusi query
        if ($stmt->execute()) {
            echo "<h1>Pendaftaran Berhasil</h1>";
            echo "<p>Data pendaftaran telah berhasil disimpan.</p>";
            echo "<a href='index.php'>Kembali ke Halaman Utama</a>";
        } else {
            echo "<p>Terjadi kesalahan saat menyimpan data. Silakan coba lagi.</p>";
            echo "<p>Error: " . $stmt->error . "</p>";
            echo "<a href='index.php'>Kembali ke Formulir</a>";
        }

        $stmt->close();
    } else {
        echo "<p>Terjadi kesalahan saat mempersiapkan query. Silakan coba lagi.</p>";
        echo "<p>Error: " . $conn->error . "</p>";
    }

    // Tutup koneksi
    $conn->close();
} else {
    // Redirect kembali ke halaman pendaftaran jika tidak ada data POST
    header('Location: index.php');
    exit();
}
?>