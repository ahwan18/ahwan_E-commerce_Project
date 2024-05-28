<?php
    require "koneksi.php";
    $queryProduk = mysqli_query($con,"SELECT id, nama, harga, foto, detail FROM product LIMIT 6");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Project</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php"; ?>   

    <!-- banner -->
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-white text-center">
            <h1>E-Commerce Project</h1>
            <h3>What are you Search?</h3>
            <div class="col-md-8 offset-md-2">
                <form action="produk.php" method="get">
                    <div class="input-group input-group-lg my-4">
                        <input name="keyword" type="text" class="form-control" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon2">
                        <button type="submit" class="btn warna2 text-white">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- kategori highlighted -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Bestseller Categories</h3>

            <div class="row mt-5">
                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-satu d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=Games">Games</a></h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-dua d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=Chair">Chair</a></h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-tiga d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=Laptop">Laptop</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- about us -->
    <div class="container-fluid warna3 py-5">
        <div class="container text-center">
            <h3>About Us</h3>
            <p class="fs-5 mt-3">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti tempore perspiciatis amet in, temporibus hic magnam, fuga officia, similique sunt minima accusamus omnis earum! Obcaecati error nisi vero eveniet enim! Eius commodi rem cum voluptatem expedita tempora et ad, natus qui vitae esse ratione odio mollitia ullam dignissimos laboriosam sint soluta non adipisci unde iure aliquam enim rerum! Sint unde consequuntur corporis eos asperiores voluptas laborum, corrupti assumenda nulla reiciendis neque at. Rerum rem alias ipsa ex iste repellat fuga!
            </p>
        </div>
    </div>

    <!-- product -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Product</h3>

            <div class="row mt-5">
                <?php while($data = mysqli_fetch_array($queryProduk)){ ?>
                <div class="col-sm-6 col-md-4 mb-3">
                    <div class="card" style="width: 18rem;">
                        <div class="image-box">
                            <img src="image/<?php echo $data['foto']; ?>" alt="" class="card-img-top">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $data['nama']; ?></h4>
                            <p class="card-text text-truncate"><?php echo $data['detail']; ?></p>
                            <p class="card-text text-harga">$<?php echo $data['harga']; ?></p>
                            <a href="produk-detail.php?nama=<?php echo $data['nama']; ?>" class="btn warna2 text-white">See Detail</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <a class="btn btn-outline-warning mt-3" href="produk.php">See More</a>
        </div>
    </div>

    <?php require "footer.php"; ?>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>