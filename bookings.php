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
    $bookfilm=$query->fetch(PDO::FETCH_ASSOC);
    $bookid = $bookfilm['ID'];
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
    <div>
        <?php
        echo "<table>";
        echo "<tr><td>";
        echo $bookfilm['name'];
        echo "</td><td>";
        echo "<form action=\"bookings2.php\" method=\"POST\">";
        echo "Number of tickets";
        echo "<select name=\"tickets\" id=\"tickets\" 
        <option value=0>0</option>
        <option value=1>1</option>
        <option value=2>2</option>
        <option value=3>3</option>
        <option value=4>4</option>
        <option value=5>5</option>
        <option value=6>6</option>
        <option value=7>7</option>
        <option value=8>8</option>
        <option value=9>9</option>
        <option value=10>10</option>
        </select>";
        echo "<input type=\"hidden\" id=\"userid\" name=\"userid\" value=\"".$userid."\">";
        echo "<input type=\"hidden\" id=\"filmid\" name=\"filmid\" value=\"".$bookid."\">";
        echo "<br><br>";
        echo "<input type=\"submit\" name=\"submit\" value=\"submit\">";
        echo "</td></tr>";
        echo "</table>";
        echo "</form>";
        ?>
    </div>
</body>
</html>