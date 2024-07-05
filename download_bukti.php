<?php
// pastikan koneksi database sudah terhubung
include 'koneksi.php';

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Ambil bukti pembayaran berdasarkan ID pesanan
    $query = "SELECT bukti_pembayaran FROM pesanan WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->bind_result($bukti_pembayaran);
    $stmt->fetch();
    $stmt->close();


    // Cek apakah bukti pembayaran ada
    if ($bukti_pembayaran) {
        $file_path = $bukti_pembayaran;

        if (file_exists($file_path)) {
            // Atur header untuk mengunduh file
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            flush(); // Bersihkan buffer sistem
            readfile($file_path);
            exit;
        } else {
            echo "File tidak ditemukan.";
        }
    } else {
        echo "Bukti pembayaran tidak tersedia.";
    }
} else {
    echo "ID pesanan tidak diberikan.";
}
?>
