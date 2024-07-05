<?php
// Pastikan koneksi database sudah terhubung
require_once "../koneksi.php";

// Ambil nilai action dan order_id dari parameter GET
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $order_id = $_GET['id'];

    // Lakukan pengecekan aksi yang dilakukan
    if ($action == 'confirm') {
        // Lakukan update status menjadi 'confirmed'
        $query = "UPDATE pesanan SET status = 'Confirmed' WHERE id = ?";
    } elseif ($action == 'reject') {
        // Lakukan update status menjadi 'rejected'
        $query = "UPDATE pesanan SET status = 'Rejected' WHERE id = ?";
    } else {
        // Aksi tidak valid, redirect atau berikan pesan error
        header('Location: pesanan.php');
        exit();
    }

    // Persiapkan statement SQL
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();
}

// Redirect kembali ke halaman pesanan setelah melakukan aksi
header('Location: pemesanan.php');
exit();
?>
