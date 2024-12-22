<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Kelas Jahit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: #f0f0f0;
            width: 80%;
            max-width: 800px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: calc(90vh - 100px);
        }
        h1 {
            background-color: #00796b;
            color: white;
            text-align: center;
            padding: 15px;
            margin: 0;
            border-radius: 8px 8px 0 0;
            height: 60px;
        }
        .class-list {
            flex: 1;
            padding: 20px;
        }
        .class-card {
            background-color: #e0f7fa;
            margin-bottom: 10px;
            border-radius: 4px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .class-card h3 {
            margin: 0;
            color: #00796b;
        }
        .class-card p {
            margin: 5px 0;
            color: #00796b;
        }
        .class-card button {
            background-color: #ff5722;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
        }
        .class-card button:hover {
            background-color: #e64a19;
        }
        .footer {
            background-color: #ffffff;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
        }
        .footer button {
            background-color: #00796b;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 4px;
        }
        .footer button:hover {
            background-color: #004d40;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Pendaftaran Kelas Jahit</h1>
    <div class="class-list">
        <?php
        // Memanggil koneksi dari file koneksi.php
        require 'koneksi.php';

        // Query untuk mengambil data kelas
        $query = "SELECT id_kelas, nama_kelas, harga, waktu_belajar FROM kelas";
        $result = mysqli_query($conn, $query);

        // Mengecek apakah ada data yang ditemukan
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='class-card'>
                        <div>
                            <h3>" . htmlspecialchars($row['nama_kelas']) . "</h3>
                            <p>Harga: Rp. " . number_format($row['harga'], 2, ',', '.') . "</p>
                            <p>Waktu Belajar: " . htmlspecialchars($row['waktu_belajar']) . "</p>
                        </div>
                        <button onclick=\"window.location.href='form_daftar.php?id_kelas=" . $row['id_kelas'] . "'\">Daftar</button>
                      </div>";
            }
        } else {
            echo "<p>Tidak ada data yang tersedia di tabel kelas.</p>";
        }

        // Menutup koneksi database
        mysqli_close($conn);
        ?>
    </div>
    <div class="footer">
        <button onclick="location.href='admin_dashboard.php'">Admin</button>
        <button onclick="location.href='pimpinan_dashboard.php'">Pimpinan</button>
    </div>
</div>

</body>
</html>