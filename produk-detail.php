<?php
    require "koneksi.php";

    $nama = htmlspecialchars($_GET['nama']);
    $queryProduk = mysqli_query($con,"SELECT * FROM product WHERE nama='$nama'");
    $produk = mysqli_fetch_array($queryProduk);

    $queryProdukTerkait = mysqli_query($con,"SELECT * FROM product WHERE kategori_id='$produk[kategori_id]' AND id!='$produk[id]' LIMIT 4");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Product</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php"; ?>

    <!-- detail produk -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mb-5">
                    <img src="image/<?php echo $produk['foto']; ?>" class="w-100" alt="">
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <h1><?php echo $produk['nama']; ?></h1>
                    <p class=fs-6>
                        <?php echo $produk['detail']; ?>
                    </p>
                    <p class="fs-3 text-harga">
                        $<?php echo $produk['harga']; ?>
                    </p>
                    <p class="fs-5">Status : <strong><?php echo $produk['ketersediaan_stok'] ?></strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Product -->
    <div class="container-fluid py-5 warna2">
        <div class="container">
            <h2 class="text-center text-white mb-5">Related Products</h2>

            <div class="row">
                <?php while ($data=mysqli_fetch_array($queryProdukTerkait)) { ?>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="produk-detail.php?nama=<?php echo $data['nama']; ?>">
                        <img src="image/<?php echo $data['foto']; ?>" alt="" class="img-fluid img-thumbnail produk-terkait-image">
                        </a>
                    </div>
                <?php } ?>
                </div>
        </div>
    </div>

    <!-- footer -->
    <?php require "footer.php"; ?>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>