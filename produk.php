<?php
    require "koneksi.php";

    $queryKategori = mysqli_query($con,"SELECT * FROM kategori");
    
    // get product name
    if (isset($_GET['keyword'])) {
        $queryProduk = mysqli_query($con,"SELECT * FROM product WHERE nama LIKE '%$_GET[keyword]%'");
    }
    // get product category
    else if(isset($_GET['kategori'])) {
        $queryGetKategoriId = mysqli_query($con,"SELECT id FROM kategori WHERE nama='$_GET[kategori]'");
        $kategoriId = mysqli_fetch_array($queryGetKategoriId);
        $queryProduk = mysqli_query($con,"SELECT * FROM product WHERE kategori_id='$kategoriId[id]'");
    }
    // get product default
    else {
        $queryProduk = mysqli_query($con,"SELECT * FROM product");
    }

    $countData = mysqli_num_rows($queryProduk);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php"; ?>

    <!-- banner -->
    <div class="container-fluid banner2 d-flex align-items-center">
        <div class="container">
            <h1 class="text-white text-center">Product</h1>
        </div>
    </div>

    <!-- body -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-5">
                <h3>Categories</h3>
                <ul class="list-group">
                    <?php while ($kategori = mysqli_fetch_array($queryKategori)) { ?>
                        <a class="no-decoration" href="produk.php?kategori=<?php echo $kategori['nama']; ?>">
                    <li class="list-group-item"><?php echo $kategori['nama']; ?></li>
                        </a>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-lg-9">
                <h3 class="text-center mb-3" >Product</h3>
                <div class="row">
                        <?php 
                            if($countData < 1) {
                        ?>
                                <h4 class="text-center my-5">Product Not Found</h4>
                        <?php  
                            }
                        ?>

                        <?php while ($produk = mysqli_fetch_array($queryProduk)) { ?>
                    <div class="col-md-4">
                    <div class="card" style="width: 18rem;">
                        <div class="image-box">
                            <img src="image/<?php echo $produk['foto']; ?>" alt="" class="card-img-top">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $produk['nama']; ?></h4>
                            <p class="card-text text-truncate"><?php echo $produk['detail']; ?></p>
                            <p class="card-text text-harga"><?php echo $produk['harga']; ?></p>
                            <a href="produk-detail.php?nama=<?php echo $produk['nama']; ?>" class="btn warna2 text-white">See Detail</a>
                        </div>
                    </div>
                    </div>
                        <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php require "footer.php"; ?>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>