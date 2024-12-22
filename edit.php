<?php
// Menghubungkan dengan file koneksi.php
include 'koneksi.php';

// Mendapatkan `id_pendaftaran` dari formulir atau URL
$id_pendaftaran = isset($_POST['id_pendaftaran']) ? $_POST['id_pendaftaran'] : null;

if (!$id_pendaftaran) {
    die("ID pendaftaran tidak ditemukan.");
}

// Mengambil data pendaftaran berdasarkan ID
$query = "SELECT * FROM pendaftaran WHERE id_pendaftaran = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_pendaftaran);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
} else {
    die("Data pendaftaran tidak ditemukan.");
}

// Menangani update data saat formulir disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $keahlian = $_POST['keahlian'];

    $updateQuery = "UPDATE pendaftaran SET nama = ?, email = ?, tanggal_lahir = ?, alamat = ?, telepon = ?, keahlian = ? WHERE id_pendaftaran = ?";
    $updateStmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($updateStmt, "ssssssi", $nama, $email, $tanggal_lahir, $alamat, $telepon, $keahlian, $id_pendaftaran);

    if (mysqli_stmt_execute($updateStmt)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href = 'admin_dashboard.php';</script>";
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pendaftaran</title>
    <style>
        form {
            width: 50%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="email"], input[type="date"], textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .btn-back {
            background-color: #ccc;
            color: black;
            text-decoration: none;
            padding: 10px 20px;
            display: inline-block;
            border-radius: 4px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <form method="post" action="">
        <h2>Edit Data Pendaftaran</h2>
        <input type="hidden" name="id_pendaftaran" value="<?php echo htmlspecialchars($id_pendaftaran); ?>">

        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($data['email']); ?>" required>

        <label for="tanggal_lahir">Tanggal Lahir:</label>
        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="<?php echo htmlspecialchars($data['tanggal_lahir']); ?>" required>

        <label for="alamat">Alamat:</label>
        <textarea name="alamat" id="alamat" required><?php echo htmlspecialchars($data['alamat']); ?></textarea>

        <label for="telepon">Telepon:</label>
        <input type="text" name="telepon" id="telepon" value="<?php echo htmlspecialchars($data['telepon']); ?>" required>

        <label for="keahlian">Keahlian:</label>
        <input type="text" name="keahlian" id="keahlian" value="<?php echo htmlspecialchars($data['keahlian']); ?>">

        <button type="submit" name="update">Update</button>
        <a href="admin_dashboard.php" class="btn-back">Kembali</a>
    </form>
</body>
</html>
