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
        <a href="films.php">Films</a><br>
        <a href="index.php">Home page</a><br>
    </div>
    <div class="body">
    <?php include 'connect.php';
    $query = $db->query("SELECT * FROM products");
    echo "<table>";
    while($row = $query->fetch(PDO::FETCH_ASSOC)) {
    echo "<div class=\"body\">
    <label>
        <input type=\"checkbox\" data-price=\"".$row['price']."\">".$row['name']." ".$row['description']."
    </label>
        Qty: <input type=\"number\" width=\"4\" value=\"1\" min=\"1\" disabled>
    </div>";
    } 
    echo "</table>"; ?>
    <h2>Total: £<span id="total">0.00</span></h2>

    <button id="clearAll">Clear All</button>
    <button id="checkout">Checkout</button>
    </div>
</body>
</html>