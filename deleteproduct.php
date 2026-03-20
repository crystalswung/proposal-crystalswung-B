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

    if(isset($_GET['ID'])){
        $ID = $_GET['ID'];
        $sql = 'DELETE FROM products WHERE ID = :ID';
        $stmt = $db->prepare($sql);
        $stmt->execute(['ID'=> $ID]);
    }

}
?>
<!DOCTYPE html>
<head>
    <title>Mason's cinema</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <h1>Welcome <?php echo $_SESSION["Username"]; ?></h1>
    <a href="logout.php">Logout here</a><br>
    <a href="addfilm.php">Add a Film</a><br>
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
        echo "<a href=\"delete.php?ID=".$row['ID']."\">Delete</a>";
        echo "</td><td>";
        echo "<a href=\"update.php?ID=".$row['ID']."\">Update</a>";
        echo "</td><tr>";
    }
    echo "<table>";

    ?>
</body>
</html>