<?php
$conn =mysqli_connect("localhost","root","","hotel");
if ($conn->connect_error) {
    die("erreur Conx " . $conn->connect_error);
}