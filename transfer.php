<?php
header("Content-Type: application/json");

include_once 'koneksi.php';

$response = ["status" => "error", "message" => "Invalid request"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fromAccountId = $_POST['fromAccountId'] ?? null;
    $toAccountId = $_POST['toAccountId'] ?? null;
    $amount = $_POST['amount'] ?? null;

    $connection = getConnection(); // Menggunakan fungsi untuk mendapatkan koneksi

    if ($fromAccountId && $toAccountId && $amount) {
        $currentBalanceQuery = "SELECT saldo FROM akun_bank WHERE id_akun = '$fromAccountId'";
        $currentBalanceResult = mysqli_query($connection, $currentBalanceQuery);
        $currentBalanceData = mysqli_fetch_assoc($currentBalanceResult);
        $currentBalance = $currentBalanceData['saldo'] ?? 0;

        if ($currentBalance < $amount) {
            $response["message"] = "Saldo tidak mencukupi";
        } else {
            $deductQuery = "UPDATE akun_bank SET saldo = saldo - $amount WHERE id_akun = '$fromAccountId'";
            $addQuery = "UPDATE akun_bank SET saldo = saldo + $amount WHERE id_akun = '$toAccountId'";

            mysqli_begin_transaction($connection);

            $deducted = mysqli_query($connection, $deductQuery);
            $added = mysqli_query($connection, $addQuery);

            if ($deducted && $added) {
                mysqli_commit($connection);
                $response["status"] = "success";
                $response["message"] = "Transfer berhasil";
            } else {
                mysqli_rollback($connection);
                $response["message"] = "Transfer gagal";
            }
        }
    } else {
        $response["message"] = "Data tidak lengkap";
    }
}

echo json_encode($response);

?>
