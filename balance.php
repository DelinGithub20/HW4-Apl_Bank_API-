<?php
include "koneksi.php";
$connection = getConnection();

// Pastikan ada parameter "id_akun" dalam permintaan HTTP
if (isset($_GET['id_akun'])) {
    $idAkun = $_GET['id_akun'];
    
    // Membuat query untuk mengambil saldo berdasarkan id_akun yang diberikan
    $query = "SELECT nomor_rekening, nama_pemilik, saldo FROM akun_bank WHERE id_akun = $idAkun";
    
    $result = mysqli_query($connection, $query);
    
    if ($result) {
        if ($row = mysqli_fetch_assoc($result)) {
            header('Content-Type: application/json');
            echo json_encode(array(
                'nomor_rekening' => $row['nomor_rekening'],
                'nama_pemilik' => $row['nama_pemilik'],
                'saldo' => $row['saldo']
            ));
        } else {
            // Jika data tidak ditemukan
            header("HTTP/1.1 404 Not Found");
            echo json_encode(array('pesan' => 'Data tidak ditemukan.'));
        }}
} else {
    // Jika parameter "id_akun" tidak diberikan dalam permintaan
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(array('pesan' => 'Parameter "id_akun" tidak diberikan dalam permintaan.'));
}
?>
