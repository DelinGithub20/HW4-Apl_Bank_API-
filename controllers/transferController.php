<?php
include_once '../models/balanceModel.php';
include_once '../models/transferModel.php';
include_once '../koneksi.php';

class TransferController {
    private $balanceModel;
    private $transferModel;


    public function __construct() {
        // koneksi database
        $db = getConnection(); 
        // objek model (buat account & transfer)
        $this->balanceModel = new balanceModel($db);
        $this->transferModel = new transferModel($db);
    }

    // transfer saldo
    public function makeTransfer($fromAccountId, $toAccountId, $amount) {
        // validasi kecukupan saldo
        $fromBalance = $this->balanceModel->getBalance($fromAccountId)['saldo'];
        if ($fromBalance < $amount) {
            return ["status" => "error", "message" => "Saldo tidak cukup, coba periksa kembali."];
        }

        // pengurangan saldo pengirim, penambahan saldo penerima, dan log data transfernya
        $deducted = $this->balanceModel->decreaseBalance($fromAccountId, $amount);
        $added = $this->balanceModel->addBalance($toAccountId, $amount);
        $transferred = $this->transferModel->transfer($fromAccountId, $toAccountId, $amount);

        // validasi keberhasilan transaksi
        if ($deducted && $added && $transferred) {
            return ["status" => "success", "message" => "Transfer sukses!"];
        } else {
            return ["status" => "error", "message" => "Transfer gagal !"];
        }
    }
}
?>
