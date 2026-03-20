<?php

session_start();

if(!isset($_SESSION["Username"])) {
    header("Location: login.php");
}
else{
    include 'connect.php';
    $usename = $_SESSION["Username"];
    $query=$db->prepare("SELECT * FROM users WHERE Username=?");
    $query->execute(array($usename));
    $control=$query->fetch(PDO::FETCH_ASSOC);
        if($control['Admin']!= 1){
        header("Location:index.php");
    }
}
?>
<!DOCTYPE html>
<head>
    <title>Mason's cinema</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <div class="wrapper">
        <h1>Welcome <?php echo $_SESSION["Username"]; ?></h1>
        <a href="admin.php">Admin menu</a><br>
        <a href="addproduct.php">Add a Product</a><br>
        <a href="editusers.php">Edit users</a><br>
    </div>
    <?php
    include('connect.php');
    $query = $db->query("SELECT * FROM products");
    echo "<table>";
    while($row = $query->fetch(PDO::FETCH_ASSOC)){
        echo "<tr><td>";
        echo $row['name'];
        echo "</td><td>";
        echo $row['description'];
        echo "</td><td>";
        echo $row['price'];
        echo "</td><td>";
        echo "<a href=\"deleteproduct.php?ID=".$row['ID']."\">Delete</a>";
        echo "</td><td>";
        echo "<a href=\"updateproduct.php?ID=".$row['ID']."\">Update</a>";
        echo "</td><tr>";
    }
    echo "</table>";

    ?>
</body>
</html>