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
        <a href="editproducts.php">Edit Products</a><br>
        <a href="addusers.php">Add a user</a><br>
    </div>
    <?php
    include('connect.php');
    $query = $db->query("SELECT * FROM users");
    echo "<table>";
    while($row = $query->fetch(PDO::FETCH_ASSOC)){
        echo "<tr><td>";
        echo $row['ID'];
        echo "</td><td>";
        echo $row['Username'];
        echo "</td><td>";
        echo $row['Email'];
        echo "</td><td>";
        echo $row['Admin'];
        echo "</td><td>";
        echo "<a href=\"deleteuser.php?ID=".$row['ID']."\">Delete</a>";
        echo "</td><td>";
        echo "<a href=\"updateuser.php?ID=".$row['ID']."\">Update</a>";
        echo "</td><tr>";
    }
    echo "</table>";

    ?>
</body>
</html>