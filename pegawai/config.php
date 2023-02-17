<?php
$server = "localhost";
$user = "root";
$password = "";
$nama_database = "db_pegawai";

$db = mysqli_connect($server, $user, $password, $nama_database);

if (!$db ){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
