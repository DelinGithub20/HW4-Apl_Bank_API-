<?php
header("Content-Type: application/json");

// Koneksi ke database
include "./koneksi.php";
$connection = getConnection();

$response = ["status" => "error", "message" => "Invalid request"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fromAccountId = $_POST['fromAccountId'] ?? null;
    $toAccountId = $_POST['toAccountId'] ?? null;
    $amount = $_POST['amount'] ?? null;

    if ($fromAccountId && $toAccountId && $amount) {
        // Ambil saldo akun pengirim
        $sql = "SELECT saldo FROM akun_bank WHERE id_akun = $fromAccountId";
        $result = mysqli_query($connection, $sql);
        $fromAccount = mysqli_fetch_assoc($result);
        
        if ($fromAccount['saldo'] >= $amount) {
            // Mulai transaksi
            mysqli_begin_transaction($connection);

            // Kurangi saldo akun pengirim
            $deduct = "UPDATE akun_bank SET saldo = saldo - $amount WHERE id_akun = $fromAccountId";
            mysqli_query($connection, $deduct);

            // Tambah saldo akun penerima
            $add = "UPDATE akun_bank SET saldo = saldo + $amount WHERE id_akun = $toAccountId";
            mysqli_query($connection, $add);

            // Catat transfer
            $transferLog = "INSERT INTO transfer (id_pengirim, id_penerima, jumlah) VALUES ($fromAccountId, $toAccountId, $amount)";
            mysqli_query($connection, $transferLog);

            // Komit transaksi jika semuanya berjalan lancar
            if (mysqli_commit($connection)) {
                $response["status"] = "success";
                $response["message"] = "Transfer successful";
            } else {
                mysqli_rollback($connection);
                $response["message"] = "Transfer failed";
            }
        } else {
            $response["message"] = "Insufficient balance";
        }
    } else {
        $response["message"] = "Incomplete data";
    }
}

echo json_encode($response);
?>
