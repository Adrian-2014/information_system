<?php

$server = "localhost";
$username = "root";
$password = "";
$database = "system_information";

$connect = mysqli_connect($server, $username, $password, $database);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}