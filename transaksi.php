<?php

include_once 'koneksi.php';
// Endpoint untuk mengambil data transaksi

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $sql = "SELECT * FROM transfer";
    $result = mysqli_query($connection, $sql);

    if (!$result) {
        die("Kueri SQL gagal: " . mysqli_error($connection));
    }

    $transactions = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $transactions[] = $row;
    }

    // Mengirim data dalam format JSON
    header("Content-Type: application/json");
    echo json_encode($transactions);
}

?>