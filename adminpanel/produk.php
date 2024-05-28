<?php
    require "session.php";
    require "../koneksi.php";

    $query = mysqli_query($con,"SELECT a.*, b.nama AS nama_kategori FROM product a JOIN kategori b ON a.kategori_id=b.id");
    $jumlahProduk = mysqli_num_rows($query);

    $queryKategori = mysqli_query($con,"SELECT * FROM kategori");

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <style>
        .no-decoration {
            text-decoration: none;
        }
        form div {
            margin-bottom: 10px;
        }
        .alert {
            margin-top: 20px;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table th {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .table td {
            background-color: rgba(255, 255, 255, 0.05);
        }
        .btn-info {
            color: #fff;
        }
        .background-image {
            background-size: cover;
            background-position: center;
            background: linear-gradient(rgba(0,0,0,0.4),rgba(0,0,0,0.4)), url('../image/background-image-admin.jpg');
        }
    </style>
</head>
<body class="background-image text-white">
    <?php require "navbar.php"; ?>

    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb text-white">
                <li class="breadcrumb-item">
                    <a href="../adminpanel" class="no-decoration text-white">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active text-white" aria-current="page">Product</li>
            </ol>
        </nav>

        <!-- Tambah Produk -->
        <div class="my-5 col-12 col-md-6">
            <h3>Add Product</h3>

            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Product Name</label>
                    <input type="text" id="nama" name="nama" required placeholder="Input Product Name" class="form-control" autocomplete="off">
                </div>
                <div>
                    <label for="kategori">Category</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php while ($data = mysqli_fetch_array($queryKategori)) { ?>
                            <option value="<?php echo $data['id']; ?>"><?php echo $data['nama']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <label for="harga">Price</label>
                    <input type="number" name="harga" class="form-control" placeholder="$0" required>
                </div>
                <div>
                    <label for="foto">Photo</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div>
                    <label for="detail">Description</label>
                    <textarea name="detail" id="detail" class="form-control" placeholder="Add your Description..."></textarea>
                </div>
                <div>
                    <label for="ketersediaan_stok">Product Status</label>
                    <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                        <option value="tersedia">Ready</option>
                        <option value="habis">Empty</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary" name="simpan">Save</button>
                </div>
            </form>

            <?php
                if (isset($_POST['simpan'])) {
                    $nama = htmlspecialchars($_POST['nama']);
                    $kategori = htmlspecialchars($_POST['kategori']);
                    $harga = htmlspecialchars($_POST['harga']);
                    $detail = htmlspecialchars($_POST['detail']);
                    $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);

                    $target_dir = "../image/";
                    $nama_file = basename($_FILES["foto"]["name"]);
                    $target_file = $target_dir . $nama_file;
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    $image_size = $_FILES["foto"]["size"];
                    $random_name = generateRandomString(20);
                    $new_name = $random_name . "." . $imageFileType;

                    if ($nama == '' || $kategori == '' || $harga == '') {
                        echo '<div class="alert alert-warning mt-3" role="alert">Product Name, Category, and Price are required.</div>';
                    } else {
                        if ($nama_file != '') {
                            if ($image_size > 500000) {
                                echo '<div class="alert alert-warning mt-3" role="alert">File maximum size is 500 Kb.</div>';
                            } else {
                                if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'gif' && $imageFileType != 'jpeg') {
                                    echo '<div class="alert alert-warning mt-3" role="alert">File type must be .jpg, .png, .gif.</div>';
                                } else {
                                    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                                }
                            }
                        }

                        $queryTambah = mysqli_query($con, "INSERT INTO product (kategori_id, nama, harga, foto, detail, ketersediaan_stok)
                            VALUES ('$kategori', '$nama', '$harga', '$new_name', '$detail', '$ketersediaan_stok')");

                        if ($queryTambah) {
                            echo '<div class="alert alert-primary mt-3" role="alert">Success, Product added.</div>';
                            echo '<meta http-equiv="refresh" content="0; url=produk.php">';
                        } else {
                            echo mysqli_error($con);
                        }
                    }
                }
            ?>
        </div>

        <div class="mt-3 mb-5">
            <h2>Products List</h2>

            <div class="table-responsive mt-5">
                <table class="table text-white">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Product Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($jumlahProduk == 0) { ?>
                            <tr>
                                <td colspan="6" class="text-center">There's nothing on Product</td>
                            </tr>
                        <?php } else {
                            $number = 1;
                            while ($data = mysqli_fetch_array($query)) { ?>
                                <tr>
                                    <td><?php echo $number; ?></td>
                                    <td><?php echo $data['nama']; ?></td>
                                    <td><?php echo $data['nama_kategori']; ?></td>
                                    <td>$<?php echo $data['harga']; ?></td>
                                    <td><?php echo $data['ketersediaan_stok']; ?></td>
                                    <td>
                                        <a href="produk-detail.php?c=<?php echo $data['id']; ?>" class="btn btn-info">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php $number++;
                            }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
