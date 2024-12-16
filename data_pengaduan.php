<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengaduan SAHABAT By User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(255, 192, 203, 0.6), rgba(255, 192, 203, 0.6)), url('img/bogor.jpeg');
            background-size: cover;
            background-position: center;
            font-family: 'Arial', sans-serif;
            overflow-x: hidden;
        }
        .container {
            margin-top: 30px;
        }
        h2 {
            color: #d63384;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5rem;
            animation: bounceIn 1s ease-in-out;
        }
        table {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .table th,
        .table td {
            vertical-align: middle;
            padding: 12px;
            text-align: center;
        }
        .table th {
            background-color: #f06292;
            color: white;
            font-weight: bold;
        }
        .table td {
            background-color: #fce4ec;
            color: #333;
        }
        .table tbody tr:nth-child(odd) {
            background-color: #f8bbd0;
        }
        .table tbody tr:hover {
            background-color: #f1c4e1;
            cursor: pointer;
            transform: scale(1.05);
            transition: 0.3s ease;
        }
        .btn-back {
            background-color: #d63384;
            color: white;
            font-weight: bold;
            border-radius: 10px;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 1.2rem;
            transition: background-color 0.3s, box-shadow 0.3s;
        }
        .btn-back:hover {
            background-color: #c72374;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }
        .text-center {
            margin-top: 20px;
        }
        /* Bouncing Animation */
        @keyframes bounceIn {
            0% { transform: translateY(-2000px); }
            60% { transform: translateY(30px); }
            80% { transform: translateY(-10px); }
            100% { transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Daftar Pengaduan Kesehatan</h2>

        <!-- Search Filter -->
        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan Nama, ID, atau Kontak..." onkeyup="searchTable()">
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Keterangan</th>
                        <th>Kontak</th>
                    </tr>
                </thead>
                <tbody>
                <?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "responsi");

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari tabel kesehatan
$sql = "SELECT * FROM kesehatan";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $name = $row['nama'];
        $latitude = $row['latitude'];
        $longitude = $row['longitude'];
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td><a href='https://www.google.com/maps?q=$latitude,$longitude' target='_blank'>$name</a></td>";
        echo "<td>" . $latitude . "</td>";
        echo "<td>" . $longitude . "</td>";
        echo "<td>" . $row['keterangan'] . "</td>";
        echo "<td>" . $row['nohp'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6' class='text-center'>Tidak ada data pengaduan.</td></tr>";
}

$conn->close();
?>

                </tbody>
            </table>
        </div>

        <!-- Modal (Popup) for More Info -->
        <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="infoModalLabel">Detail Pengaduan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="modalInfo">Informasi lebih lanjut mengenai pengaduan ini...</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            <a href="index.html" class="btn btn-back">Kembali ke Beranda</a>
        </div>
    </div>

    <!-- JavaScript for Table Search and Modal -->
    <script>
        // Search Function for Table
        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toLowerCase();
            table = document.getElementById("dataTable");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                for (var j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        }

        // Modal Popup Function (Update modal to show a narrative sentence with the data)
        document.querySelectorAll("table tbody tr").forEach(row => {
            row.addEventListener("click", function() {
                // Get the data from the clicked row
                var cells = this.getElementsByTagName("td");
                var name = cells[1].textContent;      // Nama
                var keterangan = cells[4].textContent; // Keterangan
                var kontak = cells[5].textContent;    // Kontak

                // Format the narrative sentence
                var modalContent = `${name} mengalami kendala ${keterangan}, harap hubungi di ${kontak}.`;

                // Update the modal with the formatted content
                document.getElementById("modalInfo").textContent = modalContent;

                // Show the modal
                var modal = new bootstrap.Modal(document.getElementById('infoModal'));
                modal.show();
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
