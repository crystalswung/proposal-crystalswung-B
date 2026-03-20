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
    if(isset($_POST['submit'])){
        $filmid = $_POST['filmid'];
        $userid = $_POST['userid'];
        $tickets = $_POST['tickets'];

        $sql = "INSERT into bookings (CustId, FilmID, Tickets) VALUES ('$userid','$filmid','$tickets')";
        if(mysqli_query($conn, $sql)){
            $query=$db->prepare("SELECT * FROM films WHERE ID=$filmid");
            $query->execute(array($filmid));
            $bookfilm=$query->fetch(PDO::FETCH_ASSOC);
            $bookid = $bookfilm['ID'];
            $filmname = $bookfilm['name'];
        }
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
        <a href="index.php">Home page</a><br>
    </div>
    <div class="body">
        <?php 
        echo"booking successful <br>";
        echo "You have booked ".$tickets." tickets for ".$filmname."<br>";
        ?>
    </div>
</body>
</html>