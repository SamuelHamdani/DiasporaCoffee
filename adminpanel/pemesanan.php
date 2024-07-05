<?php
require "session.php";
require "../koneksi.php";

$queryPesanan = mysqli_query($con, "SELECT * FROM pesanan");
$jumlahPesanan = mysqli_num_rows($queryPesanan);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $action = $_POST['action'];

    if ($action === 'confirm') {
        $status = 'confirmed';
    } elseif ($action === 'reject') {
        $status = 'rejected';
    }elseif ($action === 'invoice') {
        $query = "SELECT * FROM pesanan WHERE id = '$order_id'";
        $result = mysqli_query($con, $query);
        $data = mysqli_fetch_array($result);

        $nama_customer = $data['nama_pembeli'];
        $nama_produk = $data['nama_produk'];
        $jumlah = $data['jumlah'];
        $tanggal_order = $data['tanggal_order'];
        $total_harga = $data['total_harga'];
        $email = $data['email'];

        $subject = "Invoice Pemesanan di Diaspora Coffee";
        $message = "
            Halo, $nama_customer
            Terima kasih telah memesan minuman kami di diaspora coffee, semoga kamu menyukainya.
            Berikut invoice dari pesanan kamu.
            Nama pesanan : $nama_produk
            Jumlah : $jumlah
            Tanggal pembelian: $tanggal_order
            Total harga: $total_harga
            Terima kasih
        ";

        $headers = "From: samuelchristo515@gmail.com\r\n";
        $headers .= "Reply-To: " . $data['email'] . "\r\n";
        $headers.= "MIME-Version: 1.0\r\n";
        $headers.= "Content-Type: text/html; charset=UTF-8\r\n";

        mail($email, $subject, $message, $headers);

        header("Location: pemesanan.php");
        exit();
    }

    $updateQuery = "UPDATE pesanan SET status = ? WHERE id = ?";
    $stmt = $con->prepare($updateQuery);
    $stmt->bind_param("si", $status, $order_id);
    $stmt->execute();
    $stmt->close();

    header("Location: pemesanan.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/ad72137cd6.js" crossorigin="anonymous"></script>
</head>

<style>
    .no-decoration {
        text-decoration: none;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel" class="no-decoration text-muted">
                        <i class="fa-solid fa-house"></i>Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Pemesanan
                </li>
            </ol>
        </nav>

        <div class="mt-2">
            <h2>Data Pesanan</h2>

            <div class="table-responsive mt-7">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal Order</th>
                            <th>Nama Pembeli</th>
                            <th>Pesanan</th>
                            <th>Jumlah</th>
                            <th>Notelp</th>
                            <th>Email</th>
                            <th style="width: 250px;">Alamat Pembeli</th>
                            <th>Total Harga</th>
                            <th>Bukti Pembayaran</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($jumlahPesanan == 0) {
                        ?>
                            <tr>
                                <td colspan="12" class="text-center">Data Pemesanan Tidak Tersedia</td>
                            </tr>
                            <?php
                        } else {
                            $jumlah = 1;
                            while ($data = mysqli_fetch_array($queryPesanan)) {
                                $download_link = $data['bukti_pembayaran'] ? '<a href="../download_bukti.php?id=' . $data['id'] . '">Download</a>' : 'Belum ada';
                            ?>
                                <tr>
                                    <td><?php echo $jumlah; ?></td>
                                    <td><?php echo $data['tanggal_order']; ?></td>
                                    <td><?php echo $data['nama_pembeli']; ?></td>
                                    <td><?php echo $data['nama_produk']; ?></td>
                                    <td><?php echo $data['jumlah']; ?></td>
                                    <td><?php echo $data['notelp']; ?></td>
                                    <td><?php echo $data['email']; ?></td>
                                    <td><?php echo $data['alamat']; ?></td>
                                    <td>Rp. <?php echo $data['total_harga']; ?></td>
                                    <td><?php echo $download_link; ?></td>
                                    <td><?php echo $data['status']; ?></td>
                                    <td>
                                        <a href="updateStatus.php?action=confirm&id=<?php echo $data['id']; ?>" class="btn btn-success btn-sm">Confirm</a>
                                        <a href="updateStatus.php?action=reject&id=<?php echo $data['id']; ?>" class="btn btn-danger btn-sm">Reject</a>
                                        <a href="javascript:void(0)" onclick="sendInvoice(<?php echo $data['id'];?>)" class="btn btn-primary btn-sm">Invoice</a>
                                        <form id="invoice-form-<?php echo $data['id'];?>" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                                            <input type="hidden" name="order_id" value="<?php echo $data['id'];?>">
                                            <input type="hidden" name="action" value="invoice">
                                        </form>
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
    <script>
        function sendInvoice(orderId) {
            document.getElementById('invoice-form-' + orderId).submit();
        }
    </script>
</body>

</html>