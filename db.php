<?php
session_start();
$host = "localhost";
$user = "urnrgaote95vf";
$password = "tgk9ztof7xb1";
$database = "dbiz2grgge6gol";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
