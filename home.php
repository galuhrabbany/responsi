<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAHABAT: Pengaduan Kesehatan Kota Bogor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Include Chart.js -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-image: url('img/bogor.jpeg');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            color: #333;
        }

        .navbar {
            background-color: rgba(255, 179, 198, 0.9);
            /* Warna awal */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar:hover {
            background-color: rgba(255, 179, 198, 1);
            /* Warna hover lebih pekat */
        }

        .navbar .navbar-brand,
        .navbar .btn-custom {
            color: #fff;
            /* Warna teks putih */
            font-weight: 600;
            transition: color 0.3s ease, background-color 0.3s ease;
        }

        .navbar:hover .navbar-brand,
        .navbar:hover .btn-custom {
            color: #fff;
            /* Tetap putih saat hover */
        }

        .btn-custom {
            background-color: #FFB3C6;
            border: none;
        }

        .btn-custom:hover {
            background-color: #f798cf;
            color: #fff;
            /* Warna teks tetap putih */
        }

        #container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 15px;
            margin-top: 20px;
        }

        #table-container,
        #map-container,
        #chart-container {
            background-color: #FFFFFF;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            padding: 15px;
        }

        #map {
            height: 500px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        #chart {
            height: 400px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        .table {
            margin-bottom: 0;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table thead {
            background-color: #FFB3C6;
            color: #fff;
        }

        .table tbody tr:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }

        .btn-action {
            border-radius: 30px;
            font-size: 0.85rem;
            padding: 8px 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        footer {
            text-align: center;
            padding: 15px;
            color: #FF4D73;
            font-size: 0.85rem;
            margin-top: 20px;
            background-color: rgba(255, 255, 255, 0.85);
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Membuat Map dan Chart sejajar */
        #map-container,
        #chart-container {
            background-color: #FFFFFF;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            padding: 15px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .row {
            display: flex;
            gap: 15px;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .column {
            flex: 1;
            min-width: 300px;
            /* Pastikan lebar kolom tetap minimal */
        }

        /* Responsif - memastikan peta dan chart memiliki tinggi yang proporsional */
        #map,
        #chart {
            width: 100%;
            /* Membuat peta dan chart mengisi ruang kolom */
            border-radius: 10px;
        }

        #map {
            height: 100%;
            max-height: 60vh;
            /* Maksimal tinggi 60% dari layar */
        }

        #chart {
            height: 100%;
            max-height: 50vh;
            /* Maksimal tinggi 50% dari layar */
        }

        /* Agar lebih responsif, pastikan peta dan chart bisa disesuaikan dalam kolom */
        @media (max-width: 768px) {
            .row {
                flex-direction: column;
            }

            #map {
                max-height: 50vh;
                /* Untuk layar kecil, map bisa lebih kecil */
            }

            #chart {
                max-height: 40vh;
                /* Chart sedikit lebih kecil */
            }
        }


        /* Menambahkan beberapa efek hover untuk elemen lain */
        .table tbody tr:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }

        /* Styling untuk button custom */
        .btn-custom {
            background-color: #FFB3C6;
            /* Warna latar belakang awal */
            border: none;
            color: #fff;
            /* Warna teks putih */
            font-weight: bold;
            /* Teks lebih tebal */
            font-size: 1rem;
            /* Ukuran font lebih besar */
            padding: 12px 24px;
            /* Memberikan padding lebih besar untuk tombol */
            border-radius: 25px;
            /* Menjaga tombol agar lebih bulat */
            text-align: center;
            /* Menjaga teks di tengah */
            transition: all 0.3s ease;
            /* Transisi yang lebih halus */
            display: inline-block;
            /* Memastikan tombol tidak mengganggu layout */
            cursor: pointer;
            /* Mengubah cursor menjadi pointer saat hover */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            /* Menambahkan sedikit bayangan */
        }

        /* Hover efek pada tombol */
        .btn-custom:hover {
            background-color: #f798cf;
            /* Warna lebih terang saat hover */
            color: #fff;
            /* Teks tetap putih saat hover */
            transform: translateY(-2px);
            /* Efek angkat sedikit */
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
            /* Bayangan lebih kuat */
        }

        /* Fokus untuk tombol */
        .btn-custom:focus {
            outline: none;
            /* Menghapus outline default pada fokus */
            box-shadow: 0 0 5px 2px rgba(255, 179, 198, 0.7);
            /* Bayangan saat fokus */
        }


        /* Health Announcement Section */
        #health-announcement-container ul li {
            border-left: 4px solid #FF4D73;
            padding-left: 15px;
            margin-bottom: 10px;
        }

        #health-announcement-container h5 {
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-light">
        <div class="container-fluid d-flex justify-content-between">
            <a class="navbar-brand" href="index.html">
                <img src="icon/bogor.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                SAHABAT: Sistem Aduan Kesehatan Bogor Tanggap
            </a>
            <div class="d-flex">
                <!-- Input Data Button -->
                <a class="btn btn-custom me-2" href="input.php" role="button">Input Data</a>
                <!-- About Button -->
                <button class="btn btn-custom" id="aboutButton">About</button>
            </div>
        </div>
    </nav>

    <!-- Collapsible About Section -->
    <div class="container mt-3" id="aboutSection" style="display:none;">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-body text-center">
                <h5 class="card-title text-primary mb-3">About the Developer</h5>
                <p class="card-text">This web application was developed by <strong>Galuh Ayu Cita Rabbany</strong>.</p>

                <!-- Profile Picture and Instagram Link -->
                <div>
                    <a href="https://www.instagram.com/galuhrabbany" target="_blank">
                        <img src="img/galuh.jpg" alt="Galuh Ayu Cita Rabbany" class="img-fluid rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                    </a>
                </div>

                <p>Contact: <a href="mailto:galuhrabbany@gmail.com" class="text-decoration-none text-info">galuhrabbany@gmail.com</a></p>
            </div>
        </div>
    </div>



    <div id="container" class="container-fluid">
        <!-- Tabel Data -->
        <div id="table-container">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Keterangan</th>
                        <th>Kontak</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "responsi");
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $sql = "SELECT * FROM kesehatan";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><a href='https://www.google.com/maps?q=" . $row['latitude'] . "," . $row['longitude'] . "' target='_blank'>" . htmlspecialchars($row["nama"]) . "</a></td>";
                            echo "<td>" . htmlspecialchars($row["latitude"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["longitude"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["keterangan"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["nohp"]) . "</td>";
                            echo "<td>
                            <div class='d-flex justify-content-center'>
                                <a href='edit.php?id=" . $row["id"] . "' class='btn btn-outline-success btn-action me-2'>Edit</a>
                                <a href='delete.php?id=" . $row["id"] . "' class='btn btn-outline-danger btn-action' onclick=\"return confirm('Hapus data ini?')\">Delete</a>
                            </div>
                        </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Map and Chart Section in a row -->
        <div class="row">
            <div class="column" id="map-container">
                <div id="map"></div>
            </div>
            <div class="column" id="chart-container">
                <h5>Distribusi Rumah Sakit per Wilayah Kota Bogor Menurut Data BPS</h5>
                <canvas id="chart"></canvas> <!-- Chart will be rendered here -->
            </div>
        </div>

        <!-- List of Hospitals in Bogor -->
        <div id="hospital-list-container" class="mt-4">
            <h5 class="text-center" style="color: #f07bb7; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">
                Daftar Rumah Sakit di Bogor Berdasarkan Kecamatan
            </h5>
            <!-- Bogor Utara -->
            <h6 class="text-danger">Bogor Utara</h6>
            <ul class="list-group mb-3">
                <li class="list-group-item">RS Islam Bogor</li>
                <li class="list-group-item">RS Hermina Bogor</li>
            </ul>

            <!-- Bogor Selatan -->
            <h6 class="text-danger">Bogor Selatan</h6>
            <ul class="list-group mb-3">
                <li class="list-group-item">RS Bhakti Yudha</li>
                <li class="list-group-item">RS Al-Islam Bogor</li>
            </ul>

            <!-- Bogor Tengah -->
            <h6 class="text-danger">Bogor Tengah</h6>
            <ul class="list-group mb-3">
                <li class="list-group-item">RSUD Kota Bogor</li>
                <li class="list-group-item">RS Salak Bogor</li>
            </ul>

            <!-- Bogor Timur -->
            <h6 class="text-danger">Bogor Timur</h6>
            <ul class="list-group mb-3">
                <li class="list-group-item">RS Mitra Keluarga Bogor</li>
                <li class="list-group-item">RS Emma</li>
            </ul>

            <!-- Bogor Barat -->
            <h6 class="text-danger">Bogor Barat</h6>
            <ul class="list-group mb-3">
                <li class="list-group-item">RSU Bogor</li>
                <li class="list-group-item">RS Karya Bhakti Bogor</li>
            </ul>

            <!-- Tanah Sareal -->
            <h6 class="text-danger">Tanah Sareal</h6>
            <ul class="list-group mb-3">
                <li class="list-group-item">RS Siloam Bogor</li>
                <li class="list-group-item">RS TMC Bogor</li>
            </ul>

            <!-- Ciawi -->
            <h6 class="text-danger">Ciawi</h6>
            <ul class="list-group mb-3">
                <li class="list-group-item">RSUD Ciawi</li>
                <li class="list-group-item">RS Ciawi Medika</li>
            </ul>

            <!-- Cijeruk -->
            <h6 class="text-danger">Cijeruk</h6>
            <ul class="list-group mb-3">
                <li class="list-group-item">RSUD Cileungsi</li>
            </ul>

            <!-- Ciomas -->
            <h6 class="text-danger">Ciomas</h6>
            <ul class="list-group mb-3">
                <li class="list-group-item">Klinik Asri Medika Ciomas</li>
                <li class="list-group-item">Klinik Pelita Sehat Ciomas</li>
            </ul>

            <!-- Bojonggede -->
            <h6 class="text-danger">Bojonggede</h6>
            <ul class="list-group mb-3">
                <li class="list-group-item">RS Harapan Sehati</li>
                <li class="list-group-item">RS Citama</li>
            </ul>

            <!-- Sukaraja -->
            <h6 class="text-danger">Sukaraja</h6>
            <ul class="list-group mb-3">
                <li class="list-group-item">RS FMC Bogor</li>
                <li class="list-group-item">RS Yonkes</li>
            </ul>

            <!-- Kemang -->
            <h6 class="text-danger">Kemang</h6>
            <ul class="list-group mb-3">
                <li class="list-group-item">RS Kemang Medika</li>
            </ul>

            <!-- Caringin -->
            <h6 class="text-danger">Caringin</h6>
            <ul class="list-group mb-3">
                <li class="list-group-item">RS Amanda Caringin</li>
            </ul>

            <!-- Dramaga -->
            <h6 class="text-danger">Dramaga</h6>
            <ul class="list-group mb-3">
                <li class="list-group-item">RS Medika Dramaga</li>
            </ul>
        </div>

        <!-- Health Announcement Section -->
        <div id="health-announcement-container" class="mt-4">
            <h5>Pengumuman Kesehatan</h5>
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Hari Kesehatan Nasional 2024</strong><br>
                    Dinas Kesehatan Kota Bogor meningkatkan deteksi dini penyakit dengan program skrining kesehatan serta pengendalian penyakit menular, termasuk program TBC.
                </li>
                <li class="list-group-item">
                    <strong>Penghargaan Baznas Kota Bogor</strong><br>
                    Baznas Kota Bogor mendapat penghargaan atas program Jaminan Kesehatan Masyarakat, yang mencakup layanan kesehatan gratis dan pengentasan stunting.
                </li>
            </ul>
        </div>

        <footer>
            <p>&copy; 2024 SAHABAT Sistem Aduan Kesehatan Bogor Tanggap</p>
        </footer>
    </div>

    <!-- Bootstrap JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNyU45VjhHTFCt2tC3YBmbR5lmUpJgZopzJDeO1QK0xUnfGF6" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Initialize the map
        var map = L.map('map').setView([-6.5895, 106.7894], 13); // Coordinates for Bogor

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Load the rumahsakit.geojson file
        fetch('data/rumahsakit.geojson')
            .then(response => response.json())
            .then(data => {
                // Define a custom icon for hospitals
                const hospitalIcon = L.icon({
                    iconUrl: 'icon/rs.png', // Path ke file ikon rumah sakit
                    iconSize: [32, 32], // Ukuran ikon [lebar, tinggi]
                    iconAnchor: [16, 32], // Titik jangkar (center bawah)
                    popupAnchor: [0, -28] // Posisi popup relatif terhadap ikon
                });

                // Add GeoJSON data for hospitals with custom icons and popup
                L.geoJSON(data, {
                    pointToLayer: (feature, latlng) => {
                        // Use the custom icon for each hospital point
                        return L.marker(latlng, {
                            icon: hospitalIcon
                        });
                    },
                    onEachFeature: (feature, layer) => {
                        // Add a popup showing hospital name and additional properties
                        if (feature.properties && feature.properties.nama_rs) {
                            layer.bindPopup(`<strong>Nama Rumah Sakit:</strong> ${feature.properties.nama_rs}<br>
                    <strong>Alamat:</strong> ${feature.properties.Alamat || 'Tidak tersedia'}`);
                        }
                    }
                }).addTo(map); // Add to the map instance
            })
            .catch(error => console.error('Error loading GeoJSON:', error));


        // Load the jalanbogor.geojson file
        fetch('data/jalanbogor.geojson') // Pastikan path ini benar
            .then(response => response.json())
            .then(data => {
                // Define a dynamic styling function based on 'REMARK'
                function getRoadStyle(remark) {
                    const styles = {
                        'Jalan Lokal': {
                            color: '#f21818',
                            weight: 2.5,
                            opacity: 0.8
                        }, // Oranye untuk Jalan Lokal
                        'Jalan Kolektor': {
                            color: '#0000ff',
                            weight: 3,
                            opacity: 0.8
                        }, // Biru untuk Jalan Kolektor
                        'Jalan Setapak': {
                            color: '#800080',
                            weight: 1.5,
                            opacity: 0.8
                        },
                        'Jalan Lain': {
                            color: '#63ff4a',
                            weight: 2,
                            opacity: 0.8
                        }
                    };
                    // Default style if 'REMARK' is undefined or not in styles
                    return styles[remark] || {
                        color: '#ffb54a',
                        weight: 1,
                        opacity: 0.6
                    }; // Merah sebagai default
                }

                // Add GeoJSON data to the map with dynamic styling
                L.geoJSON(data, {
                    style: feature => getRoadStyle(feature.properties.REMARK),
                    onEachFeature: (feature, layer) => {
                        // Add a popup to show the road type
                        if (feature.properties && feature.properties.REMARK) {
                            layer.bindPopup(`<strong>Jenis Jalan:</strong> ${feature.properties.REMARK}`);
                        }
                    }
                }).addTo(map);
            })
            .catch(error => console.error('Error loading GeoJSON:', error));



        fetch('data/bogorarea.geojson')
            .then(response => response.json())
            .then(data => {
                // Define a color scale function based on WADMKC
                function getColorByWADMKC(wadmkc) {
                    const colors = {
                        'Bogor Tengah': '#ff99cd', // Light Pink
                        'Bogor Utara': '#ffd9e6', // Pinkish White
                        'Bogor Timur': '#ffcce6', // Pale Pink
                        'Bogor Selatan': '#ffb3d9', // Deeper Pink
                        'Bogor Barat': '#ff99b3', // Rose
                        'Tanahsareal': '#ff80aa', // Hot Pink
                        'Ciawi': '#ff85c6', // Soft Pink
                        'Cijeruk': '#ffa3d0', // Muted Pink
                        'Ciomas': '#ff8fb3', // Coral Pink
                        'Bojonggede': '#ffa6cc', // Candy Pink
                        'Sukaraja': '#ffc2d9', // Soft Peach Pink
                        'Kemang': '#ffadc2', // Blush Pink
                        'Caringin': '#ff99a6', // Salmon Pink
                        'Dramaga': '#ff6fa3' // Raspberry Pink
                    };
                    return colors[wadmkc] || '#cccccc'; // Default light gray for undefined areas
                }

                // Define a function to handle popups
                function onEachFeature(feature, layer) {
                    if (feature.properties && feature.properties.WADMKC) {
                        layer.bindPopup(`<strong>Kecamatan:</strong> ${feature.properties.WADMKC}`);
                    }
                }

                // Add GeoJSON data (polygon areas) for bogorarea
                L.geoJSON(data, {
                    style: feature => ({
                        color: '#666666', // Polygon border color
                        weight: 2, // Border weight
                        opacity: 0.7, // Border opacity
                        fillColor: getColorByWADMKC(feature.properties.WADMKC), // Fill color based on WADMKC
                        fillOpacity: 0.7 // Fill opacity
                    }),
                    onEachFeature: onEachFeature // Attach popup to each feature
                }).addTo(map);
            })
            .catch(error => console.error('Error loading bogorarea.geojson:', error));


        // Default marker (blue)
        var defaultIcon = L.icon({
            iconUrl: 'icon/icons.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        // Dynamically add markers for hospitals from the database
        <?php
        $conn = new mysqli("localhost", "root", "", "responsi");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM kesehatan";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "L.marker([{$row['latitude']}, {$row['longitude']}], {icon: defaultIcon}).addTo(map)
                    .bindPopup('<strong>{$row['nama']}</strong><br>Keterangan: {$row['keterangan']}<br>Kontak: {$row['nohp']}');\n";
            }
        } else {
            echo "console.log('No data available');\n";
        }
        $conn->close();
        ?>

        /// Initialize Chart.js for the distribution chart
        var ctx = document.getElementById('chart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    'Bogor Utara',
                    'Bogor Selatan',
                    'Bogor Tengah',
                    'Bogor Timur',
                    'Bogor Barat',
                    'Tanahsareal',
                    'Ciawi',
                    'Cijeruk',
                    'Ciomas',
                    'Bojonggede',
                    'Sukaraja',
                    'Kemang',
                    'Caringin',
                    'Dramaga'
                ], // Complete districts of Bogor
                datasets: [{
                    label: 'Jumlah Rumah Sakit',
                    data: [3, 2, 4, 4, 3, 3, 1, 1, 2, 1, 2, 1, 1, 1],
                    backgroundColor: [
                        'rgba(249, 134, 174, 0.5)', // Pink
                        'rgba(255, 195, 160, 0.5)', // Peach
                        'rgba(255, 159, 243, 0.5)', // Light Purple
                        'rgba(128, 222, 234, 0.5)', // Light Blue
                        'rgba(129, 199, 132, 0.5)', // Green
                        'rgba(255, 235, 59, 0.5)', // Yellow
                        'rgba(255, 111, 97, 0.5)', // Coral
                        'rgba(206, 147, 216, 0.5)', // Lilac
                        'rgba(100, 181, 246, 0.5)', // Sky Blue
                        'rgba(255, 241, 118, 0.5)', // Light Yellow
                        'rgba(144, 202, 249, 0.5)', // Powder Blue
                        'rgba(255, 183, 77, 0.5)', // Amber
                        'rgba(239, 83, 80, 0.5)', // Red
                        'rgba(124, 179, 66, 0.5)' // Olive Green
                    ],
                    borderColor: '#000000', // Pink for all borders
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Rumah Sakit'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Kecamatan'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });


        // Toggle About section visibility
        document.getElementById('aboutButton').addEventListener('click', function() {
            var aboutSection = document.getElementById('aboutSection');
            aboutSection.style.display = (aboutSection.style.display === 'none' || aboutSection.style.display === '') ? 'block' : 'none';
        });
    </script>

</body>

</html>