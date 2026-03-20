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

    include 'connect.php';

    if($conn->connect_error) {
        die("Connection Failed:".$conn->connect_error);
    }

    $results = [];

    if(isset($_GET['film'])) {
        $film =$_GET['film'];
    }

    $stmt = $conn->prepare("Select name, description FROM films WHERE name like ?");
    $searchterm = "%".$film."%";
    $stmt->bind_param("s", $searchterm);
    $stmt->execute();
    $results = $stmt->get_result();
    
    while($row = $result->fetch_assoc()) {
        $results[] = $row;
    }


?>

<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="stylesheet.css">
    <title>Mason's cinema</title>
</head>
<body>
    <h1>Search for a Film</h1>
    <form action="search.php" method="GET">
        <label for="film">Film title:</label>
        <input type="text" name="film" id="film" required>
        <input type="submit" name="submit" value="Search">
    </form>

    <?php if(!empty($results)); ?>
    <h2>Results</h2>
    <table table-border = "1"cellpadding="8"></table>
    <tr>
        <th>Film Name</th>
        <th>Discription</th>
    </tr>
    <?php foreach($results as $result): ?>
    <tr>
        <td><?= htmlspecialchars(string: $results['name']);?></td>
        <td><?= htmlspecialchars(string: $results['description']);?></td>
    </tr>
        <?php endforeach; ?>
    </table>
    <?php elseif(isset($_GET['film'])): ?>
        <p>No Search Results</p>
    <?php endif; ?>

</body>
</html>