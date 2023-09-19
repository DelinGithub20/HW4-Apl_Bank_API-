<?php
class transferModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function transfer($fromAccountId, $toAccountId, $amount) {
        $query = "INSERT INTO transfer (id_pengirim, id_penerima, jumlah) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('iid', $fromAccountId, $toAccountId, $amount);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
?>