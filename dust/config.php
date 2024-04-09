<?php

$servername = "127.0.0.1";
$username = "jaffnama_agricultureapp";
$password = "Bx9Q~7oNQYoR";
$dbname = "jaffnama_agricultureapp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>