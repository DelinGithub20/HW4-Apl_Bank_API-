<?php
header("Content-Type: application/json");

include_once 'koneksi.php';
include_once 'controllers/TransferController.php';

$response = ["status" => "error", "message" => "Invalid request"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fromAccountId = $_POST['fromAccountId'] ?? null;
    $toAccountId = $_POST['toAccountId'] ?? null;
    $amount = $_POST['amount'] ?? null;

    if ($fromAccountId && $toAccountId && $amount) {
        $transferController = new TransferController(getConnection());
        $response = $transferController->makeTransfer($fromAccountId, $toAccountId, $amount);
    } else {
        $response["message"] = "Incomplete data";
    }
}

echo json_encode($response);
?>