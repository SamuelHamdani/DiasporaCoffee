<?php
include 'koneksi.php';

// Periksa apakah ada ID pesanan dalam URL atau POST
if (!isset($_GET['order_id']) && !isset($_POST['order_id'])) {
    die("Order ID tidak ditemukan.");
}

$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : $_POST['order_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = 'Paid';

    // Periksa apakah ada file yang diunggah
    if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] == 0) {
        $file_tmp = $_FILES['payment_proof']['tmp_name'];
        $file_name = $_FILES['payment_proof']['name'];
        $file_destination = 'uploads/' . $file_name;

        // Pindahkan file ke folder tujuan
        if (move_uploaded_file($file_tmp, $file_destination)) {
            // Update pesanan dengan bukti pembayaran dan status
            $query = "UPDATE pesanan SET status = ?, bukti_pembayaran = ? WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("ssi", $status, $file_destination, $order_id);

            if ($stmt->execute()) {
                echo "Bukti pembayaran berhasil diunggah.";
                header('location: index.php');

            } else {
                echo "Gagal mengunggah bukti pembayaran.";
            }

            $stmt->close();
        } else {
            echo "Gagal memindahkan file.";
            header('location: index.php');
        }
    } else {
        echo "Tidak ada file yang diunggah atau terjadi kesalahan saat mengunggah.";
        header('location: index.php');

    }
}

$con->close();
?>
