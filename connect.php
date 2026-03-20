<?php

$conn = mysqli_connect("localhost","Admin","Admin123","Cinema");

try {

$db = new PDO(dsn: "mysql:host=localhost;dbname=Cinema;charset=utf8", username: "Admin", password: "Admin123");

} catch (PDOException $e) {
    echo $e->getMessage();
};

?>