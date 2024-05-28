<?php
    require "session.php";
    require "../koneksi.php";

    $queryKategori = mysqli_query($con, "SELECT * FROM kategori");
    $jumlahKategori = mysqli_num_rows($queryKategori);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <style>
        .no-decoration {
            text-decoration: none;
            color: white;
        }
        .breadcrumb-item a {
            color: white;
        }
        .breadcrumb-item.active {
            color: #cccccc;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .table {
            color: white;
        }
        .table th, .table td {
            border-top: none;
        }
        .table th {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .table td {
            background-color: rgba(255, 255, 255, 0.05);
        }
        .table th, .table td {
            vertical-align: middle;
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
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="../adminpanel" class="no-decoration">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active text-white" aria-current="page">Category</li>
            </ol>
        </nav>

        <div class="my-5 col-12 col-md-6">
            <h3>Add Category</h3>

            <form action="" method="post">
                <div>
                    <label for="kategori">Category</label>
                    <input type="text" id="kategori" name="kategori" placeholder="Input Category Name" class="form-control">
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit" name="simpan_kategori">Save</button>
                </div>
            </form>

            <?php
                if (isset($_POST['simpan_kategori'])) {
                    $kategori = htmlspecialchars($_POST['kategori']);

                    $queryExist = mysqli_query($con, "SELECT nama FROM kategori WHERE nama='$kategori'");
                    $jumlahDataKategoriBaru = mysqli_num_rows($queryExist);

                    if ($jumlahDataKategoriBaru > 0) {
                        echo '<div class="alert alert-warning mt-3" role="alert">Category already exists.</div>';
                    } else {
                        $querySimpan = mysqli_query($con, "INSERT INTO kategori (nama) VALUES ('$kategori')");
                        if ($querySimpan) {
                            echo '<div class="alert alert-primary mt-3" role="alert">Success, Category added.</div>';
                            echo '<meta http-equiv="refresh" content="0; url=kategori.php">';
                        } else {
                            echo mysqli_error($con);
                        }
                    }
                }
            ?>
        </div>

        <div class="mt-3">
            <h2>Categories List</h2>

            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($jumlahKategori == 0) {
                                echo '<tr><td colspan="3" class="text-center">There\'s Nothing on Category</td></tr>';
                            } else {
                                $number = 1;
                                while ($data = mysqli_fetch_array($queryKategori)) {
                                    echo '<tr>';
                                    echo '<td>' . $number . '</td>';
                                    echo '<td>' . $data['nama'] . '</td>';
                                    echo '<td><a href="kategori-detail.php?c=' . $data['id'] . '" class="btn btn-info"><i class="fas fa-search"></i></a></td>';
                                    echo '</tr>';
                                    $number++;
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
