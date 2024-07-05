<?php
include 'session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruksi Pembayaran</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    // Mengambil order_id dari URL
    $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';
    ?>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2>Instruksi Pembayaran</h2>
            </div>
            <div class="card-body">
                <p>Silakan lakukan pembayaran ke rekening berikut:</p>
                <p>Bank: BCA<br>No. Rekening: 4730767761<br>Atas Nama: Harry Erlangga Kusumah</p>
                <p>Batas pembayaran dilakukan sampai hari ini di jam 23.59 WIB, lewat dari jam ini pesanan akan dibatalkan</p>
                <p><span style="color:red;">REMINDER</span>: Jangan keluar dari halaman ini jika belum melakukan pembayaran</p>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h3>Upload Bukti Pembayaran</h3>
            </div>
            <div class="card-body">
                <form action="upload_bukti.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="order_id">Order ID:</label>
                        <input type="text" class="form-control" name="order_id" id="order_id" value="<?php echo htmlspecialchars($order_id); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="payment_proof">Bukti Pembayaran:</label>
                        <input type="file" class="form-control-file" name="payment_proof" id="payment_proof" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
