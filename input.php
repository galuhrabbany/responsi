<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Kesehatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9e3ed;
            font-family: Arial, sans-serif;
            color: #333;
        }
        .container {
            margin-top: 60px;
            max-width: 600px;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            border: 3px solid #ffb6c1;
        }
        h3 {
            color: #d63384;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            color: #d63384;
            font-weight: 500;
        }
        .form-control {
            border: 2px solid #ffb6c1;
            border-radius: 10px;
        }
        .form-control:focus {
            border-color: #d63384;
            box-shadow: 0 0 5px rgba(214, 51, 132, 0.3);
        }
        .btn-custom {
            background-color: #d63384;
            color: #fff;
            font-weight: bold;
            border-radius: 10px;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #c72374;
        }
        .btn-secondary {
            border-radius: 10px;
            padding: 10px 20px;
        }
        .text-muted {
            font-size: 0.9em;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Input Pengaduan Kesehatan</h3>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" class="form-control" id="latitude" name="latitude" required>
            </div>
            <div class="mb-3">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" class="form-control" id="longitude" name="longitude" required>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="nohp" class="form-label">Kontak</label>
                <input type="text" class="form-control" id="nohp" name="nohp" required>
            </div>
            <div class="text-center">
                <button type="submit" name="submit" class="btn btn-custom">Simpan Data</button>
                <a href="home.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
        <p class="text-muted">Pastikan semua informasi yang dimasukkan sudah benar sebelum menyimpan data.</p>
    </div>
</body>
</html>

<?php
// Proses Input Data ke Database
if (isset($_POST['submit'])) {
    // Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "responsi";

    // Buat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Ambil data dari form
    $nama = $_POST['nama'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $keterangan = $_POST['keterangan'];
    $nohp = $_POST['nohp'];

    // SQL untuk memasukkan data
    $sql = "INSERT INTO kesehatan (nama, latitude, longitude, keterangan, nohp) 
            VALUES ('$nama', '$latitude', '$longitude', '$keterangan', '$nohp')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil disimpan!'); window.location.href='home.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Tutup koneksi
    $conn->close();
}
?>
