<?php
// Menghubungkan dengan file koneksi.php
include 'koneksi.php';

// Mendapatkan data dari database
$query = "SELECT * FROM pendaftaran";
$result = mysqli_query($conn, $query);

// Fungsi untuk membuat laporan dalam format CSV
if (isset($_GET['download'])) {
    $filename = "laporan_pendaftaran_" . date("Ymd") . ".csv";
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$filename");
    header("Content-Type: application/csv; ");

    // Membuka output stream
    $output = fopen("php://output", "w");

    // Menuliskan header kolom
    $header = ["Nama", "Email", "Tanggal Lahir", "Alamat", "Telepon", "Keahlian", "Hasil Karya", "Foto Diri", "ID Kelas"];
    fputcsv($output, $header);

    // Menuliskan data dari database ke file CSV
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data = [
                $row['nama'],
                $row['email'],
                $row['tanggal_lahir'],
                $row['alamat'],
                $row['telepon'],
                $row['keahlian'],
                $row['hasil_karya'],
                $row['foto_diri'],
                $row['id_kelas']
            ];
            fputcsv($output, $data);
        }
    }

    fclose($output);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pimpinan Dashboard</title>
    <style>
        /* Desain Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 0.5rem;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        /* Tombol */
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            cursor: pointer;
            border-radius: 0.25rem;
            margin: 0.2rem;
            text-align: center;
            text-decoration: none;
            color: #fff;
        }
        .btn-download {
            background-color: #28a745;
        }
        .btn-print {
            background-color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pimpinan Dashboard</h1>
        <div class="actions">
            <!-- Tombol untuk Download -->
            <a href="pimpinan_dashboard.php?download=true" class="btn btn-download">Download Laporan</a>
            <!-- Tombol untuk Cetak -->
            <button class="btn btn-print" onclick="window.print()">Cetak Laporan</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Keahlian</th>
                    <th>Hasil Karya</th>
                    <th>Foto Diri</th>
                    <th>ID Kelas</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && mysqli_num_rows($result) > 0) :
                    while ($row = mysqli_fetch_assoc($result)) :
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['tanggal_lahir']); ?></td>
                    <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                    <td><?php echo htmlspecialchars($row['telepon']); ?></td>
                    <td><?php echo htmlspecialchars($row['keahlian']); ?></td>
                    <td><?php echo htmlspecialchars($row['hasil_karya']); ?></td>
                    <td>
                        <img src="<?php echo htmlspecialchars($row['foto_diri']); ?>" alt="Foto Diri" style="max-width: 100px;">
                    </td>
                    <td><?php echo htmlspecialchars($row['id_kelas']); ?></td>
                </tr>
                <?php
                    endwhile;
                else :
                ?>
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data pendaftar yang ditemukan.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>