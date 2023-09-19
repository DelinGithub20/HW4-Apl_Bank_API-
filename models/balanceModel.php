<?php
class balanceModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getBalance($accountId) {
        $query = "SELECT saldo FROM akun_bank WHERE id_akun = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $accountId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function decreaseBalance($accountId, $amount) {
        $query = "UPDATE akun_bank SET saldo = saldo - ? WHERE id_akun = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('di', $amount, $accountId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function addBalance($accountId, $amount) {
        $query = "UPDATE akun_bank SET saldo = saldo + ? WHERE id_akun = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('di', $amount, $accountId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
?>