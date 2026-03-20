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
    $name = $description = $cert = $trailer = "";
    $errors = array('name'=>'','description'=>'','cert'=>'','trailer'=>'');
    $errorflag = 0;

    if(isset($_POST["submit"])) {   
        if(empty($_POST["name"])) {
            $errors['name'] = "Name is empty.<br>";
            $errorflag = 1;
        } else {
            $name = $_POST[""];
        }
        if(empty($_POST["description"])) {
            $errors['description'] = "description is empty.<br>";
            $errorflag = 1;
        } else {
            $description = $_POST["description"];
        }
        if(empty($_POST["cert"])) {
            $errors['cert'] = "Cert is empty.<br>";
            $errorflag = 1;
        } else {
            $cert = $_POST["cert"];
        }
        if(empty($_POST["trailer"])) {
            $errors['trailer'] = "trailer is empty.<br>";
            $errorflag = 1;
        } else {
            $trailer = $_POST["trailer"];
        }
        if($errorflag == 1) {
            echo 'Errors in Form';
        } else {
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $cert = mysqli_real_escape_string($conn, $_POST['cert']);
            $trailer = mysqli_real_escape_string($conn, $_POST['trailer']);
            $sql = "INSERT into films (name, description, cert, trailer) VALUES ('$name','$description','$cert','$trailer')";
            if(mysqli_query($conn, $sql)) {
                header('location: admin.php');
            } /*else {
                echo 'Error'.mysql_error($conn);
            }*/
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
    <h1>Welcome <?php echo $_SESSION["Username"]; ?></h1>
    <a href="logout.php">Logout here</a><br>
<div>
    <form action="add.php" method="POST">
        <label>Film name</label>
        <input type="text" name="name"><br>
        <label>Description</label>
        <input type="text" name="Description"><br>
        <label>Cert</label>
        <input type="text" name="Cert"><br>
        <label>youtube embed</label>
        <textarea name="trailer" cols="40" rows="10"></textarea><br>
        <input type="submit" value="submit" name="submit">
    </form>
</div>

</body>
</html>