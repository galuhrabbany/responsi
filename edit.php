<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "responsi");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data berdasarkan ID
$id = $_GET['id'];
$sql = "SELECT * FROM kesehatan WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "Data tidak ditemukan!";
    exit;
}

// Proses update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];
    $keterangan = $_POST["keterangan"];
    $nohp = $_POST["nohp"];

    $sql = "UPDATE kesehatan SET nama = ?, latitude = ?, longitude = ?, keterangan = ?, nohp = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $nama, $latitude, $longitude, $keterangan, $nohp, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='home.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat memperbarui data.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Lokasi Kesehatan</title>
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
        <h3>Edit Data Lokasi Kesehatan</h3>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" class="form-control" id="latitude" name="latitude" value="<?= htmlspecialchars($data['latitude']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" class="form-control" id="longitude" name="longitude" value="<?= htmlspecialchars($data['longitude']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required><?= htmlspecialchars($data['keterangan']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="nohp" class="form-label">Kontak</label>
                <input type="text" class="form-control" id="nohp" name="nohp" value="<?= htmlspecialchars($data['nohp']) ?>" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-custom">Simpan Perubahan</button>
                <a href="home.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
        <p class="text-muted">Pastikan semua informasi yang dimasukkan sudah benar sebelum menyimpan perubahan.</p>
    </div>
</body>
</html>
