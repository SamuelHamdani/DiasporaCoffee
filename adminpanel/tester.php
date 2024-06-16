<?php
    require "session.php";
    require "../koneksi.php";

    $queryProduk = mysqli_query($con, "SELECT * FROM produk");
    $jumlahProduk = mysqli_num_rows($queryProduk);
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/ad72137cd6.js" crossorigin="anonymous"></script>
</head>

<style>
    .no-decoration {
        text-decoration: none;
    }
</style>

<body>
    <?php require "navbar.php";?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel" class="no-decoration text-muted">
                        <i class="fa-solid fa-house"></i>Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Produk
                </li>
            </ol>
        </nav>

        <!-- Tambah Produk -->
        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Produk</h3>
            <form action="" method="post">
                <div>
                    <label for="produk">Produk</label>
                    <input type="text" id="produk" name="produk" placeholder="Masukkan Nama Produk" class="form-control">
                </div>
                <div class="mt-3">
                    <button class="btn-btn-primary" type="submit" name="simpan">Simpan</button>
                </div>            
            </form>

            <?php
            if(isset($_POST['simpan'])) {
                $produk = htmlspecialchars($_POST['produk']);

                $queryExist = mysqli_query($con, "SELECT * FROM produk WHERE nama ='$produk'");
                $jumlahDataProdukBaru = mysqli_num_rows($queryExist);

                if($jumlahDataProdukBaru > 0) {
                    ?>
                    <div class="alert alert-warning mt-3" role="alert">Produk Sudah Tersedia</div>
                    <?php
                }
                else {
                    $querySimpan = mysqli_query($con, "INSERT INTO produk (nama) VALUES ('$produk')");
                    if($querySimpan) {
                        ?>
                        <div class="alert alert-primary mt-3" role="alert">Produk Tersimpan</div>

                        <meta http-equiv="refresh" content="1; url=produk.php" />
                        <?php
                    }
                    else {
                        echo mysqli_error($con);
                    }
                }
            }
            ?>
        </div>

        <!-- Tabel Produk -->
        <div class="mt-3">
            <h2>List Produk</h2>

            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($jumlahProduk == 0) {
                        ?>
                            <tr>
                                <td colspan = 3 class="text-center">Data Produk Tidak Tersedia</td>
                            </tr>
                        <?php
                            }
                            else {
                                $jumlah = 1;
                                while ($data=mysqli_fetch_array($queryProduk)) {
                        ?>
                            <tr>
                                <td><?php echo $jumlah; ?></td>
                                <td><?php echo $data['nama']; ?></td>
                                <td>
                                    <a href="produk-detail.php?id=<?php echo $data['id']; ?>" class="btn btn-info">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                                $jumlah++;
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>