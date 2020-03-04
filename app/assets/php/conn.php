<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 30.01.2020
 * Time: 09:59
 */

$servername = "localhost";
$username = "";
$password = "";

// Create connection
$conn = mysqli_connect($servername, $username, $password,"");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
