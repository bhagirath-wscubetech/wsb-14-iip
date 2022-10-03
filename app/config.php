<?php
error_reporting(0);

try {
    $conn = mysqli_connect("localhost", "root", "", "iip");
    // hostname, username, password, db_name
} catch (Exception $err) {
    // echo $err->getMessage();
    die("Connection error");
}
