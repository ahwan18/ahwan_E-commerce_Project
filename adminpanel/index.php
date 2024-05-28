<?php
    require "session.php";
    require "../koneksi.php";

    $queryKategori = mysqli_query($con, "SELECT * FROM kategori");
    $jumlahKategori = mysqli_num_rows($queryKategori);

    $queryProduk = mysqli_query($con, "SELECT * FROM product");
    $jumlahProduk = mysqli_num_rows($queryProduk);

    // Mengambil jumlah produk berdasarkan kategori
    $queryProdukPerKategori = mysqli_query($con, "SELECT kategori.nama, COUNT(product.id) AS jumlah FROM product JOIN kategori ON product.kategori_id = kategori.id GROUP BY kategori.nama");
    $dataProdukPerKategori = [];
    while($row = mysqli_fetch_assoc($queryProdukPerKategori)) {
        $dataProdukPerKategori[] = $row;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<style>
    .kotak {
        border: solid;
    }

    .summary-box {
        border-radius: 15px;
        padding: 20px;
        color: #fff;
        margin-bottom: 20px;
    }

    .summary-kategori {
        background-color: #0a6b4a;
    }

    .summary-produk {
        background-color: #0a516b;
    }

    .summary-chart {
        background-color: #5a5c69;
    }

    .summary-icon {
        font-size: 7em;
        opacity: 0.3;
    }

    .summary-title {
        font-size: 1.5em;
    }

    .summary-details {
        font-size: 1.2em;
    }

    .no-decoration {
        text-decoration: none;
    }
    .background-image {
        background-size: cover;
        background-position: center;
        background: linear-gradient(rgba(0,0,0,0.4),rgba(0,0,0,0.4)), url('../image/background-image-admin.jpg');
    }
</style>

<body class="background-image">
    <?php require "navbar.php" ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active text-white" aria-current="page">
                    <i class="fas fa-home"></i> Home
                </li>
            </ol>
        </nav>
        <h2 class="text-white">Welcome <?php echo $_SESSION['username']; ?>,</h2>

        <div class="row mt-5">
            <div class="col-lg-4 col-md-6">
                <div class="summary-box summary-kategori">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-align-justify summary-icon"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="summary-title">Category</div>
                            <div class="summary-details"><?php echo $jumlahKategori ?> Category</div>
                            <p><a href="../adminpanel/kategori.php" class="text-white no-decoration">See Detail</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="summary-box summary-produk">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-box summary-icon"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="summary-title">Product</div>
                            <div class="summary-details"><?php echo $jumlahProduk ?> Product</div>
                            <p><a href="../adminpanel/produk.php" class="text-white no-decoration">See Detail</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="summary-box summary-chart">
                    <div class="text-center">
                        <div class="summary-title">Product Distribution</div>
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
    <script>
        // Data produk per kategori dari PHP ke JavaScript
        const dataProdukPerKategori = <?php echo json_encode($dataProdukPerKategori); ?>;
        const labels = dataProdukPerKategori.map(item => item.nama);
        const data = dataProdukPerKategori.map(item => item.jumlah);

        // Membuat diagram pie dengan Chart.js
        const ctx = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Product Distribution',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: '#fff'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Product Distribution by Category',
                        color: '#fff'
                    }
                }
            },
        });
    </script>
</body>
</html>
