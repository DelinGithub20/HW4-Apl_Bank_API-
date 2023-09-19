<?php
function getConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "api_perbankan";

    $connection = mysqli_connect($servername, $username, $password, $database);

    if (!$connection) {
        die("Waduh, koneksi ke database gagal nih : ". mysqli_connect_error());
    }

    return $connection;
}
?>
