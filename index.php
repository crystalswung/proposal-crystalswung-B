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
    <title>Mason's Cinema</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <div class="wrapper">
        <h1>Welcome <?php echo $_SESSION["Username"]; ?></h1>
        <br>Login Success.<br>
        <a href="logout.php">Logout here</a><br>
        <a href="films.php">Films</a><br>
        <a href="products.php">Products</a><br>
        <a href="user.php">My info</a>
    </div>
</body>
</html>