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
        if($control['Admin']== 1){
        echo "<a class=\"admin\"href=\"admin.php\">ADMIN</a><br>";
    }
}
?>
<!DOCTYPE html>
<head>
    <title>Mason's cinema</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <div class = "wrapper">
        <h1>Welcome <?php echo $_SESSION["Username"]; ?></h1>
        <a href="logout.php">Logout here</a><br>
        <a href="index.php">home page</a><br>
    </div>
    <div class = "body"></div>
        <?php
        include('connect.php');
        $query=$db->prepare("SELECT * FROM users WHERE Username=?");
        $query->execute(array($usename));
        $row = $query->fetch(PDO::FETCH_ASSOC);
        echo "<table>";
        echo "<tr><td>";
        echo "Your ID";
        echo "</td><td>";
        echo "Your username";
        echo "</td><td>";
        echo "Your email";
        echo "</td></tr>";
        echo "<tr><td>";
        echo $row['ID'];
        echo "</td><td>";
        echo $row['Username'];
        echo "</td><td>";
        echo $row['Email'];
        echo "</td><td>";
        echo "<a href=\"viewbookings.php?ID=".$row['ID']."\">View bookings</a>";
        echo "</td></tr>";
        echo "</table>";
        ?>
    </div>
</body>
</html>