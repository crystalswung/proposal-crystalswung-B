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
    $userid = $control['ID'];
    $filmid =$_GET['ID'];
    if($control['Admin']== 1){
        echo "<a class=\"admin\"href=\"admin.php\">ADMIN</a><br>";
    }
    $query=$db->prepare("SELECT * FROM films WHERE ID=?");
    $query->execute(array($filmid));
    $booking=$query->fetch(PDO::FETCH_ASSOC);
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
        <a href="logout.php">Logout here</a><br>
        <a href="products.php">View products</a><br>
        <a href="index.php">Home page</a><br>
    </div>
    <div class="body">
    <?php
    include('connect.php');
    $query=$db->prepare("SELECT * FROM bookings WHERE CustID=?");
    $query->execute(array($userid));
    echo "<table>";
    echo "<tr><td>";
    echo "Confirmation ID";
    echo "</td><td>";
    echo "Your ID";
    echo "</td><td>";
    echo "Film name";
    echo "</td><td>";
    echo "How many tickets";
    echo "</td></tr>";
    while($row = $query->fetch(PDO::FETCH_ASSOC)){
        echo "<tr><td>";
        echo $row['ID'];
        echo "</td><td>";
        echo $row['CustID'];
        echo "</td><td>";
        echo $row['FilmID'];
        echo "</td><td>";
        echo $row['Tickets'];
        echo "</td><td>";
        echo "<a href=\"deletebooking.php?ID=".$row['ID']."\">Delete</a>";
        echo "</td><td>";
        echo "<a href=\"updatebooking.php?ID=".$row['ID']."\">Update</a>";
        echo "</td></tr>";
    }
    echo "</table>";

    ?>
    </div>
</body>
</html>