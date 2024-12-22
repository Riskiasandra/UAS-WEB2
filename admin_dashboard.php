<?php
// Menghubungkan dengan file koneksi.php
include 'koneksi.php';

// Mendapatkan nilai pencarian dari URL jika ada
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Membuat kueri pencarian
$query = "SELECT * FROM pendaftaran";
if (!empty($search)) {
    $query .= " WHERE nama LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' OR email LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
}
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Pendaftaran</title>
    <style>
        /* Desain Tabel Sederhana */
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
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        /* Desain Tombol */
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            cursor: pointer;
            border-radius: 0.25rem;
            margin: 0.2rem;
            text-align: center;
            display: inline-block;
            text-decoration: none;
            color: #fff;
        }
        .btn-warning {
            background-color: #ffc107;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-sm {
            font-size: 0.875rem;
            padding: 0.25rem 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Admin Dashboard - Pendaftaran</h1>

        <!-- Form pencarian -->
        <form action="admin_dashboard.php" method="get" class="mb-3">
            <input type="text" name="search" placeholder="Cari pendaftaran..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Cari</button>
        </form>

        <!-- Tabel Pendaftaran -->
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
                    <th>Kelas</th>
                    <th>Aksi</th>
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
                    <td><img src="<?php echo htmlspecialchars($row['foto_diri']); ?>" alt="Foto Diri" style="max-width: 100px;"></td>
                    <td><?php echo htmlspecialchars($row['id_kelas']); ?></td>
                    <td>
                        <!-- Tombol Edit -->
                        <form action="edit.php" method="post">
                            <input type="hidden" name="id_pendaftaran" value="<?php echo htmlspecialchars($row['id_pendaftaran']); ?>">
                            <button type="submit" class="btn btn-warning btn-sm">Edit</button>
                        </form>
                        <!-- Tombol Hapus -->
                        <button class="btn btn-danger btn-sm delete-btn" data-id="<?php echo htmlspecialchars($row['id_pendaftaran']); ?>">Hapus</button>
                    </td>
                </tr>
                <?php
                    endwhile;
                else :
                ?>
                <tr>
                    <td colspan="10" class="text-center">Tidak ada data pendaftar yang ditemukan.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Menangani tombol Hapus
            document.querySelectorAll('.delete-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    var id_pendaftaran = this.getAttribute('data-id');
                    if (confirm('Yakin ingin menghapus?')) {
                        window.location.href = 'hapus.php?id_pendaftaran=' + id_pendaftaran;
                    }
                });
            });
        });
    </script>
</body>
</html>