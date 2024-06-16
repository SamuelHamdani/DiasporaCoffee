<?php
    require "session.php";
    require "../koneksi.php";

    $queryProduk = mysqli_query($con, "SELECT * FROM produk");
    $jumlahProduk = mysqli_num_rows($queryProduk);

    function generateRandomString($length = 10) {
        $characters = '01234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
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
    <title>Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/ad72137cd6.js" crossorigin="anonymous"></script>
</head>

<style>
    .no-decoration {
        text-decoration: none;
    }
    .stock-dropdown {
        margin: 10px 0;
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
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="namaProduk">Nama</label>
                    <input type="text" id="namaProduk" name="namaProduk" placeholder="Masukkan Nama Produk" class="form-control" autocomplete=off required>

                    <label for="harga">Harga</label>
                    <input type="number" id="harga" name="harga" placeholder="Harga Produk" class="form-control" autocomplete=off required>

                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">

                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows = "3" class="form-control"></textarea>
                </div>
                <div class="stock-dropdown">
                    <label for="stok">Stok Produk</label>
                    <select name="stok" id="stok" class="form-control">
                        <option value="Tersedia">Tersedia</option>
                        <option value="Habis">Habis</option>
                    </select>
                </div>
                <div class="mt-3">
                    <button class="btn-btn-primary" type="submit" name="simpan">Simpan</button>
                </div>            
            </form>

            <?php
            if(isset($_POST['simpan'])) {
                $nama = htmlspecialchars($_POST['namaProduk']);
                $harga = htmlspecialchars($_POST['harga']);
                $detail = htmlspecialchars($_POST['detail']);
                $stok = htmlspecialchars($_POST['stok']);

                $target_dir = "../image/";
                $img_name = basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $img_name;
                $imgFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                $img_size = $_FILES["foto"]["size"];
                $random_name = generateRandomString(20);
                $new_name = $random_name . "." . $imgFileType;

                $queryExist = mysqli_query($con, "SELECT * FROM produk WHERE nama ='$nama'");
                $jumlahDataProdukBaru = mysqli_num_rows($queryExist);

                if ($nama=='' || $harga=='') {
                    ?>
                    <div class="alert alert-warning mt-3" role="alert">Nama Dan Harga Tidak Boleh Kosong</div>
                    <?php
                }
                else {
                    if($img_name!='') {
                        if($img_size > 500000) {
                            ?>
                             <div class="alert alert-warning mt-3" role="alert">Ukuran foto tidak boleh lebih dari 500kb</div>
                            <?php
                        }
                        else {
                            if($imgFileType != 'jpg' && $imgFileType != 'png' && $imgFileType != 'gif') {
                                ?>
                                <div class="alert alert-warning mt-3" role="alert">Format file harus .jpg/.png/.gif</div>
                                <?php
                            }
                            else {
                                move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                            }
                        }
                    }

                    //  Query Insert
                    if($jumlahDataProdukBaru > 0) {
                        ?>
                        <div class="alert alert-warning mt-3" role="alert">Produk Sudah Tersedia</div>
                        <?php
                    }
                    else {
                        $querySimpan = mysqli_query($con, "INSERT INTO produk (nama, harga, foto, detail, stok) VALUES ('$nama', '$harga', '$new_name', '$detail', '$stok')");
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
                            <th>Harga</th>
                            <th>Stok</th>
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
                                <td><?php echo $data['harga']; ?></td>
                                <td><?php echo $data['stok']; ?></td>
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