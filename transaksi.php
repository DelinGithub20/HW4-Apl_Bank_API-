<?php

include_once 'koneksi.php';
$connection = getConnection();

// Endpoint untuk mengambil data transaksi seorang user berdasarkan id_akun

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id_akun'])) {
    $idAkun = $_GET['id_akun'];

    $sql = "SELECT * FROM transfer WHERE id_pengirim = $idAkun OR id_penerima = $idAkun";
    $result = mysqli_query($connection, $sql);

    if (!$result) {
        die("Kueri SQL gagal: " . mysqli_error($connection));
    }

    $transactions = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $transactions[] = $row;
    }

    header("Content-Type: application/json");
    echo json_encode($transactions);
} else {
    // Menangani jika id_akun kosong, atau metode HTTP bukan GET
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(array('pesan' => 'Parameter "id_akun" tidak diberikan atau metode request salah.'));
}

?>
