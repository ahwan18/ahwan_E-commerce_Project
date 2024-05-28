<?php
    require "session.php";
    require "../koneksi.php";

    $id = $_GET['c'];

    $query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM product a JOIN kategori b ON a.kategori_id=b.id WHERE a.id='$id'");
    $data = mysqli_fetch_array($query);

    $queryKategori = mysqli_query($con, "SELECT * FROM kategori WHERE id!='$data[kategori_id]'");

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
    <title>Product Detail</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <style>
        form div {
            margin-bottom: 10px;
        }
        .background-image {
            background-size: cover;
            background-position: center;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('../image/background-image-admin.jpg');
        }
    </style>
</head>
<body class="background-image text-white">
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <h2>Product Detail</h2>

        <div class="col-md-6 col-12 mb-5">
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Product Name</label>
                    <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required placeholder="Input Product Name" class="form-control" autocomplete="off">
                </div>

                <div>
                    <label for="kategori">Category</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="<?php echo $data['kategori_id']; ?>"><?php echo htmlspecialchars($data['nama_kategori']); ?></option>
                        <?php while ($dataKategori = mysqli_fetch_array($queryKategori)) { ?>
                            <option value="<?php echo $dataKategori['id']; ?>"><?php echo htmlspecialchars($dataKategori['nama']); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <label for="harga">Price</label>
                    <input type="number" name="harga" value="<?php echo $data['harga']; ?>" class="form-control" placeholder="$0" required>
                </div>
                <div>
                    <label for="currentFoto">Current Photo</label>
                    <img src="../image/<?php echo $data['foto']; ?>" alt="" width="100px">
                </div>
                <div>
                    <label for="foto">Photo</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div>
                    <label for="detail">Description</label>
                    <textarea name="detail" id="detail" class="form-control" placeholder="Add your Description..."><?php echo htmlspecialchars($data['detail']); ?></textarea>
                </div>
                <div>
                    <label for="ketersediaan_stok">Product Status</label>
                    <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                        <option value="<?php echo $data['ketersediaan_stok']; ?>"><?php echo ucfirst($data['ketersediaan_stok']); ?></option>
                        <?php if ($data['ketersediaan_stok'] == 'tersedia') { ?>
                            <option value="habis">Habis</option>
                        <?php } else { ?>
                            <option value="tersedia">Tersedia</option>
                        <?php } ?>
                    </select>        
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="simpan">Save</button>
                    <button type="submit" class="btn btn-danger" name="hapus">Delete</button>
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
                        $queryUpdate = mysqli_query($con, "UPDATE product SET kategori_id='$kategori', nama='$nama', harga='$harga', detail='$detail', ketersediaan_stok='$ketersediaan_stok' WHERE id='$id'");

                        if ($nama_file != '') {
                            if ($image_size > 5000000) {
                                echo '<div class="alert alert-warning mt-3" role="alert">File Maximum Size is 5000 KB.</div>';
                            } else {
                                if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'gif' && $imageFileType != 'jpeg') {
                                    echo '<div class="alert alert-warning mt-3" role="alert">File type must be .jpg/.png/.gif.</div>';
                                } else {
                                    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);

                                    $queryUpdate = mysqli_query($con, "UPDATE product SET foto='$new_name' WHERE id='$id'");

                                    if ($queryUpdate) {
                                        echo '<div class="alert alert-primary mt-3" role="alert">Product Update Succeeded.</div>';
                                        echo '<meta http-equiv="refresh" content="0; url=produk.php" />';
                                    }
                                }
                            }
                        } else {
                            if ($queryUpdate) {
                                echo '<div class="alert alert-primary mt-3" role="alert">Product Update Succeeded.</div>';
                                echo '<meta http-equiv="refresh" content="0; url=produk.php" />';
                            }
                        }
                    }
                }

                if (isset($_POST['hapus'])) {
                    $queryHapus = mysqli_query($con, "DELETE FROM product WHERE id='$id'");

                    if ($queryHapus) {
                        echo '<div class="alert alert-primary mt-3" role="alert">Product Delete Succeeded.</div>';
                        echo '<meta http-equiv="refresh" content="0; url=produk.php" />';
                    }
                }
            ?>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
