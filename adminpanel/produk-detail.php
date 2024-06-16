<?php
    require "session.php";
    require "../koneksi.php";

    $id = $_GET['id'];

    $query = mysqli_query($con, "SELECT * FROM produk WHERE id='$id'");
    $data = mysqli_fetch_array($query);     

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
    <title>Product Detail</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php require "navbar.php"?>

    <div class="container mt-5">
    <h2>Detail Produk</h2>

        <div class="col-12 col-md-6 mb-5">
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="namaProduk">Nama: </label>
                    <input type="text" name="namaProduk" id="namaProduk" class="form-control" value="<?php echo $data['nama']; ?>">

                    <label for="harga">Harga: </label>
                    <input type="number" name="harga" id="harga" class="form-control" value="<?php echo $data['harga']; ?>">

                    <label for="currentImg">Foto Sekarang:</label><br>
                    <img src="../image/<?php echo $data['foto'] ?>" alt="" width="300px"><br>

                    <label for="foto">Foto: </label>
                    <input type="file" name="foto" id="foto" class="form-control" value="<?php echo $data['foto']; ?>">

                    <label for="detail">Detail: </label>
                    <textarea name="detail" id="detail" cols="30" rows = "3" class="form-control" >
                        <?php echo $data['detail'] ?>
                    </textarea>
                </div>
                <div>
                    <label for="stok">Stok</label>
                    <select name="stok" id="id" class="form-control">
                        <option value="<?php echo $data['stok']?>"><?php echo $data['stok']?></option>
                        <?php
                            if($data['stok']=='Tersedia'){
                                ?>
                                 <option value="Habis">Habis</option>
                                <?php
                            }
                            else {
                                ?>
                                <option value="Tersedia">Tersedia</option>
                                <?php
                            }
                        ?>                       
                    </select>
                </div>

                <div class="mt-5 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="editBtn">Edit</button>
                    <button type="submit" class="btn btn-danger" name="deleteBtn">Delete</button>
                </div>
            </form>

            <?php
                // Tombol Edit
                if(isset($_POST['editBtn'])) {
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

                    if ($nama=='' || $harga=='') {
                        ?>
                        <div class="alert alert-warning mt-3" role="alert">Nama Dan Harga Tidak Boleh Kosong</div>
                        <?php
                    } else {
                        $queryUpdate = mysqli_query($con, "UPDATE produk SET nama='$nama', harga='$harga', detail='$detail', stok='$stok' WHERE id = $id");

                        if($img_name!='') {
                            if($img_size > 500000) {
                                ?>
                                <div class="alert alert-warning mt-3" role="alert">Ukuran foto tidak boleh lebih dari 500kb</div>
                                <?php
                            } else {
                                if($imgFileType != 'jpg' && $imgFileType != 'png' && $imgFileType != 'gif') {
                                    ?>
                                    <div class="alert alert-warning mt-3" role="alert">Format file harus .jpg/.png/.gif</div>
                                    <?php
                                } else {
                                    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                                }

                                $queryUpdate = mysqli_query($con, "UPDATE produk SET foto='$new_name' WHERE id=$id");
                            }
                        }
                        if($queryUpdate){
                            ?>
                            <div class="alert alert-primary mt-3" role="alert">Produk Berhasil Diubah</div>

                            <meta http-equiv="refresh" content="1; url=produk.php" />
                            <?php
                        } else {
                            echo mysqli_error($con);
                        }
                    }
                }

                // Tombol Delete
                if(isset($_POST['deleteBtn'])) {
                    $queryDelete = mysqli_query($con, "DELETE FROM produk WHERE id=$id");
                    
                    if($queryDelete){
                        ?>
                        <div class="alert alert-warning mt-3" role="alert">Produk Berhasil Dihapus</div>

                        <meta http-equiv="refresh" content="1; url=produk.php" />
                        <?php
                    }
                    else {
                        echo mysqli_error($con);
                    }
                }
            ?>
        </div>
    </div>

     <!-- Bootstrap JS -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>