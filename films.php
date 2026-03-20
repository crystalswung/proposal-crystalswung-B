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
    <div class="wrapper">
        <h1>Welcome <?php echo $_SESSION["Username"]; ?></h1>
        <a href="logout.php">Logout here</a><br>
        <a href="products.php">View products</a><br>
        <a href="Search.php">Search for a film</a><br>
        <a href="index.php">Home page</a><br>
    </div>
    <div>
        <?php include 'connect.php';
        $query = $db->query("SELECT * FROM films");
        echo "<table>";
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>";
            echo $row['name'];
            echo "</td><td>";
            echo $row['description'];
            echo "</td><td>";
            echo $row['cert'];
            echo "</td><td>";
            echo $row['trailer'];
            echo "</td><td>";
            echo "<a href=\"bookings.php?ID=".$row['ID']."\">Book here</a>";
            echo "</td></tr>";
        }
        echo "</table>"; ?>
    </div>
</body>
</html>