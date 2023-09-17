<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "api_perbankan";

$connection = mysqli_connect($servername, $username, $password, $database);

if (!$connection) {
    die("Koneksi gagal : ". mysqli_connect_error());
}

?>