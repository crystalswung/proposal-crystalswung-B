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

    $name = $description = $price = "";
    $errors = array('name'=>'','description'=>'','price'=>'');
    $errorflag = 0;

    if(isset($_POST["submit"])) {   
        if(empty($_POST["name"])) {
            $errors['name'] = "Name is empty.<br>";
            $errorflag = 1;
        } else {
            $name = $_POST["name"];
        }
        if(empty($_POST["description"])) {
            $errors['description'] = "Description is empty.<br>";
            $errorflag = 1;
        } else {
            $description = $_POST["description"];
        }
        if(empty($_POST["price"])) {
            $errors['price'] = "Price is empty.<br>";
            $errorflag = 1;
        } else {
            $price = $_POST["price"];
        }

        if($errorflag == 1) {
            echo 'Errors in Form';
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $price = mysqli_real_escape_string($conn, $_POST['price']);    
        } else {
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $price = mysqli_real_escape_string($conn, $_POST['price']); 
            $sql = "INSERT into products (name, description, price) VALUES ('$name','$description','$price')";
            if(mysqli_query($conn, $sql)) {
                header('location: admin.php');
            } else {
                echo 'Error'.mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<head>
    <title>Mason's cinema</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body class="wrapper">
    <h1>Welcome <?php echo $_SESSION["Username"]; ?></h1>
    <a href="admin.php">Admin menu</a><br>
    <a href="editfilms.php">Edit users</a><br>
<div>
    <form action="addproduct.php" method="POST">
        <label>Product name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"><br><br>
        <div><?php echo $errors['name']; ?></div>
        <label>Description</label>
        <input type="text" name="description" value="<?php echo htmlspecialchars($description); ?>"><br><br>
        <div><?php echo $errors['description']; ?></div>
        <label>Cert</label>
        <input type="text" name="price" value="<?php echo htmlspecialchars($price); ?>"><br><br>
        <div><?php echo $errors['price']; ?></div>
        <input type="submit" value="submit" name="submit">
    </form>
</div>

</body>
</html>