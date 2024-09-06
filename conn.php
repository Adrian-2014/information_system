<?php

$server = "localhost";
$username = "root";
$password = "";
$database = "information_system";

$connect = mysqli_connect($server, $username, $password, $database);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}