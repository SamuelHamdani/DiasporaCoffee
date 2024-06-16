<?php
    require "session.php";
    require "../koneksi.php";

    $queryProduct = mysqli_query($con, "SELECT * FROM produk");
    $jumlahProduk = mysqli_num_rows($queryProduct);
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/ad72137cd6.js" crossorigin="anonymous"></script>
    
    <!-- CSS -->
    <style>
        .summary-produk {
            background-color: #0A6B4A;
            border-radius: 15px;
        }
        a {
            text-decoration: none;
            color: white;

        }
        a:hover {
            color: blue;
            transition: ease 1s;
        }
    </style>
</head>
<body>
    <?php require "navbar.php";?>
    <div class="container mt-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                <i class="fa-solid fa-house"></i> Home
                </li>
            </ol>
        </nav>

        <h1>Halo <?php echo $_SESSION['username']?></h1>

        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-4 summary-produk p-3">
                    <div class="row">
                        <div class="col-6">
                        <i class="fa-solid fa-bars fa-7x text-black-50"></i>
                        </div>
                        <div class="col-6 text-white">
                            <h3 class="fs-3">Product</h3>
                            <p class="fs-5">
                                <?php 
                                    if ($jumlahProduk > 0) {
                                        echo $jumlahProduk;
                                    } else {
                                        echo "<p>Tidak ada";
                                    }
                                ?> Produk</p>
                            <p><a href="produk.php" >Lihat Detail</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>