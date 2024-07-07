<?php
// Pastikan koneksi database sudah terhubung
include 'koneksi.php';

// Tangkap data dari form
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$items = json_decode($_POST['items'], true); // Ubah JSON items menjadi array PHP
$total = $_POST['total'];

// Buat query untuk menyimpan data ke dalam tabel pesanan
$query = "INSERT INTO pesanan (tanggal_order, nama_produk, jumlah, nama_pembeli, notelp, email, alamat, total_harga, status) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, 'Pending')";

// Persiapkan statement SQL
$stmt = $con->prepare($query);

foreach ($items as $item) {
    $nama_produk = $item['nama'];
    $jumlah = $item['quantity'];

    // Bind parameter
    $stmt->bind_param("sissssd", $nama_produk, $jumlah, $name, $phone, $email, $address, $total);
    $stmt->execute();
}

// Dapatkan ID pesanan terakhir yang dimasukkan
$order_id = $stmt->insert_id;

// Tutup statement
$stmt->close();

// Tutup koneksi database
$con->close();

// Arahkan pengguna ke halaman instruksi pembayaran
header("Location: payment_instruction.php?order_id=$order_id&total_harga=$total");
exit();
?>
