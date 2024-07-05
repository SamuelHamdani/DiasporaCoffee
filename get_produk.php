<?php
    // Koneksi ke database
    require "koneksi.php";

    // Retrieve data from produk table
    $sql = "SELECT id, nama, harga, foto, detail, stok FROM produk";
    $result = mysqli_query($con, $sql);

    // Create an array to store the data
    $products = array();

    while ($row = mysqli_fetch_assoc($result)) {
        // Ensure harga is treated as a number
        $row['harga'] = (int) $row['harga'];
        $products[] = $row;
    }

    // Close connection
    mysqli_close($con);

    // Output the data in JSON format
    echo json_encode($products);
?>
